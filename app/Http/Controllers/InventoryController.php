<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryAsset;
use App\Models\InventoryAuditLog;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    // Categories for assets
    private $categories = ['IT Equipment', 'Furniture', 'Vehicles', 'Infrastructure'];
    private $statuses = ['Active', 'Disposed', 'Damaged', 'In-Repair', 'Maintenance', 'Loaned'];
    private $conditions = ['Good', 'Damaged'];

    /**
     * Display inventory dashboard
     */
    public function index()
    {
        $assets = InventoryAsset::active()->get();

        // Stats
        $totalAssets = $assets->count();
        $totalCost = $assets->sum('cost');
        $totalBookValue = $assets->sum('book_value');
        $damagedCount = InventoryAsset::active()->damaged()->count();
        $loanedCount = InventoryAsset::active()->loaned()->count();

        // Category breakdown for chart
        $categoryData = $assets->groupBy('category')->map(function ($items, $key) {
            return [
                'name' => $key,
                'value' => $items->count(),
                'cost' => $items->sum('cost'),
            ];
        })->values();

        // Condition breakdown
        $goodCount = $assets->where('condition', 'Good')->count();
        $damagedConditionCount = $assets->where('condition', 'Damaged')->count();
        $healthPercentage = $totalAssets > 0 ? round(($goodCount / $totalAssets) * 100) : 0;

        // Recent logs
        $recentLogs = InventoryAuditLog::orderBy('created_at', 'desc')->take(5)->get();

        return view('inventory.index', compact(
            'assets',
            'totalAssets',
            'totalCost',
            'totalBookValue',
            'damagedCount',
            'loanedCount',
            'categoryData',
            'goodCount',
            'damagedConditionCount',
            'healthPercentage',
            'recentLogs'
        ));
    }

    /**
     * Display asset register
     */
    public function register()
    {
        $assets = InventoryAsset::active()->orderBy('created_at', 'desc')->get();
        $categories = $this->categories;
        $statuses = $this->statuses;
        $conditions = $this->conditions;

        return view('inventory.register', compact('assets', 'categories', 'statuses', 'conditions'));
    }

    /**
     * Store new asset
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'acquisition_date' => 'required|date',
            'cost' => 'required|numeric|min:0',
            'location' => 'nullable|string|max:255',
            'status' => 'required|string',
            'condition' => 'required|string',
        ]);

        $code = InventoryAsset::generateCode();

        $asset = InventoryAsset::create([
            'code' => $code,
            'name' => $request->name,
            'category' => $request->category,
            'acquisition_date' => $request->acquisition_date,
            'cost' => $request->cost,
            'depreciation' => 0,
            'book_value' => $request->cost,
            'location' => $request->location,
            'status' => $request->status,
            'condition' => $request->condition,
            'last_audit_date' => now(),
        ]);

        // Create audit log
        $this->createAuditLog($asset, 'CREATE', null, $asset->toArray(), 'Asset baru ditambahkan: ' . $asset->name);

        return response()->json([
            'success' => true,
            'message' => 'Asset berhasil ditambahkan',
            'asset' => $asset,
        ]);
    }

    /**
     * Update asset
     */
    public function update(Request $request, $id)
    {
        $asset = InventoryAsset::findOrFail($id);
        $previousData = $asset->toArray();

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'acquisition_date' => 'required|date',
            'cost' => 'required|numeric|min:0',
            'location' => 'nullable|string|max:255',
            'status' => 'required|string',
            'condition' => 'required|string',
        ]);

        $asset->update([
            'name' => $request->name,
            'category' => $request->category,
            'acquisition_date' => $request->acquisition_date,
            'cost' => $request->cost,
            'location' => $request->location,
            'status' => $request->status,
            'condition' => $request->condition,
            'loaned_to' => $request->loaned_to,
        ]);

        // Create audit log
        $this->createAuditLog($asset, 'UPDATE', $previousData, $asset->toArray(), 'Asset diperbarui: ' . $asset->name);

        return response()->json([
            'success' => true,
            'message' => 'Asset berhasil diperbarui',
            'asset' => $asset,
        ]);
    }

    /**
     * Soft delete asset
     */
    public function destroy($id)
    {
        $asset = InventoryAsset::findOrFail($id);
        $previousData = $asset->toArray();

        $asset->update(['is_deleted' => true]);

        // Create audit log
        $this->createAuditLog($asset, 'DELETE', $previousData, null, 'Asset dihapus: ' . $asset->name);

        return response()->json([
            'success' => true,
            'message' => 'Asset berhasil dihapus',
        ]);
    }

    /**
     * Loan asset
     */
    public function loan(Request $request, $id)
    {
        $asset = InventoryAsset::findOrFail($id);
        $previousData = $asset->toArray();

        $request->validate([
            'loaned_to' => 'required|string|max:255',
        ]);

        $asset->update([
            'status' => 'Loaned',
            'loaned_to' => $request->loaned_to,
        ]);

        // Create audit log
        $this->createAuditLog($asset, 'LOAN', $previousData, $asset->toArray(), 'Asset dipinjamkan ke: ' . $request->loaned_to);

        return response()->json([
            'success' => true,
            'message' => 'Asset berhasil dipinjamkan',
            'asset' => $asset,
        ]);
    }

    /**
     * Return asset
     */
    public function returnAsset($id)
    {
        $asset = InventoryAsset::findOrFail($id);
        $previousData = $asset->toArray();

        $asset->update([
            'status' => 'Active',
            'loaned_to' => null,
        ]);

        // Create audit log
        $this->createAuditLog($asset, 'RETURN', $previousData, $asset->toArray(), 'Asset dikembalikan dari pinjaman');

        return response()->json([
            'success' => true,
            'message' => 'Asset berhasil dikembalikan',
            'asset' => $asset,
        ]);
    }

    /**
     * Display audit trail
     */
    public function auditTrail()
    {
        $logs = InventoryAuditLog::orderBy('created_at', 'desc')->paginate(20);
        return view('inventory.audit-trail', compact('logs'));
    }

    /**
     * Get assets as JSON (for AJAX)
     */
    public function getAssets()
    {
        $assets = InventoryAsset::active()->orderBy('created_at', 'desc')->get();
        return response()->json($assets);
    }

    /**
     * Get single asset
     */
    public function getAsset($id)
    {
        $asset = InventoryAsset::findOrFail($id);
        return response()->json($asset);
    }

    /**
     * Create audit log entry
     */
    private function createAuditLog($asset, $action, $previous, $new, $description)
    {
        $user = Auth::user();

        InventoryAuditLog::create([
            'asset_id' => $asset->id,
            'asset_name' => $asset->name,
            'action' => $action,
            'operation_code' => InventoryAuditLog::generateOperationCode($action),
            'table_name' => 'inventory_assets',
            'user_name' => $user ? $user->name : 'System',
            'user_role' => 'Admin',
            'previous_snapshot' => $previous,
            'new_snapshot' => $new,
            'description' => $description,
        ]);
    }
}
