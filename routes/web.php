<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\DetailPesananController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Halaman Utama
Route::get('/', [HomeController::class, 'index'])->name('home');

// Katalog Produk
Route::get('/products', [ProdukController::class, 'katalog'])->name('products.katalog');
Route::get('/products/{produk}', [ProdukController::class, 'show'])->name('products.show');
Route::get('/category/{kategori}', [KategoriController::class, 'show'])->name('category.show');

// Keranjang Belanja
Route::group(['middleware' => 'auth'], function() {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{produk}', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update/{produk}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{produk}', [CartController::class, 'remove'])->name('cart.remove');
    
    // Checkout dan Pesanan
    Route::get('/checkout', [PesananController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/process', [PesananController::class, 'process'])->name('checkout.process');
    Route::get('/orders', [PesananController::class, 'userOrders'])->name('user.orders');
    Route::get('/orders/{pesanan}', [PesananController::class, 'userOrderDetail'])->name('user.orders.detail');
});

// Admin Routes
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function() {
    // Dashboard
    Route::get('/', function() {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    
    // Kategori Management
    Route::resource('kategoris', KategoriController::class);
    
    // Produk Management
    Route::resource('produks', ProdukController::class);
    
    // Pelanggan Management
    Route::resource('pelanggans', PelangganController::class);
    
    // Pesanan Management
    Route::resource('pesanans', PesananController::class);
    Route::get('pesanans/{pesanan}/detail', [PesananController::class, 'detail'])->name('admin.pesanan.detail');
    Route::put('pesanans/{pesanan}/status', [PesananController::class, 'updateStatus'])->name('admin.pesanan.status');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Profile Routes
Route::group(['middleware' => 'auth'], function() {
    Route::get('/profile', [PelangganController::class, 'profile'])->name('profile');
    Route::put('/profile', [PelangganController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [PelangganController::class, 'updatePassword'])->name('profile.password');
});
