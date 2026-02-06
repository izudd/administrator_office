<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'color',
    ];

    public function documents()
    {
        return $this->hasMany(PartnerDocument::class, 'category_id');
    }

    public function documentsCount()
    {
        return $this->documents()->count();
    }
}
