<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeContract;
use Illuminate\Support\Facades\Log;

class EmployeeLegalController extends Controller
{
    public function index()
    {
        $contracts = EmployeeContract::orderBy('created_at', 'desc')->get();

        $totalContracts = $contracts->count();
        $activeContracts = $contracts->where('contract_type', 'PKWTT')->count();

        $probationContracts = $contracts->filter(function ($c) {
            if (!$c->start_date) return false;
            $monthsDiff = now()->diffInMonths($c->start_date);
            return $monthsDiff < ($c->probation_period ?? 3);
        })->count();

        $expiringContracts = $contracts->filter(function ($c) {
            if ($c->contract_type !== 'PKWT' || !$c->start_date || !$c->contract_duration) return false;
            $endDate = $c->start_date->copy()->addMonths($c->contract_duration);
            return $endDate->between(now(), now()->addDays(30));
        })->count();

        return view('employee-legal', compact(
            'contracts', 'totalContracts', 'activeContracts',
            'probationContracts', 'expiringContracts'
        ));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'company_name' => 'required|string|max:255',
                'company_address' => 'nullable|string|max:500',
                'employee_name' => 'required|string|max:255',
                'employee_nik' => 'nullable|string|max:50',
                'employee_address' => 'nullable|string|max:500',
                'contract_type' => 'required|in:PKWT,PKWTT',
                'legal_basis' => 'nullable|string|max:255',
                'position' => 'required|string|max:255',
                'direct_superior' => 'nullable|string|max:255',
                'job_description' => 'nullable|string',
                'work_location' => 'nullable|string|max:100',
                'working_hours' => 'nullable|integer|min:1|max:24',
                'working_days' => 'nullable|integer|min:1|max:7',
                'overtime_rules' => 'nullable|string',
                'start_date' => 'required|date',
                'contract_duration' => 'nullable|integer|min:1',
                'probation_period' => 'nullable|integer|min:0',
                'base_salary' => 'nullable|integer|min:0',
                'transport_allowance' => 'nullable|integer|min:0',
                'meal_allowance' => 'nullable|integer|min:0',
                'other_allowance' => 'nullable|integer|min:0',
                'payment_method' => 'nullable|string|max:100',
                'payment_date' => 'nullable|integer|min:1|max:31',
                'employee_obligations' => 'nullable|string',
                'nda_ip_policy' => 'nullable|string',
                'prohibitions' => 'nullable|string',
                'termination_terms' => 'nullable|string',
            ]);

            // Handle checkboxes
            $validated['right_annual_leave'] = $request->has('right_annual_leave');
            $validated['right_sick_leave'] = $request->has('right_sick_leave');
            $validated['right_special_leave'] = $request->has('right_special_leave');
            $validated['right_bpjs_health'] = $request->has('right_bpjs_health');
            $validated['right_bpjs_employment'] = $request->has('right_bpjs_employment');
            $validated['right_thr'] = $request->has('right_thr');

            // Determine initial status
            $validated['status'] = 'active';
            if (isset($validated['probation_period']) && $validated['probation_period'] > 0) {
                $startDate = \Carbon\Carbon::parse($validated['start_date']);
                if (now()->diffInMonths($startDate) < $validated['probation_period']) {
                    $validated['status'] = 'probation';
                }
            }

            $contract = EmployeeContract::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Kontrak berhasil disimpan!',
                'contract' => $contract,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Throwable $e) {
            Log::error('Store contract error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan kontrak.',
            ], 500);
        }
    }

    public function show($id)
    {
        $contract = EmployeeContract::findOrFail($id);
        return response()->json($contract);
    }

    public function update(Request $request, $id)
    {
        try {
            $contract = EmployeeContract::findOrFail($id);

            $validated = $request->validate([
                'company_name' => 'required|string|max:255',
                'company_address' => 'nullable|string|max:500',
                'employee_name' => 'required|string|max:255',
                'employee_nik' => 'nullable|string|max:50',
                'employee_address' => 'nullable|string|max:500',
                'contract_type' => 'required|in:PKWT,PKWTT',
                'legal_basis' => 'nullable|string|max:255',
                'position' => 'required|string|max:255',
                'direct_superior' => 'nullable|string|max:255',
                'job_description' => 'nullable|string',
                'work_location' => 'nullable|string|max:100',
                'working_hours' => 'nullable|integer|min:1|max:24',
                'working_days' => 'nullable|integer|min:1|max:7',
                'overtime_rules' => 'nullable|string',
                'start_date' => 'required|date',
                'contract_duration' => 'nullable|integer|min:1',
                'probation_period' => 'nullable|integer|min:0',
                'base_salary' => 'nullable|integer|min:0',
                'transport_allowance' => 'nullable|integer|min:0',
                'meal_allowance' => 'nullable|integer|min:0',
                'other_allowance' => 'nullable|integer|min:0',
                'payment_method' => 'nullable|string|max:100',
                'payment_date' => 'nullable|integer|min:1|max:31',
                'employee_obligations' => 'nullable|string',
                'nda_ip_policy' => 'nullable|string',
                'prohibitions' => 'nullable|string',
                'termination_terms' => 'nullable|string',
                'status' => 'nullable|in:active,probation,expired,terminated',
            ]);

            $validated['right_annual_leave'] = $request->has('right_annual_leave');
            $validated['right_sick_leave'] = $request->has('right_sick_leave');
            $validated['right_special_leave'] = $request->has('right_special_leave');
            $validated['right_bpjs_health'] = $request->has('right_bpjs_health');
            $validated['right_bpjs_employment'] = $request->has('right_bpjs_employment');
            $validated['right_thr'] = $request->has('right_thr');

            $contract->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Kontrak berhasil diperbarui!',
                'contract' => $contract,
            ]);
        } catch (\Throwable $e) {
            Log::error('Update contract error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui kontrak.',
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $contract = EmployeeContract::findOrFail($id);
            $contract->delete();

            return response()->json([
                'success' => true,
                'message' => 'Kontrak berhasil dihapus!',
            ]);
        } catch (\Throwable $e) {
            Log::error('Delete contract error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus kontrak.',
            ], 500);
        }
    }

    public function getContracts()
    {
        $contracts = EmployeeContract::orderBy('created_at', 'desc')->get();
        return response()->json($contracts);
    }
}
