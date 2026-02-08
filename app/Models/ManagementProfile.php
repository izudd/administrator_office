<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagementProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'title',
        'position',
        'nip',
        'email',
        'phone',
        'ap_number',
        'ap_expiry',
        'cpa_number',
        'join_date',
        'status',
    ];

    protected $casts = [
        'join_date' => 'date',
        'ap_expiry' => 'date',
    ];

    public function files()
    {
        return $this->hasMany(ManagementFile::class);
    }
}
