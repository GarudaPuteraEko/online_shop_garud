<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index() 
    {
        $produks = Produk::with('kategori')->get(); // Ambil data produk dengan kategori yang sudah di-relasikan
    
        // Kirim data ke tampilan
        return view('adminHome', ['produks' => $produks]);
    }
    
    public function create(Request $request)
    {
    $kategoris = Kategori::all();  // Ambil semua kategori
    return view('produk.create', compact('kategoris'));  // Kirim data kategori ke view
    }


    public function store(Request $request) {
        $request->validate([
            'kode_produk' => 'required|unique:produks',
            'nama'        => 'required',
            'harga'       => 'required',
            'kategori_id' => 'required|exists:kategoris,id', // Validasi kategori_id
        ]);

        Produk::create($request->all());
        return redirect()->route('adminHome')
            ->with('success', 'Produk berhasil ditambahkan');
        
        $produk = new Produk; 
        
        // Simpan produk ke dalam database 
        $produk->save();
    }
    
    public function edit($id) 
    {
        // Cari produk berdasarkan ID
        $produk = Produk::findOrFail($id);  // Gunakan findOrFail untuk memastikan produk ada

        // Ambil semua kategori untuk pilihan dropdown
        $kategoris = Kategori::all();  

        // Kirim data produk dan kategori ke view
        return view('produk.edit', compact('produk', 'kategoris'));
    }
    
    public function update(Request $request, $id) 
    {
        $request->validate([
            'kode_produk' => 'required',
            'nama'        => 'required',
            'harga'       => 'required',
            'kategori_id' => 'required|exists:kategoris,id', // Validasi kategori_id
        ]);

        $produk = Produk::find($id);
        $produk->update($request->all());    
        return redirect()->route('adminHome')
            ->with('success', 'Produk berhasil diperbarui');
    }
    
    public function destroy($id) 
    {
        $produk = Produk::find($id);
        $produk->delete();   
        return redirect()->route('adminHome')
            ->with('success', 'Produk berhasil dihapus');
    }
    
}
