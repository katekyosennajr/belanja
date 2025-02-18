<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Health check route
Route::get('/health', function () {
    return response()->json(['status' => 'healthy']);
});

// Admin Routes
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function() {
    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Kategori
    Route::resource('kategori', KategoriController::class);
    
    // Produk
    Route::resource('produk', ProdukController::class);
    
    // Pesanan
    Route::get('pesanan', [PesananController::class, 'adminIndex'])->name('admin.pesanan.index');
    Route::get('pesanan/{pesanan}', [PesananController::class, 'adminShow'])->name('admin.pesanan.show');
    Route::put('pesanan/{pesanan}/status', [PesananController::class, 'updateStatus'])->name('admin.pesanan.status');
    
    // Pelanggan
    Route::get('pelanggan', [PelangganController::class, 'index'])->name('admin.pelanggan.index');
    Route::get('pelanggan/{user}', [PelangganController::class, 'show'])->name('admin.pelanggan.show');
});

require __DIR__.'/auth.php';
