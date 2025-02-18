<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pesanans = Pesanan::with(['pelanggan', 'detailPesanan.produk'])->get();
        return view('pesanan.index', compact('pesanans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $produks = Produk::all();
        return view('pesanan.create', compact('produks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'produk_id' => 'required|array',
            'produk_id.*' => 'exists:produks,id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'integer|min:1'
        ]);

        DB::beginTransaction();
        try {
            $pesanan = Pesanan::create([
                'pelanggan_id' => $request->pelanggan_id,
                'tanggal' => now(),
                'status' => 'pending',
                'total_harga' => 0
            ]);

            $totalHarga = 0;
            foreach($request->produk_id as $index => $produkId) {
                $produk = Produk::find($produkId);
                $jumlah = $request->jumlah[$index];
                $harga = $produk->harga * $jumlah;
                
                DetailPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'produk_id' => $produkId,
                    'jumlah' => $jumlah,
                    'harga' => $harga
                ]);

                $totalHarga += $harga;
            }

            $pesanan->update(['total_harga' => $totalHarga]);
            DB::commit();

            return redirect()->route('pesanan.index')
                ->with('success', 'Pesanan berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat membuat pesanan.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pesanan $pesanan)
    {
        $produks = Produk::all();
        $pesanan->load('detailPesanan.produk');
        return view('pesanan.edit', compact('pesanan', 'produks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pesanan $pesanan)
    {
        $request->validate([
            'status' => 'required|in:pending,proses,selesai,batal'
        ]);

        $pesanan->update($request->all());
        return redirect()->route('pesanan.index')
            ->with('success', 'Status pesanan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pesanan $pesanan)
    {
        DB::beginTransaction();
        try {
            $pesanan->detailPesanan()->delete();
            $pesanan->delete();
            DB::commit();

            return redirect()->route('pesanan.index')
                ->with('success', 'Pesanan berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus pesanan.');
        }
    }
}
