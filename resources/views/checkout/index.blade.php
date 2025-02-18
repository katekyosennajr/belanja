@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title mb-4">Alamat Pengiriman</h5>
                <form id="checkoutForm" action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Nama Penerima</label>
                        <input type="text" name="nama_penerima" class="form-control" value="{{ auth()->user()->nama }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="tel" name="telepon" class="form-control" value="{{ auth()->user()->telepon }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="alamat" class="form-control" rows="3" required>{{ auth()->user()->alamat }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Catatan (opsional)</label>
                        <textarea name="catatan" class="form-control" rows="2"></textarea>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Metode Pembayaran</h5>
                
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="metode_pembayaran" value="transfer" checked>
                    <label class="form-check-label">
                        Transfer Bank
                    </label>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="metode_pembayaran" value="cod">
                    <label class="form-check-label">
                        Cash on Delivery (COD)
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Ringkasan Pesanan</h5>

                @foreach($cartItems as $item)
                <div class="d-flex justify-content-between mb-3">
                    <span>{{ $item->produk->nama }} ({{ $item->jumlah }}x)</span>
                    <span>Rp {{ number_format($item->produk->harga * $item->jumlah, 0, ',', '.') }}</span>
                </div>
                @endforeach

                <hr>

                <div class="d-flex justify-content-between mb-3">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <span>Ongkos Kirim</span>
                    <span>Rp {{ number_format($ongkir, 0, ',', '.') }}</span>
                </div>

                <hr>

                <div class="d-flex justify-content-between mb-4">
                    <strong>Total</strong>
                    <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong>
                </div>

                <button type="submit" form="checkoutForm" class="btn btn-primary w-100">
                    Buat Pesanan
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
