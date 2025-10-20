<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'folder_id',
        'name',
        'file_name',
        'file_path',
        'file_type',
    ];

    // Relasi ke Folder (kalau pakai tabel folders)
    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }
}
