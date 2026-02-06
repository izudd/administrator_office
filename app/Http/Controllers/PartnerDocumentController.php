<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\PartnerCategory;
use App\Models\PartnerDocument;
use App\Models\RevenueTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PartnerDocumentController extends Controller
{
    public function index()
    {
        $categories = PartnerCategory::withCount('documents')->orderBy('name')->get();

        // Document Stats
        $totalDocuments = PartnerDocument::count();
        $totalPartners = PartnerDocument::distinct('partner_name')->count('partner_name');
        $activeDocuments = PartnerDocument::active()->count();
        $expiringSoon = PartnerDocument::expiringSoon(30)->count();

        // Calculate total storage
        $totalStorageBytes = PartnerDocument::sum('file_size');
        if ($totalStorageBytes >= 1073741824) {
            $totalStorage = number_format($totalStorageBytes / 1073741824, 2) . ' GB';
        } elseif ($totalStorageBytes >= 1048576) {
            $totalStorage = number_format($totalStorageBytes / 1048576, 2) . ' MB';
        } elseif ($totalStorageBytes >= 1024) {
            $totalStorage = number_format($totalStorageBytes / 1024, 2) . ' KB';
        } else {
            $totalStorage = $totalStorageBytes . ' B';
        }

        // Partner Management Stats
        $partners = Partner::withCount('documents', 'revenueTransactions')->orderBy('company_name')->get();
        $totalPartnersManaged = Partner::count();
        $activePartnersCount = Partner::active()->count();
        $pendingPartnersCount = Partner::where('status', 'pending')->count();
        $expiredContracts = Partner::expiredContracts()->count();

        // Revenue Stats
        $totalRevenue = RevenueTransaction::paid()->sum('net_amount');
        $pendingRevenue = RevenueTransaction::pending()->sum('net_amount');
        $thisMonthRevenue = RevenueTransaction::paid()
            ->whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->sum('net_amount');

        // Revenue by month (last 6 months)
        $revenueByMonth = RevenueTransaction::paid()
            ->where('payment_date', '>=', now()->subMonths(6))
            ->selectRaw('YEAR(payment_date) as year, MONTH(payment_date) as month, SUM(net_amount) as total')
            ->groupByRaw('YEAR(payment_date), MONTH(payment_date)')
            ->orderByRaw('YEAR(payment_date), MONTH(payment_date)')
            ->get();

        // Partnership model distribution
        $partnershipDistribution = Partner::selectRaw('partnership_model, COUNT(*) as count')
            ->groupBy('partnership_model')
            ->pluck('count', 'partnership_model')
            ->toArray();

        // Top partners by revenue
        $topPartners = Partner::withSum(['revenueTransactions as total_revenue' => function ($q) {
            $q->where('payment_status', 'paid');
        }], 'net_amount')
            ->orderByDesc('total_revenue')
            ->limit(5)
            ->get();

        return view('partner-documents.index', compact(
            'categories',
            'totalDocuments',
            'totalPartners',
            'activeDocuments',
            'expiringSoon',
            'totalStorage',
            'partners',
            'totalPartnersManaged',
            'activePartnersCount',
            'pendingPartnersCount',
            'expiredContracts',
            'totalRevenue',
            'pendingRevenue',
            'thisMonthRevenue',
            'revenueByMonth',
            'partnershipDistribution',
            'topPartners'
        ));
    }

    // ==========================================
    // CATEGORY CRUD (Existing)
    // ==========================================

    public function createCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'color' => 'nullable|string|max:20',
        ]);

        $category = PartnerCategory::create([
            'name' => $request->name,
            'description' => $request->description,
            'color' => $request->color ?? '#10b981',
        ]);

        $path = storage_path("app/public/partner-documents/{$request->name}");
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        return response()->json([
            'success' => true,
            'category' => $category,
            'message' => 'Category created successfully'
        ]);
    }

    public function renameCategory(Request $request)
    {
        $request->validate([
            'old_name' => 'required|string',
            'new_name' => 'required|string|max:255',
        ]);

        try {
            $category = PartnerCategory::where('name', $request->old_name)->firstOrFail();
            $oldName = $category->name;
            $category->name = $request->new_name;
            $category->save();

            $oldPath = storage_path("app/public/partner-documents/{$oldName}");
            $newPath = storage_path("app/public/partner-documents/{$request->new_name}");
            if (File::exists($oldPath)) {
                File::move($oldPath, $newPath);
            }

            $newName = $request->new_name;
            PartnerDocument::where('category_id', $category->id)->get()->each(function ($doc) use ($oldName, $newName) {
                $doc->file_path = str_replace("partner-documents/{$oldName}/", "partner-documents/{$newName}/", $doc->file_path);
                $doc->save();
            });

            return response()->json(['success' => true, 'message' => 'Category renamed successfully']);
        } catch (\Exception $e) {
            Log::error('Rename category error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        try {
            $category = PartnerCategory::where('name', $request->name)->firstOrFail();

            $folderPath = storage_path("app/public/partner-documents/{$request->name}");
            if (File::exists($folderPath)) {
                File::deleteDirectory($folderPath);
            }

            $category->delete();

            return response()->json(['success' => true, 'message' => 'Category deleted successfully']);
        } catch (\Exception $e) {
            Log::error('Delete category error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // ==========================================
    // DOCUMENT OPERATIONS (Existing)
    // ==========================================

    public function getDocuments($categoryId)
    {
        try {
            $category = PartnerCategory::findOrFail($categoryId);
            $documents = $category->documents()
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($doc) {
                    return [
                        'id' => $doc->id,
                        'partner_name' => $doc->partner_name,
                        'document_type' => $doc->document_type,
                        'file_name' => $doc->file_name,
                        'file_path' => $doc->file_path,
                        'file_type' => $doc->file_type,
                        'file_size' => $doc->formatted_file_size,
                        'document_date' => $doc->document_date?->format('d M Y'),
                        'expiry_date' => $doc->expiry_date?->format('d M Y'),
                        'status' => $doc->status,
                        'notes' => $doc->notes,
                        'is_expired' => $doc->isExpired(),
                        'is_expiring_soon' => $doc->isExpiringSoon(),
                        'url' => asset('storage/' . $doc->file_path),
                    ];
                });

            return response()->json($documents);
        } catch (\Exception $e) {
            Log::error('Get documents error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function uploadDocument(Request $request, $categoryId)
    {
        try {
            $request->validate([
                'file' => 'required|file|max:51200',
                'partner_name' => 'required|string|max:255',
                'document_type' => 'required|string|max:100',
                'document_date' => 'nullable|date',
                'expiry_date' => 'nullable|date',
                'notes' => 'nullable|string',
            ]);

            $category = PartnerCategory::findOrFail($categoryId);
            $file = $request->file('file');

            $path = $file->storeAs(
                "partner-documents/{$category->name}",
                $file->getClientOriginalName(),
                'public'
            );

            $document = PartnerDocument::create([
                'category_id' => $category->id,
                'partner_name' => $request->partner_name,
                'document_type' => $request->document_type,
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_type' => $file->getClientOriginalExtension(),
                'file_size' => $file->getSize(),
                'document_date' => $request->document_date,
                'expiry_date' => $request->expiry_date,
                'status' => 'active',
                'notes' => $request->notes,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Document uploaded successfully',
                'document' => $document
            ]);
        } catch (\Exception $e) {
            Log::error('Upload document error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteDocument(Request $request, $documentId)
    {
        try {
            $document = PartnerDocument::findOrFail($documentId);

            $filePath = 'public/' . $document->file_path;
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }

            $document->delete();

            return response()->json(['success' => true, 'message' => 'Document deleted successfully']);
        } catch (\Exception $e) {
            Log::error('Delete document error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function updateDocument(Request $request, $documentId)
    {
        try {
            $request->validate([
                'partner_name' => 'sometimes|string|max:255',
                'document_type' => 'sometimes|string|max:100',
                'document_date' => 'nullable|date',
                'expiry_date' => 'nullable|date',
                'status' => 'sometimes|in:draft,active,expired,archived',
                'notes' => 'nullable|string',
            ]);

            $document = PartnerDocument::findOrFail($documentId);
            $document->update($request->only([
                'partner_name',
                'document_type',
                'document_date',
                'expiry_date',
                'status',
                'notes'
            ]));

            return response()->json(['success' => true, 'message' => 'Document updated successfully']);
        } catch (\Exception $e) {
            Log::error('Update document error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function previewDocument($documentId)
    {
        $document = PartnerDocument::findOrFail($documentId);
        $path = storage_path('app/public/' . $document->file_path);

        if (!file_exists($path)) {
            abort(404, 'File not found');
        }

        $mimeType = mime_content_type($path);

        return response()->file($path, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $document->file_name . '"',
        ]);
    }

    public function downloadDocument($documentId)
    {
        $document = PartnerDocument::findOrFail($documentId);
        $path = storage_path('app/public/' . $document->file_path);

        if (!file_exists($path)) {
            abort(404, 'File not found');
        }

        return response()->download($path, $document->file_name);
    }

    // ==========================================
    // PARTNER MANAGEMENT (New from PMS)
    // ==========================================

    public function getPartners(Request $request)
    {
        $query = Partner::withCount('documents', 'revenueTransactions');

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('company_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('contact_person_name', 'like', "%{$search}%");
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->partnership_model) {
            $query->where('partnership_model', $request->partnership_model);
        }

        $partners = $query->orderBy('company_name')->get()->map(function ($partner) {
            return [
                'id' => $partner->id,
                'company_name' => $partner->company_name,
                'company_type' => $partner->company_type,
                'email' => $partner->email,
                'phone' => $partner->phone,
                'city' => $partner->city,
                'partnership_model' => $partner->partnership_model,
                'status' => $partner->status,
                'contract_start_date' => $partner->contract_start_date?->format('d M Y'),
                'contract_end_date' => $partner->contract_end_date?->format('d M Y'),
                'is_contract_expired' => $partner->isContractExpired(),
                'contact_person_name' => $partner->contact_person_name,
                'contact_person_position' => $partner->contact_person_position,
                'documents_count' => $partner->documents_count,
                'revenue_transactions_count' => $partner->revenue_transactions_count,
                'total_revenue' => $partner->total_revenue,
                'monthly_fee' => $partner->monthly_fee,
                'revenue_share_percentage' => $partner->revenue_share_percentage,
                'equity_percentage' => $partner->equity_percentage,
            ];
        });

        return response()->json($partners);
    }

    public function storePartner(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_type' => 'required|string|max:50',
            'email' => 'required|email|unique:partners,email',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'country' => 'nullable|string|max:100',
            'npwp' => 'nullable|string|max:50',
            'partnership_model' => 'required|in:equity,revenue_share,subscription,project_based',
            'status' => 'sometimes|in:active,inactive,pending,suspended,terminated',
            'contract_start_date' => 'nullable|date',
            'contract_end_date' => 'nullable|date',
            'equity_percentage' => 'nullable|numeric|min:0|max:100',
            'revenue_share_percentage' => 'nullable|numeric|min:0|max:100',
            'monthly_fee' => 'nullable|numeric|min:0',
            'contact_person_name' => 'nullable|string|max:255',
            'contact_person_email' => 'nullable|email|max:255',
            'contact_person_phone' => 'nullable|string|max:30',
            'contact_person_position' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        try {
            $partner = Partner::create($request->all());

            return response()->json([
                'success' => true,
                'partner' => $partner,
                'message' => 'Partner created successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Create partner error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getPartner($id)
    {
        try {
            $partner = Partner::with(['revenueTransactions' => function ($q) {
                $q->orderBy('created_at', 'desc');
            }])->withCount('documents', 'revenueTransactions')->findOrFail($id);

            return response()->json([
                'partner' => $partner,
                'total_revenue' => $partner->total_revenue,
                'pending_revenue' => $partner->pending_revenue,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function updatePartner(Request $request, $id)
    {
        $request->validate([
            'company_name' => 'sometimes|string|max:255',
            'company_type' => 'sometimes|string|max:50',
            'email' => "sometimes|email|unique:partners,email,{$id}",
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'country' => 'nullable|string|max:100',
            'npwp' => 'nullable|string|max:50',
            'partnership_model' => 'sometimes|in:equity,revenue_share,subscription,project_based',
            'status' => 'sometimes|in:active,inactive,pending,suspended,terminated',
            'contract_start_date' => 'nullable|date',
            'contract_end_date' => 'nullable|date',
            'equity_percentage' => 'nullable|numeric|min:0|max:100',
            'revenue_share_percentage' => 'nullable|numeric|min:0|max:100',
            'monthly_fee' => 'nullable|numeric|min:0',
            'contact_person_name' => 'nullable|string|max:255',
            'contact_person_email' => 'nullable|email|max:255',
            'contact_person_phone' => 'nullable|string|max:30',
            'contact_person_position' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        try {
            $partner = Partner::findOrFail($id);
            $partner->update($request->all());

            return response()->json(['success' => true, 'message' => 'Partner updated successfully']);
        } catch (\Exception $e) {
            Log::error('Update partner error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function deletePartner($id)
    {
        try {
            $partner = Partner::findOrFail($id);
            $partner->delete();

            return response()->json(['success' => true, 'message' => 'Partner deleted successfully']);
        } catch (\Exception $e) {
            Log::error('Delete partner error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function activatePartner($id)
    {
        try {
            $partner = Partner::findOrFail($id);
            $partner->update(['status' => 'active']);

            return response()->json(['success' => true, 'message' => 'Partner activated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function suspendPartner($id)
    {
        try {
            $partner = Partner::findOrFail($id);
            $partner->update(['status' => 'suspended']);

            return response()->json(['success' => true, 'message' => 'Partner suspended successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // ==========================================
    // REVENUE MANAGEMENT (New from PMS)
    // ==========================================

    public function getRevenues(Request $request)
    {
        $query = RevenueTransaction::with('partner');

        if ($request->partner_id) {
            $query->where('partner_id', $request->partner_id);
        }

        if ($request->status) {
            $query->where('payment_status', $request->status);
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        $revenues = $query->orderBy('created_at', 'desc')->get()->map(function ($rev) {
            return [
                'id' => $rev->id,
                'partner_id' => $rev->partner_id,
                'partner_name' => $rev->partner->company_name ?? '-',
                'type' => $rev->type,
                'amount' => $rev->amount,
                'tax_amount' => $rev->tax_amount,
                'net_amount' => $rev->net_amount,
                'formatted_amount' => $rev->formatted_amount,
                'currency' => $rev->currency,
                'payment_status' => $rev->payment_status,
                'payment_date' => $rev->payment_date?->format('d M Y'),
                'payment_method' => $rev->payment_method,
                'invoice_number' => $rev->invoice_number,
                'description' => $rev->description,
                'period_start' => $rev->period_start?->format('d M Y'),
                'period_end' => $rev->period_end?->format('d M Y'),
            ];
        });

        return response()->json($revenues);
    }

    public function storeRevenue(Request $request)
    {
        $request->validate([
            'partner_id' => 'required|exists:partners,id',
            'type' => 'required|in:subscription_fee,revenue_share,one_time_payment,refund,credit,adjustment',
            'amount' => 'required|numeric|min:0',
            'tax_percentage' => 'nullable|numeric|min:0|max:100',
            'payment_status' => 'sometimes|in:pending,paid,failed,refunded,cancelled',
            'payment_date' => 'nullable|date',
            'payment_method' => 'nullable|string|max:100',
            'invoice_number' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:500',
            'period_start' => 'nullable|date',
            'period_end' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        try {
            $taxPercentage = $request->tax_percentage ?? 11; // PPN 11%
            $taxAmount = $request->amount * ($taxPercentage / 100);
            $netAmount = $request->amount - $taxAmount;

            // For refund/credit, net_amount should be negative
            if (in_array($request->type, ['refund', 'credit'])) {
                $netAmount = -abs($netAmount);
            }

            $revenue = RevenueTransaction::create([
                'partner_id' => $request->partner_id,
                'type' => $request->type,
                'amount' => $request->amount,
                'tax_amount' => $taxAmount,
                'net_amount' => $netAmount,
                'currency' => 'IDR',
                'payment_status' => $request->payment_status ?? 'pending',
                'payment_date' => $request->payment_date,
                'payment_method' => $request->payment_method,
                'invoice_number' => $request->invoice_number ?? $this->generateInvoiceNumber(),
                'description' => $request->description,
                'period_start' => $request->period_start,
                'period_end' => $request->period_end,
                'notes' => $request->notes,
            ]);

            return response()->json([
                'success' => true,
                'revenue' => $revenue,
                'message' => 'Revenue transaction created successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Create revenue error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function updateRevenue(Request $request, $id)
    {
        $request->validate([
            'payment_status' => 'sometimes|in:pending,paid,failed,refunded,cancelled',
            'payment_date' => 'nullable|date',
            'payment_method' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        try {
            $revenue = RevenueTransaction::findOrFail($id);
            $revenue->update($request->only(['payment_status', 'payment_date', 'payment_method', 'notes']));

            return response()->json(['success' => true, 'message' => 'Revenue updated successfully']);
        } catch (\Exception $e) {
            Log::error('Update revenue error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteRevenue($id)
    {
        try {
            $revenue = RevenueTransaction::findOrFail($id);
            $revenue->delete();

            return response()->json(['success' => true, 'message' => 'Revenue deleted successfully']);
        } catch (\Exception $e) {
            Log::error('Delete revenue error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // ==========================================
    // ANALYTICS (New from PMS)
    // ==========================================

    public function getAnalytics()
    {
        $revenueByMonth = RevenueTransaction::paid()
            ->where('payment_date', '>=', now()->subMonths(6))
            ->selectRaw('YEAR(payment_date) as year, MONTH(payment_date) as month, SUM(net_amount) as total')
            ->groupByRaw('YEAR(payment_date), MONTH(payment_date)')
            ->orderByRaw('YEAR(payment_date), MONTH(payment_date)')
            ->get();

        $partnershipDistribution = Partner::selectRaw('partnership_model, COUNT(*) as count')
            ->groupBy('partnership_model')
            ->pluck('count', 'partnership_model');

        $statusDistribution = Partner::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $revenueByType = RevenueTransaction::paid()
            ->selectRaw('type, SUM(net_amount) as total')
            ->groupBy('type')
            ->pluck('total', 'type');

        $topPartners = Partner::withSum(['revenueTransactions as total_revenue' => function ($q) {
            $q->where('payment_status', 'paid');
        }], 'net_amount')
            ->orderByDesc('total_revenue')
            ->limit(5)
            ->get()
            ->map(function ($p) {
                return [
                    'company_name' => $p->company_name,
                    'total_revenue' => $p->total_revenue ?? 0,
                ];
            });

        return response()->json([
            'revenue_by_month' => $revenueByMonth,
            'partnership_distribution' => $partnershipDistribution,
            'status_distribution' => $statusDistribution,
            'revenue_by_type' => $revenueByType,
            'top_partners' => $topPartners,
        ]);
    }

    private function generateInvoiceNumber()
    {
        $prefix = 'INV';
        $date = now()->format('Ymd');
        $count = RevenueTransaction::whereDate('created_at', now())->count() + 1;
        return "{$prefix}-{$date}-" . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}
