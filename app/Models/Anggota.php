<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Anggota extends Model
{
    protected $fillable = [
        'user_id',
        'nama',
        'email',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'no_hp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}