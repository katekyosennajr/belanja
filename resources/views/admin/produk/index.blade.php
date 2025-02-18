@extends('layouts.app')

@section('title', 'Kelola Produk')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-6 d-flex align-items-center">
                            <h6 class="mb-0">Daftar Produk</h6>
                        </div>
                        <div class="col-6 text-end">
                            <a class="btn bg-gradient-primary mb-0" href="{{ route('admin.produk.create') }}">
                                <i class="fas fa-plus"></i>&nbsp;&nbsp;Tambah Produk
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Produk</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kategori</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Harga</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Stok</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($produks as $produk)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="{{ asset('storage/' . $produk->gambar) }}" class="avatar avatar-sm me-3" alt="{{ $produk->nama }}">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $produk->nama }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ Str::limit($produk->deskripsi, 50) }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $produk->kategori->nama }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $produk->stok }}</p>
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('admin.produk.edit', $produk) }}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit produk">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.produk.destroy', $produk) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-danger font-weight-bold text-xs border-0 bg-transparent" data-toggle="tooltip" data-original-title="Hapus produk" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="px-3 mt-3">
                        {{ $produks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.avatar-sm {
    width: 36px;
    height: 36px;
    object-fit: cover;
}
</style>
@endpush
@endsection
