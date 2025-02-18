@extends('layouts.admin')

@section('title', 'Manajemen Produk')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex">
                <form action="{{ route('produks.index') }}" method="GET" class="d-flex me-3">
                    <input type="text" name="search" class="form-control me-2" 
                           placeholder="Cari produk..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </form>
                
                <select name="kategori" class="form-select" style="width: 200px;" 
                        onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" 
                            {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <a href="{{ route('produks.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Produk
            </a>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produks as $produk)
                    <tr>
                        <td>{{ $produk->id }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $produk->gambar) }}" 
                                 alt="{{ $produk->nama }}"
                                 style="width: 50px; height: 50px; object-fit: cover;"
                                 class="rounded">
                        </td>
                        <td>{{ $produk->nama }}</td>
                        <td>{{ $produk->kategori->nama }}</td>
                        <td>Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                        <td>{{ $produk->stok }}</td>
                        <td>
                            @if($produk->stok > 0)
                                <span class="badge bg-success">Tersedia</span>
                            @else
                                <span class="badge bg-danger">Habis</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('produks.edit', $produk) }}" 
                                   class="btn btn-sm btn-info">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('produks.destroy', $produk) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $produks->links() }}
        </div>
    </div>
</div>
@endsection
