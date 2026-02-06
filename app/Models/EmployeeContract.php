<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeContract extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name', 'company_address',
        'employee_name', 'employee_nik', 'employee_address',
        'contract_type', 'legal_basis',
        'position', 'direct_superior', 'job_description',
        'work_location', 'working_hours', 'working_days', 'overtime_rules',
        'start_date', 'contract_duration', 'probation_period',
        'base_salary', 'transport_allowance', 'meal_allowance', 'other_allowance',
        'payment_method', 'payment_date',
        'right_annual_leave', 'right_sick_leave', 'right_special_leave',
        'right_bpjs_health', 'right_bpjs_employment', 'right_thr',
        'employee_obligations', 'nda_ip_policy', 'prohibitions', 'termination_terms',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'right_annual_leave' => 'boolean',
        'right_sick_leave' => 'boolean',
        'right_special_leave' => 'boolean',
        'right_bpjs_health' => 'boolean',
        'right_bpjs_employment' => 'boolean',
        'right_thr' => 'boolean',
    ];
}
