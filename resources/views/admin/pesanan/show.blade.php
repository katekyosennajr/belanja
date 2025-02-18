@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-6 d-flex align-items-center">
                            <h6 class="mb-0">Detail Pesanan #{{ $pesanan->id }}</h6>
                        </div>
                        <div class="col-6 text-end">
                            <form action="{{ route('admin.pesanan.status', $pesanan) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-select d-inline-block w-auto me-2">
                                    <option value="pending" {{ $pesanan->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="proses" {{ $pesanan->status == 'proses' ? 'selected' : '' }}>Proses</option>
                                    <option value="selesai" {{ $pesanan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="batal" {{ $pesanan->status == 'batal' ? 'selected' : '' }}>Batal</option>
                                </select>
                                <button type="submit" class="btn bg-gradient-primary mb-0">Update Status</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-uppercase text-body text-xs font-weight-bolder">Informasi Pelanggan</h6>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-0">
                                    <strong class="text-dark">Nama:</strong> {{ $pesanan->user->name }}
                                </li>
                                <li class="list-group-item px-0">
                                    <strong class="text-dark">Email:</strong> {{ $pesanan->user->email }}
                                </li>
                                <li class="list-group-item px-0">
                                    <strong class="text-dark">Telepon:</strong> {{ $pesanan->user->telepon }}
                                </li>
                                <li class="list-group-item px-0">
                                    <strong class="text-dark">Alamat:</strong> {{ $pesanan->user->alamat }}
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-uppercase text-body text-xs font-weight-bolder">Informasi Pesanan</h6>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-0">
                                    <strong class="text-dark">Status:</strong>
                                    <span class="badge badge-sm bg-gradient-{{ 
                                        $pesanan->status == 'pending' ? 'warning' : 
                                        ($pesanan->status == 'proses' ? 'info' : 
                                        ($pesanan->status == 'selesai' ? 'success' : 'danger')) 
                                    }}">
                                        {{ ucfirst($pesanan->status) }}
                                    </span>
                                </li>
                                <li class="list-group-item px-0">
                                    <strong class="text-dark">Tanggal Pesanan:</strong> {{ $pesanan->created_at->format('d/m/Y H:i') }}
                                </li>
                                <li class="list-group-item px-0">
                                    <strong class="text-dark">Total Pembayaran:</strong> Rp {{ number_format($pesanan->total, 0, ',', '.') }}
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">Detail Produk</h6>
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Produk</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Harga</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jumlah</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pesanan->detailPesanan as $detail)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="{{ asset('storage/' . $detail->produk->gambar) }}" class="avatar avatar-sm me-3" alt="{{ $detail->produk->nama }}">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $detail->produk->nama }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">Rp {{ number_format($detail->harga, 0, ',', '.') }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $detail->jumlah }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-end">
                                                <strong class="text-dark">Total:</strong>
                                            </td>
                                            <td>
                                                <strong class="text-dark">Rp {{ number_format($pesanan->total, 0, ',', '.') }}</strong>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('admin.pesanan.index') }}" class="btn btn-secondary">Kembali ke Daftar Pesanan</a>
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
