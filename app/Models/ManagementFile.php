<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagementFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'management_profile_id',
        'document_type',
        'file_name',
        'file_path',
        'file_extension',
        'notes',
        'expiry_date',
    ];

    protected $casts = [
        'expiry_date' => 'date',
    ];

    public function management()
    {
        return $this->belongsTo(ManagementProfile::class, 'management_profile_id');
    }
}
