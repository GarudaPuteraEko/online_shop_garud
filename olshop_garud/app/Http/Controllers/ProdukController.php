<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index() 
    {
        $produks = Produk::with('kategori')->get();
        return view('adminHome', ['produks' => $produks]);
    }

    public function create(Request $request)
    {
        $kategoris = Kategori::all();
        return view('produk.create', compact('kategoris'));
    }

    public function store(Request $request) 
    {
        $request->validate([
            'kode_produk' => 'required|unique:produks',
            'nama'        => 'required',
            'harga'       => 'required|numeric',
            'kategori_id' => 'required|exists:kategoris,id',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $gambarPath = null;

        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('produks', 'public');
        }

        Produk::create([
            'kode_produk' => $request->kode_produk,
            'nama'        => $request->nama,
            'harga'       => $request->harga,
            'kategori_id' => $request->kategori_id,
            'gambar'      => $gambarPath,
        ]);

        return redirect()->route('adminHome')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit($id) 
    {
        $produk = Produk::findOrFail($id);
        $kategoris = Kategori::all();
        return view('produk.edit', compact('produk', 'kategoris'));
    }

    public function update(Request $request, $id) 
    {
        $request->validate([
            'kode_produk' => 'required',
            'nama'        => 'required',
            'harga'       => 'required|numeric',
            'kategori_id' => 'required|exists:kategoris,id',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $produk = Produk::findOrFail($id);

        $data = $request->only(['kode_produk', 'nama', 'harga', 'kategori_id']);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama kalau ada
            if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
                Storage::disk('public')->delete($produk->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('produks', 'public');
        }

        $produk->update($data);

        return redirect()->route('adminHome')->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy($id) 
    {
        $produk = Produk::findOrFail($id);
        if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
            Storage::disk('public')->delete($produk->gambar);
        }
        $produk->delete();
        return redirect()->route('adminHome')->with('success', 'Produk berhasil dihapus');
    }
}
