<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\Kategori;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Ambil statistik untuk dashboard
        $stats = [
            'total_pelanggan' => User::where('is_admin', false)->count(),
            'total_produk' => Produk::count(),
            'total_kategori' => Kategori::count(),
            'pesanan_pending' => Pesanan::where('status', 'pending')->count(),
            'pesanan_proses' => Pesanan::where('status', 'proses')->count(),
            'pesanan_selesai' => Pesanan::where('status', 'selesai')->count(),
        ];

        // Ambil pesanan terbaru
        $pesanan_terbaru = Pesanan::with(['user'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Ambil produk dengan stok menipis (kurang dari 5)
        $stok_menipis = Produk::where('stok', '<', 5)
            ->orderBy('stok', 'asc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'pesanan_terbaru', 'stok_menipis'));
    }
}
