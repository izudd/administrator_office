<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryAuditLog extends Model
{
    use HasFactory;

    protected $table = 'inventory_audit_logs';

    protected $fillable = [
        'asset_id',
        'asset_name',
        'action',
        'operation_code',
        'table_name',
        'user_name',
        'user_role',
        'previous_snapshot',
        'new_snapshot',
        'description',
    ];

    protected $casts = [
        'previous_snapshot' => 'array',
        'new_snapshot' => 'array',
    ];

    // Generate operation code
    public static function generateOperationCode($action)
    {
        $prefix = match($action) {
            'CREATE' => 'OP-CRT',
            'UPDATE' => 'OP-UPD',
            'DELETE' => 'OP-DEL',
            'LOAN' => 'OP-LON',
            'RETURN' => 'OP-RET',
            default => 'OP-GEN',
        };
        return $prefix . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
    }

    // Relationships
    public function asset()
    {
        return $this->belongsTo(InventoryAsset::class, 'asset_id');
    }
}
