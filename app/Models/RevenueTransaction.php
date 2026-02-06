<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevenueTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'partner_id',
        'type',
        'amount',
        'tax_amount',
        'net_amount',
        'currency',
        'revenue_share_percentage',
        'base_revenue',
        'period_start',
        'period_end',
        'payment_status',
        'payment_date',
        'payment_method',
        'invoice_number',
        'description',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'base_revenue' => 'decimal:2',
        'revenue_share_percentage' => 'decimal:2',
        'period_start' => 'date',
        'period_end' => 'date',
        'payment_date' => 'date',
    ];

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->net_amount, 0, ',', '.');
    }

    // Scopes
    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }
}
