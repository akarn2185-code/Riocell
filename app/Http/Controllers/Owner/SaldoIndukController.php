<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\SaldoInduk;
use Illuminate\Http\Request;

class SaldoIndukController extends Controller
{
    /**
     * Menampilkan Halaman Kelola Saldo Induk
     */
    public function index()
    {
        // Cari data saldo induk (karena hanya ada 1 record)
        $saldoInduk = SaldoInduk::first();
        
        // Jika belum ada sama sekali di database, buatkan data awal Rp 0
        if (!$saldoInduk) {
            $saldoInduk = SaldoInduk::create([
                'balance' => 0,
                'last_deposit' => 0,
                'last_deposit_at' => now()
            ]);
        }

        return view('owner.saldo-induk.index', compact('saldoInduk'));
    }

    /**
     * Memproses form Deposit (Tambah Saldo)
     */
    public function deposit(Request $request)
    {
        // Validasi input
        $request->validate([
            'amount' => 'required|numeric|min:10000'
        ]);

        $saldoInduk = SaldoInduk::first();
        
        // Jaga-jaga jika terhapus, buat baru
        if (!$saldoInduk) {
            $saldoInduk = new SaldoInduk();
            $saldoInduk->balance = 0;
        }

        // Tambahkan saldo lama dengan jumlah deposit baru
        $saldoInduk->balance += $request->amount;
        $saldoInduk->last_deposit = $request->amount;
        $saldoInduk->last_deposit_at = now();
        $saldoInduk->save();

        // Redirect kembali dengan pesan sukses
        return back()->with('success', 'Deposit saldo berhasil! Saldo bertambah Rp ' . number_format($request->amount, 0, ',', '.'));
    }
}