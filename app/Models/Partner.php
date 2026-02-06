<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partner extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_name',
        'company_type',
        'email',
        'phone',
        'address',
        'city',
        'postal_code',
        'country',
        'npwp',
        'partnership_model',
        'status',
        'contract_start_date',
        'contract_end_date',
        'equity_percentage',
        'revenue_share_percentage',
        'monthly_fee',
        'contact_person_name',
        'contact_person_email',
        'contact_person_phone',
        'contact_person_position',
        'notes',
        'custom_fields',
    ];

    protected $casts = [
        'contract_start_date' => 'date',
        'contract_end_date' => 'date',
        'equity_percentage' => 'decimal:2',
        'revenue_share_percentage' => 'decimal:2',
        'monthly_fee' => 'decimal:2',
        'custom_fields' => 'array',
    ];

    // Relationships
    public function documents()
    {
        return $this->hasMany(PartnerDocument::class, 'partner_id');
    }

    public function revenueTransactions()
    {
        return $this->hasMany(RevenueTransaction::class, 'partner_id');
    }

    // Helpers
    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isContractExpired()
    {
        return $this->contract_end_date && $this->contract_end_date->isPast();
    }

    public function getTotalRevenueAttribute()
    {
        return $this->revenueTransactions()
            ->where('payment_status', 'paid')
            ->sum('net_amount');
    }

    public function getPendingRevenueAttribute()
    {
        return $this->revenueTransactions()
            ->where('payment_status', 'pending')
            ->sum('net_amount');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeExpiredContracts($query)
    {
        return $query->whereNotNull('contract_end_date')
                     ->where('contract_end_date', '<', now());
    }

    public function scopeByPartnershipModel($query, $model)
    {
        return $query->where('partnership_model', $model);
    }
}
