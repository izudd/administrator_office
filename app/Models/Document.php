<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'folder_id',
        'file_name',
        'file_path',
        'file_type',
    ];

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }
}
