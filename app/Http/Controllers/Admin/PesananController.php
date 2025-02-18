<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index()
    {
        $pesanans = Pesanan::with(['user', 'detailPesanan.produk'])
            ->latest()
            ->paginate(10);
            
        return view('admin.pesanan.index', compact('pesanans'));
    }

    public function show(Pesanan $pesanan)
    {
        $pesanan->load(['user', 'detailPesanan.produk']);
        return view('admin.pesanan.show', compact('pesanan'));
    }

    public function updateStatus(Request $request, Pesanan $pesanan)
    {
        $request->validate([
            'status' => 'required|in:pending,proses,selesai,batal'
        ]);

        $pesanan->update([
            'status' => $request->status
        ]);

        return redirect()->route('admin.pesanan.show', $pesanan)
            ->with('success', 'Status pesanan berhasil diperbarui');
    }
}
