@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <!-- Statistik -->
    <div class="col-md-3 mb-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Total Pesanan</h6>
                        <h2 class="mb-0">{{ $totalPesanan }}</h2>
                    </div>
                    <i class="fas fa-shopping-cart fa-2x"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Total Produk</h6>
                        <h2 class="mb-0">{{ $totalProduk }}</h2>
                    </div>
                    <i class="fas fa-box fa-2x"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Total Pelanggan</h6>
                        <h2 class="mb-0">{{ $totalPelanggan }}</h2>
                    </div>
                    <i class="fas fa-users fa-2x"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Pendapatan</h6>
                        <h2 class="mb-0">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h2>
                    </div>
                    <i class="fas fa-money-bill-wave fa-2x"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Pesanan Terbaru -->
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title mb-0">Pesanan Terbaru</h5>
                    <a href="{{ route('pesanans.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Pelanggan</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pesananTerbaru as $pesanan)
                            <tr>
                                <td>#{{ $pesanan->id }}</td>
                                <td>{{ $pesanan->pelanggan->nama }}</td>
                                <td>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                                <td>
                                    @if($pesanan->status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($pesanan->status == 'processing')
                                        <span class="badge bg-info">Diproses</span>
                                    @elseif($pesanan->status == 'shipped')
                                        <span class="badge bg-primary">Dikirim</span>
                                    @elseif($pesanan->status == 'completed')
                                        <span class="badge bg-success">Selesai</span>
                                    @else
                                        <span class="badge bg-danger">Dibatalkan</span>
                                    @endif
                                </td>
                                <td>{{ $pesanan->created_at->format('d M Y H:i') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Produk Terlaris -->
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Produk Terlaris</h5>

                @foreach($produkTerlaris as $produk)
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset('storage/' . $produk->gambar) }}" 
                         class="rounded" alt="{{ $produk->nama }}"
                         style="width: 50px; height: 50px; object-fit: cover;">
                    <div class="ms-3">
                        <h6 class="mb-0">{{ $produk->nama }}</h6>
                        <small class="text-muted">{{ $produk->total_terjual }} terjual</small>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
