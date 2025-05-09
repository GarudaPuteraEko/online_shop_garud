<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = ['kode_produk', 'nama', 'harga', 'kategori_id', 'gambar'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    
}
