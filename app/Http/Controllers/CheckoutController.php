<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::where('user_id', auth()->id())->with('produk')->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong');
        }

        $subtotal = $cartItems->sum(function($item) {
            return $item->produk->harga * $item->jumlah;
        });

        // Hitung ongkir (untuk sementara flat rate)
        $ongkir = 20000;
        $total = $subtotal + $ongkir;

        return view('checkout.index', compact('cartItems', 'subtotal', 'ongkir', 'total'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'nama_penerima' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string',
            'metode_pembayaran' => 'required|in:transfer,cod',
        ]);

        try {
            DB::beginTransaction();

            // Ambil item keranjang
            $cartItems = CartItem::where('user_id', auth()->id())->with('produk')->get();
            
            if ($cartItems->isEmpty()) {
                throw new \Exception('Keranjang belanja kosong');
            }

            // Hitung total
            $subtotal = $cartItems->sum(function($item) {
                return $item->produk->harga * $item->jumlah;
            });
            $ongkir = 20000;
            $total = $subtotal + $ongkir;

            // Buat pesanan baru
            $pesanan = Pesanan::create([
                'user_id' => auth()->id(),
                'nomor_pesanan' => 'INV-' . Str::random(10),
                'nama_penerima' => $request->nama_penerima,
                'telepon' => $request->telepon,
                'alamat' => $request->alamat,
                'catatan' => $request->catatan,
                'metode_pembayaran' => $request->metode_pembayaran,
                'subtotal' => $subtotal,
                'ongkir' => $ongkir,
                'total' => $total,
                'status' => 'pending'
            ]);

            // Buat detail pesanan
            foreach ($cartItems as $item) {
                DetailPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'produk_id' => $item->produk_id,
                    'jumlah' => $item->jumlah,
                    'harga' => $item->produk->harga,
                    'subtotal' => $item->produk->harga * $item->jumlah
                ]);

                // Kurangi stok produk
                $item->produk->decrement('stok', $item->jumlah);
            }

            // Kosongkan keranjang
            CartItem::where('user_id', auth()->id())->delete();

            DB::commit();

            return redirect()->route('pesanan.konfirmasi', $pesanan->id)
                           ->with('success', 'Pesanan berhasil dibuat');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
