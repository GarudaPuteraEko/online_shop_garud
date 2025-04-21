<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // 🧍 Menampilkan halaman approval untuk User
    public function userApproval()
    {
        $transactions = Transaction::where('user_id', Auth::id())->latest()->get();

        if ($transactions->isEmpty()) {
            return redirect()->route('home')->with('error', 'Tidak ada transaksi ditemukan.');
        }

        return view('transaction.approval', compact('transactions'));
    }

    public function cancel($id)
    {
    $transaction = Transaction::where('id', $id)->where('user_id', Auth::id())->first();

    if (!$transaction || $transaction->status !== 'pending') {
        return back()->with('error', 'Transaksi tidak dapat dibatalkan.');
    }

    $transaction->status = 'cancelled';
    $transaction->save();

    return back()->with('success', 'Transaksi berhasil dibatalkan.');
    }


    // 👨‍💼 Admin melihat semua transaksi
    public function adminApproval()
    {
        $transactions = Transaction::with('user')->latest()->get();
        return view('transaction.adminApproval', compact('transactions'));
    }

    // ✅ Admin menyetujui transaksi
    public function approve($id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return back()->with('error', 'Transaksi tidak ditemukan.');
        }

        $transaction->status = 'approved';
        $transaction->save();

        return back()->with('success', 'Transaksi berhasil disetujui.');
    }

    // ❌ Admin menolak transaksi
    public function reject($id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return back()->with('error', 'Transaksi tidak ditemukan.');
        }

        $transaction->status = 'rejected';
        $transaction->save();

        return redirect()->route('adminHome')->with('error', 'Transaksi ditolak!');
    }

    // 🧾 Generate PDF bukti transaksi
    public function generatePdf($id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan.');
        }

        $pdf = PDF::loadView('transaction.receipt', compact('transaction'));

        return $pdf->download('bukti-pembayaran-' . $transaction->id . '.pdf');
    }
}
