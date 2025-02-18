<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggans = User::where('is_admin', false)
            ->withCount('pesanans')
            ->latest()
            ->paginate(10);
            
        return view('admin.pelanggan.index', compact('pelanggans'));
    }

    public function show(User $user)
    {
        if ($user->is_admin) {
            return redirect()->route('admin.pelanggan.index')
                ->with('error', 'Data tidak ditemukan');
        }

        $user->load(['pesanans' => function ($query) {
            $query->latest();
        }, 'pesanans.detailPesanan.produk']);

        return view('admin.pelanggan.show', compact('user'));
    }
}
