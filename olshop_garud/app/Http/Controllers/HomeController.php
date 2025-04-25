<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Produk;
use App\Models\Kategori;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $kategoris = Kategori::all(); // ambil semua kategori

        // mulai query dengan relasi kategori
        $query = Produk::with('kategori');

        // jika ada request kategori, filter berdasarkan kategori_id
        if (request()->filled('kategori')) {
            $query->where('kategori_id', request('kategori'));
        }

        // jika ada request search, filter berdasarkan nama produk
        if (request()->filled('search')) {
            $query->where('nama', 'like', '%' . request('search') . '%');
        }

        $produks = $query->get(); // ambil hasil query

        // kirim data ke tampilan
        return view('home', [
            'produks' => $produks,
            'kategoris' => $kategoris
        ]);
    }


    public function adminHome(): View
    {
        $kategoris = Kategori::all(); // ambil semua kategori

        $query = Produk::with('kategori'); // eager load relasi kategori

        // Cek apakah ada filter kategori yang dipilih
        if (request()->has('kategori') && request('kategori')) {
            $query->where('kategori_id', request('kategori'));
        }

        // Cek apakah ada pencarian produk
        if (request()->has('search') && request('search')) {
            $query->where('nama', 'like', '%' . request('search') . '%');
        }

        $produks = $query->get(); // ambil hasil query, bisa terfilter atau tidak

        return view('adminHome', [
            'produks' => $produks,
            'kategoris' => $kategoris
        ]);
    }

}
