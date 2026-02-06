<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_profile_id', 'document_type', 'file_name',
        'file_path', 'file_extension', 'notes', 'expiry_date',
    ];

    protected $casts = [
        'expiry_date' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(EmployeeProfile::class, 'employee_profile_id');
    }
}
