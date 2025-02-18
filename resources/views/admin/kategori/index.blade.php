@extends('layouts.app')

@section('title', 'Kelola Kategori')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-6 d-flex align-items-center">
                            <h6 class="mb-0">Daftar Kategori</h6>
                        </div>
                        <div class="col-6 text-end">
                            <a class="btn bg-gradient-primary mb-0" href="{{ route('admin.kategori.create') }}">
                                <i class="fas fa-plus"></i>&nbsp;&nbsp;Tambah Kategori
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Slug</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Deskripsi</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total Produk</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kategoris as $kategori)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $kategori->nama }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $kategori->slug }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs text-secondary mb-0">{{ $kategori->deskripsi }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $kategori->produks_count }}</p>
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('admin.kategori.edit', $kategori) }}" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit kategori">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.kategori.destroy', $kategori) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-danger font-weight-bold text-xs border-0 bg-transparent" data-toggle="tooltip" data-original-title="Hapus kategori" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
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
                        {{ $kategoris->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
