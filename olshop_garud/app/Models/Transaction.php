<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'kode_produk', 'nama_user', 'harga', 'status'];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
