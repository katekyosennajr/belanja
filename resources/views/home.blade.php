@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="row">
    <!-- Hero Section -->
    <div class="col-12 mb-4">
        <div class="bg-primary text-white p-5 rounded">
            <h1>Selamat Datang di Belanja</h1>
            <p class="lead">Temukan berbagai produk berkualitas dengan harga terbaik.</p>
            <a href="{{ route('products.katalog') }}" class="btn btn-light btn-lg">Mulai Belanja</a>
        </div>
    </div>

    <!-- Kategori Section -->
    <div class="col-12 mb-4">
        <h2>Kategori</h2>
        <div class="row g-4">
            @foreach($kategoris as $kategori)
            <div class="col-md-4">
                <a href="{{ route('category.show', $kategori) }}" class="text-decoration-none">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title text-dark">{{ $kategori->nama }}</h5>
                            <p class="card-text text-muted">{{ $kategori->produks_count }} Produk</p>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Produk Terbaru -->
    <div class="col-12 mb-4">
        <h2>Produk Terbaru</h2>
        <div class="row g-4">
            @foreach($produkTerbaru as $produk)
            <div class="col-md-3">
                <div class="card h-100">
                    <img src="{{ asset('storage/' . $produk->gambar) }}" class="card-img-top" alt="{{ $produk->nama }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $produk->nama }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($produk->deskripsi, 100) }}</p>
                        <p class="card-text"><strong>Rp {{ number_format($produk->harga, 0, ',', '.') }}</strong></p>
                        <a href="{{ route('products.show', $produk) }}" class="btn btn-primary">Lihat Detail</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
