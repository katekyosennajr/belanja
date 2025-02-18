@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Edit Produk</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.produk.update', $produk) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama" class="form-control-label">Nama Produk</label>
                                    <input class="form-control @error('nama') is-invalid @enderror" type="text" id="nama" name="nama" value="{{ old('nama', $produk->nama) }}" required>
                                    @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kategori_id" class="form-control-label">Kategori</label>
                                    <select class="form-control @error('kategori_id') is-invalid @enderror" id="kategori_id" name="kategori_id" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}" {{ (old('kategori_id', $produk->kategori_id) == $kategori->id) ? 'selected' : '' }}>
                                                {{ $kategori->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kategori_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="harga" class="form-control-label">Harga</label>
                                    <input class="form-control @error('harga') is-invalid @enderror" type="number" id="harga" name="harga" value="{{ old('harga', $produk->harga) }}" required min="0">
                                    @error('harga')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="stok" class="form-control-label">Stok</label>
                                    <input class="form-control @error('stok') is-invalid @enderror" type="number" id="stok" name="stok" value="{{ old('stok', $produk->stok) }}" required min="0">
                                    @error('stok')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="deskripsi" class="form-control-label">Deskripsi</label>
                                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3" required>{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="gambar" class="form-control-label">Gambar Produk</label>
                                    @if($produk->gambar)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama }}" class="img-thumbnail" style="max-height: 200px">
                                        </div>
                                    @endif
                                    <input class="form-control @error('gambar') is-invalid @enderror" type="file" id="gambar" name="gambar" accept="image/*">
                                    <small class="text-muted">Format: JPG, JPEG, PNG (Max. 2MB). Biarkan kosong jika tidak ingin mengubah gambar.</small>
                                    @error('gambar')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn bg-gradient-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
