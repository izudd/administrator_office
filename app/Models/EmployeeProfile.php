<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_name', 'employee_id_number', 'position',
        'department', 'partner', 'email', 'phone', 'join_date', 'status',
    ];

    protected $casts = [
        'join_date' => 'date',
    ];

    public function files()
    {
        return $this->hasMany(EmployeeFile::class);
    }
}
