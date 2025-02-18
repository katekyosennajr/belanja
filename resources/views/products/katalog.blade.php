@extends('layouts.app')

@section('title', 'Katalog Produk')

@section('content')
<div class="row">
    <!-- Filter Sidebar -->
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Filter</h5>
                <form action="{{ route('products.katalog') }}" method="GET">
                    <!-- Kategori Filter -->
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        @foreach($kategoris as $kategori)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="kategori[]" 
                                value="{{ $kategori->id }}" {{ in_array($kategori->id, request('kategori', [])) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $kategori->nama }}</label>
                        </div>
                        @endforeach
                    </div>

                    <!-- Harga Filter -->
                    <div class="mb-3">
                        <label class="form-label">Rentang Harga</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" name="harga_min" 
                                value="{{ request('harga_min') }}" placeholder="Min">
                        </div>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" name="harga_max" 
                                value="{{ request('harga_max') }}" placeholder="Max">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Terapkan Filter</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Product Grid -->
    <div class="col-md-9">
        <!-- Search and Sort -->
        <div class="row mb-4">
            <div class="col-md-6">
                <form action="{{ route('products.katalog') }}" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" 
                        value="{{ request('search') }}" placeholder="Cari produk...">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </form>
            </div>
            <div class="col-md-6 text-end">
                <select class="form-select w-auto float-end" name="sort" onchange="this.form.submit()">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga: Rendah ke Tinggi</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga: Tinggi ke Rendah</option>
                </select>
            </div>
        </div>

        <!-- Products -->
        <div class="row g-4">
            @forelse($produks as $produk)
            <div class="col-md-4">
                <div class="card h-100">
                    <img src="{{ asset('storage/' . $produk->gambar) }}" class="card-img-top" alt="{{ $produk->nama }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $produk->nama }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($produk->deskripsi, 100) }}</p>
                        <p class="card-text">
                            <strong>Rp {{ number_format($produk->harga, 0, ',', '.') }}</strong>
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('products.show', $produk) }}" class="btn btn-primary">Lihat Detail</a>
                            @auth
                            <form action="{{ route('cart.add', $produk) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                            </form>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info">
                    Tidak ada produk yang ditemukan.
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $produks->links() }}
        </div>
    </div>
</div>
@endsection
