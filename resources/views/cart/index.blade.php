@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@push('styles')
<style>
    .quantity-control {
        width: 120px;
    }
    .product-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-shopping-cart me-2"></i>Keranjang Belanja
                    </h5>
                    @if($cartItems->isNotEmpty())
                        <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm" 
                                    onclick="return confirm('Apakah Anda yakin ingin mengosongkan keranjang?')">
                                <i class="fas fa-trash me-1"></i>Kosongkan Keranjang
                            </button>
                        </form>
                    @endif
                </div>

                @forelse($cartItems as $item)
                <div class="cart-item mb-4" data-item-id="{{ $item->id }}">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <img src="{{ asset('storage/' . $item->produk->gambar) }}" 
                                 alt="{{ $item->produk->nama }}"
                                 class="product-image rounded">
                        </div>
                        <div class="col-md-4">
                            <h5 class="mb-1">
                                <a href="{{ route('products.show', $item->produk) }}" 
                                   class="text-decoration-none">{{ $item->produk->nama }}</a>
                            </h5>
                            <p class="text-muted mb-0">
                                Kategori: {{ $item->produk->kategori->nama }}
                            </p>
                            <p class="text-primary mb-0">
                                Rp {{ number_format($item->produk->harga, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="col-md-3">
                            <div class="quantity-control input-group">
                                <button type="button" class="btn btn-outline-secondary decrement">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" class="form-control text-center quantity-input"
                                       value="{{ $item->jumlah }}" 
                                       min="1" 
                                       max="{{ $item->produk->stok }}"
                                       data-produk-id="{{ $item->produk->id }}"
                                       data-harga="{{ $item->produk->harga }}">
                                <button type="button" class="btn btn-outline-secondary increment">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <small class="text-muted d-block mt-1">
                                Stok: {{ $item->produk->stok }}
                            </small>
                        </div>
                        <div class="col-md-2">
                            <div class="item-subtotal text-end" 
                                 data-subtotal="{{ $item->produk->harga * $item->jumlah }}">
                                Rp {{ number_format($item->produk->harga * $item->jumlah, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-md-1">
                            <form action="{{ route('cart.remove', $item->produk) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" 
                                        onclick="return confirm('Hapus produk ini dari keranjang?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                    <h5>Keranjang Belanja Kosong</h5>
                    <p class="text-muted">Anda belum menambahkan produk ke keranjang.</p>
                    <a href="{{ route('products.katalog') }}" class="btn btn-primary">
                        <i class="fas fa-store me-1"></i>Mulai Belanja
                    </a>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Ringkasan Belanja</h5>
                
                <div class="d-flex justify-content-between mb-3">
                    <span>Total ({{ $cartItems->sum('jumlah') }} item)</span>
                    <span class="cart-total">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>

                <hr>

                @if($cartItems->isNotEmpty())
                <a href="{{ route('checkout') }}" class="btn btn-primary w-100">
                    <i class="fas fa-shopping-bag me-1"></i>Lanjut ke Pembayaran
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const formatPrice = (price) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(price).replace('IDR', 'Rp');
    };

    const updateCartTotal = () => {
        let total = 0;
        document.querySelectorAll('.item-subtotal').forEach(subtotal => {
            total += parseInt(subtotal.dataset.subtotal);
        });
        document.querySelector('.cart-total').textContent = formatPrice(total);
    };

    const updateItemSubtotal = (quantityInput) => {
        const harga = parseInt(quantityInput.dataset.harga);
        const jumlah = parseInt(quantityInput.value);
        const subtotal = harga * jumlah;
        
        const subtotalElement = quantityInput.closest('.cart-item')
            .querySelector('.item-subtotal');
        subtotalElement.textContent = formatPrice(subtotal);
        subtotalElement.dataset.subtotal = subtotal;
        
        updateCartTotal();
    };

    document.querySelectorAll('.quantity-control').forEach(control => {
        const input = control.querySelector('.quantity-input');
        const decrementBtn = control.querySelector('.decrement');
        const incrementBtn = control.querySelector('.increment');
        
        decrementBtn.addEventListener('click', () => {
            const currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
                updateQuantity(input);
            }
        });
        
        incrementBtn.addEventListener('click', () => {
            const currentValue = parseInt(input.value);
            const max = parseInt(input.max);
            if (currentValue < max) {
                input.value = currentValue + 1;
                updateQuantity(input);
            }
        });
        
        input.addEventListener('change', () => {
            updateQuantity(input);
        });
    });

    const updateQuantity = async (input) => {
        const produkId = input.dataset.produkId;
        const quantity = input.value;
        
        try {
            const response = await fetch(`/cart/update/${produkId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ jumlah: quantity })
            });
            
            const data = await response.json();
            
            if (response.ok) {
                updateItemSubtotal(input);
                showToast(data.message, 'success');
            } else {
                throw new Error(data.error);
            }
        } catch (error) {
            showToast(error.message, 'error');
            // Reset to previous value
            input.value = input.defaultValue;
        }
    };
});
</script>
@endpush
