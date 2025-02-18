@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Keranjang Belanja</h5>

                @forelse($cartItems as $item)
                <div class="row mb-4 align-items-center">
                    <div class="col-md-2">
                        <img src="{{ asset('storage/' . $item->produk->gambar) }}" 
                            class="img-fluid rounded" alt="{{ $item->produk->nama }}">
                    </div>
                    <div class="col-md-4">
                        <h5>{{ $item->produk->nama }}</h5>
                        <p class="text-muted">{{ $item->produk->kategori->nama }}</p>
                    </div>
                    <div class="col-md-2">
                        <p class="mb-0">Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</p>
                    </div>
                    <div class="col-md-2">
                        <form action="{{ route('cart.update', $item->produk) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="number" name="jumlah" class="form-control" 
                                value="{{ $item->jumlah }}" min="1" max="{{ $item->produk->stok }}"
                                onchange="this.form.submit()">
                        </form>
                    </div>
                    <div class="col-md-2 text-end">
                        <form action="{{ route('cart.remove', $item->produk) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="text-center py-4">
                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                    <p>Keranjang belanja Anda kosong.</p>
                    <a href="{{ route('products.katalog') }}" class="btn btn-primary">
                        Mulai Belanja
                    </a>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Ringkasan Belanja</h5>
                
                <div class="d-flex justify-content-between mb-3">
                    <span>Total ({{ $cartItems->count() }} item)</span>
                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>

                <hr>

                @if($cartItems->count() > 0)
                <a href="{{ route('checkout') }}" class="btn btn-primary w-100">
                    Lanjut ke Pembayaran
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
