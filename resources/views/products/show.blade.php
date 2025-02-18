@extends('layouts.app')

@section('title', $produk->nama)

@section('content')
<div class="row">
    <div class="col-md-6">
        <img src="{{ asset('storage/' . $produk->gambar) }}" class="img-fluid rounded" alt="{{ $produk->nama }}">
    </div>
    <div class="col-md-6">
        <h1>{{ $produk->nama }}</h1>
        <p class="text-muted mb-2">Kategori: 
            <a href="{{ route('category.show', $produk->kategori) }}">{{ $produk->kategori->nama }}</a>
        </p>
        <h2 class="text-primary mb-4">Rp {{ number_format($produk->harga, 0, ',', '.') }}</h2>
        
        <div class="mb-4">
            <h5>Deskripsi</h5>
            <p>{{ $produk->deskripsi }}</p>
        </div>

        <div class="mb-4">
            <h5>Stok</h5>
            <p>{{ $produk->stok }} unit tersedia</p>
        </div>

        @auth
        <form action="{{ route('cart.add', $produk) }}" method="POST" class="mb-4">
            @csrf
            <div class="row g-3">
                <div class="col-auto">
                    <input type="number" name="jumlah" class="form-control" value="1" min="1" max="{{ $produk->stok }}">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                    </button>
                </div>
            </div>
        </form>
        @else
        <div class="alert alert-info">
            <a href="{{ route('login') }}">Login</a> untuk menambahkan produk ke keranjang.
        </div>
        @endauth

        <!-- Related Products -->
        <div class="mt-5">
            <h5>Produk Terkait</h5>
            <div class="row g-4">
                @foreach($relatedProducts as $related)
                <div class="col-md-6">
                    <div class="card">
                        <img src="{{ asset('storage/' . $related->gambar) }}" class="card-img-top" alt="{{ $related->nama }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $related->nama }}</h5>
                            <p class="card-text">Rp {{ number_format($related->harga, 0, ',', '.') }}</p>
                            <a href="{{ route('products.show', $related) }}" class="btn btn-outline-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
