<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $produk = Produk::findOrFail($request->produk_id);

        $cart = session()->get('cart', []);

        if (isset($cart[$produk->id])) {
            $cart[$produk->id]['quantity']++;
        } else {
            $cart[$produk->id] = [
                'nama' => $produk->nama,
                'harga' => $produk->harga,
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function show()
    {
    $cart = session('cart', []);
    $cartItems = collect();

    foreach ($cart as $produkId => $item) {
        $produk = Produk::find($produkId);
        if ($produk) {
            $cartItems->push((object)[
                'id' => $produkId,
                'produk' => $produk,
                'quantity' => $item['quantity'],
            ]);
        }
    }

    return view('cart.index', compact('cartItems'));
    }  


    public function remove($id)
    {
    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        unset($cart[$id]);
        session()->put('cart', $cart);
    }

    return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    public function checkout(Request $request)
    {
    $cart = session('cart', []);

    if (empty($cart)) {
        return redirect()->back()->with('error', 'Keranjang kosong.');
    }

    foreach ($cart as $produkId => $item) {
        $produk = Produk::find($produkId);

        if ($produk) {
            Transaction::create([
                'user_id'     => Auth::id(),
                'kode_produk' => $produk->kode_produk,
                'nama_user'   => Auth::user()->name, // asumsi user punya field 'name'
                'harga'       => $produk->harga,
                'status'      => 'pending',
            ]);
        }
    }

    session()->forget('cart');

    return redirect()->route('transaction.approval')->with('success', 'Checkout berhasil. Menunggu persetujuan admin.');
    }



}
