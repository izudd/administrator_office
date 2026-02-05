<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryAsset extends Model
{
    use HasFactory;

    protected $table = 'inventory_assets';

    protected $fillable = [
        'code',
        'name',
        'category',
        'acquisition_date',
        'cost',
        'depreciation',
        'book_value',
        'location',
        'status',
        'condition',
        'last_audit_date',
        'image_url',
        'loaned_to',
        'is_deleted',
    ];

    protected $casts = [
        'acquisition_date' => 'date',
        'last_audit_date' => 'date',
        'cost' => 'decimal:2',
        'depreciation' => 'decimal:2',
        'book_value' => 'decimal:2',
        'is_deleted' => 'boolean',
    ];

    // Generate unique code
    public static function generateCode()
    {
        $lastAsset = self::orderBy('id', 'desc')->first();
        $nextId = $lastAsset ? $lastAsset->id + 1 : 1;
        return 'FA-' . str_pad($nextId, 3, '0', STR_PAD_LEFT) . '-KAP';
    }

    // Relationships
    public function auditLogs()
    {
        return $this->hasMany(InventoryAuditLog::class, 'asset_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_deleted', false);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeDamaged($query)
    {
        return $query->where('condition', 'Damaged')->orWhere('status', 'Damaged');
    }

    public function scopeLoaned($query)
    {
        return $query->where('status', 'Loaned');
    }
}
