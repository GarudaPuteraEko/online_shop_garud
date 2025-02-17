<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Produk;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        // return view('home');

        $produks = Produk::all(); // ambil semua data dari tabel produk

        // kirim data ke tampilan
        return view('home', ['produks' => $produks]);
    }

    public function adminHome(): View
    {
        $produks = Produk::all();

        return view('adminHome', ['produks' => $produks]);
    }
}
