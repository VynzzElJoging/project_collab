<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    protected $fillable = [
        'judul',
        'penulis',
        'penerbit',
        'tahun',
        'kategori',
        'stok',
        'cover',
    ];

    public function peminjamanDetails(): HasMany
    {
        return $this->hasMany(PeminjamanDetails::class);
    }
}
