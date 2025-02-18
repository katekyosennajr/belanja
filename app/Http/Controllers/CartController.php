<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::with('produk')
            ->where('user_id', Auth::id())
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->produk->harga * $item->jumlah;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, Produk $produk)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1|max:' . $produk->stok,
        ]);

        try {
            DB::beginTransaction();

            $cartItem = CartItem::firstOrNew([
                'user_id' => Auth::id(),
                'produk_id' => $produk->id,
            ]);

            // Jika item sudah ada di keranjang, tambahkan jumlahnya
            if ($cartItem->exists) {
                $newQuantity = $cartItem->jumlah + $request->jumlah;
                
                if ($newQuantity > $produk->stok) {
                    return back()->with('error', 'Stok tidak mencukupi!');
                }
                
                $cartItem->jumlah = $newQuantity;
            } else {
                $cartItem->jumlah = $request->jumlah;
            }

            $cartItem->save();
            
            DB::commit();
            
            return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menambahkan produk ke keranjang.');
        }
    }

    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1|max:' . $produk->stok,
        ]);

        try {
            $cartItem = CartItem::where('user_id', Auth::id())
                ->where('produk_id', $produk->id)
                ->firstOrFail();

            $cartItem->jumlah = $request->jumlah;
            $cartItem->save();

            return response()->json([
                'message' => 'Jumlah produk berhasil diperbarui!',
                'total' => $cartItem->total,
                'cartTotal' => Auth::user()->cartItems->sum('total')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat memperbarui jumlah produk.'
            ], 500);
        }
    }

    public function remove(Produk $produk)
    {
        try {
            CartItem::where('user_id', Auth::id())
                ->where('produk_id', $produk->id)
                ->delete();

            return back()->with('success', 'Produk berhasil dihapus dari keranjang!');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus produk dari keranjang.');
        }
    }

    public function clear()
    {
        try {
            CartItem::where('user_id', Auth::id())->delete();
            return back()->with('success', 'Keranjang berhasil dikosongkan!');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengosongkan keranjang.');
        }
    }

    public function count()
    {
        return response()->json([
            'count' => CartItem::where('user_id', Auth::id())->sum('jumlah')
        ]);
    }

    public function validate()
    {
        $cartItems = CartItem::where('user_id', auth()->id())
            ->with('produk')
            ->get();

        $valid = true;
        foreach ($cartItems as $item) {
            if ($item->jumlah > $item->produk->stok) {
                $valid = false;
                break;
            }
        }

        return response()->json(['valid' => $valid]);
    }
}
