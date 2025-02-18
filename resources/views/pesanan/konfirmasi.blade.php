@extends('layouts.app')

@section('title', 'Konfirmasi Pesanan')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                    </div>
                    <h3 class="card-title mb-4">Pesanan Berhasil Dibuat!</h3>
                    <p class="mb-1">Nomor Pesanan: <strong>{{ $pesanan->nomor_pesanan }}</strong></p>
                    <p class="mb-4">Total Pembayaran: <strong>Rp {{ number_format($pesanan->total, 0, ',', '.') }}</strong></p>

                    @if($pesanan->metode_pembayaran == 'transfer')
                        <div class="alert alert-info mb-4">
                            <h5 class="alert-heading">Instruksi Pembayaran</h5>
                            <p class="mb-0">Silakan transfer ke rekening berikut:</p>
                            <p class="mb-0"><strong>Bank BCA</strong></p>
                            <p class="mb-0"><strong>1234567890</strong></p>
                            <p class="mb-0"><strong>a.n. PT Belanja Indonesia</strong></p>
                        </div>
                    @else
                        <div class="alert alert-info mb-4">
                            <h5 class="alert-heading">Cash on Delivery (COD)</h5>
                            <p class="mb-0">Siapkan uang tunai sebesar <strong>Rp {{ number_format($pesanan->total, 0, ',', '.') }}</strong></p>
                            <p class="mb-0">saat kurir tiba di alamat Anda.</p>
                        </div>
                    @endif

                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Detail Pengiriman</h5>
                            <p class="mb-1">Nama Penerima: {{ $pesanan->nama_penerima }}</p>
                            <p class="mb-1">Telepon: {{ $pesanan->telepon }}</p>
                            <p class="mb-0">Alamat: {{ $pesanan->alamat }}</p>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Produk yang Dipesan</h5>
                            @foreach($pesanan->detailPesanan as $detail)
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h6 class="mb-0">{{ $detail->produk->nama }}</h6>
                                        <small class="text-muted">{{ $detail->jumlah }}x @ Rp {{ number_format($detail->harga, 0, ',', '.') }}</small>
                                    </div>
                                    <span>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span>Subtotal</span>
                                <span>Rp {{ number_format($pesanan->subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Ongkos Kirim</span>
                                <span>Rp {{ number_format($pesanan->ongkir, 0, ',', '.') }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <strong>Total</strong>
                                <strong>Rp {{ number_format($pesanan->total, 0, ',', '.') }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="{{ route('pesanan.index') }}" class="btn btn-primary">Lihat Daftar Pesanan</a>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">Kembali ke Beranda</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
