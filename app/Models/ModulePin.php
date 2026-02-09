<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModulePin extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_key',
        'module_name',
        'pin_code',
        'updated_by',
    ];

    protected $hidden = [
        'pin_code',
    ];

    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
