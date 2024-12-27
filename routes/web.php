<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DetailTransaksiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\KategoriController;

// Route Barang
Route::prefix('barang')->group(function () {
    Route::get('/', [BarangController::class, 'index'])->name('barang.index');
    Route::get('/create', [BarangController::class, 'create'])->name('barang.create');
    Route::post('/', [BarangController::class, 'store'])->name('barang.store');
    Route::get('/{barang}', [BarangController::class, 'show'])->name('barang.show');
    Route::get('/{barang}/edit', [BarangController::class, 'edit'])->name('barang.edit');
    Route::put('/{barang}', [BarangController::class, 'update'])->name('barang.update');
    Route::delete('/{barang}', [BarangController::class, 'destroy'])->name('barang.destroy');
});

// Route Pembeli
Route::prefix('pembeli')->group(function () {
    Route::get('/', [PembeliController::class, 'index'])->name('pembeli.index');
    Route::get('/create', [PembeliController::class, 'create'])->name('pembeli.create');
    Route::post('/', [PembeliController::class, 'store'])->name('pembeli.store');
    Route::get('/{pembeli}', [PembeliController::class, 'show'])->name('pembeli.show');
    Route::get('/{pembeli}/edit', [PembeliController::class, 'edit'])->name('pembeli.edit');
    Route::put('/{pembeli}', [PembeliController::class, 'update'])->name('pembeli.update');
    Route::delete('/{pembeli}', [PembeliController::class, 'destroy'])->name('pembeli.destroy');
});

// Route Transaksi
Route::prefix('transaksi')->group(function () {
    Route::get('/', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/create', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/{transaksi}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::get('/{transaksi}/edit', [TransaksiController::class, 'edit'])->name('transaksi.edit');
    Route::put('/{transaksi}', [TransaksiController::class, 'update'])->name('transaksi.update');
    Route::delete('/{transaksi}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');
    
    // Route khusus untuk detail transaksi
    Route::get('/{transaksi}/detail', [TransaksiController::class, 'showDetails'])->name('transaksi.details');
});

// Route Detail Transaksi
// Route::prefix('detail-transaksi')->group(function () {
//     Route::get('/', [DetailTransaksiController::class, 'index'])->name('detail-transaksi.index');
//     Route::get('/create', [DetailTransaksiController::class, 'create'])->name('detail-transaksi.create');
//     Route::post('/', [DetailTransaksiController::class, 'store'])->name('detail-transaksi.store');
//     Route::get('/{detailTransaksi}', [DetailTransaksiController::class, 'show'])->name('detail-transaksi.show');
//     Route::get('/{detailTransaksi}/edit', [DetailTransaksiController::class, 'edit'])->name('detail-transaksi.edit');
//     Route::put('/{detailTransaksi}', [DetailTransaksiController::class, 'update'])->name('detail-transaksi.update');
//     Route::delete('/{detailTransaksi}', [DetailTransaksiController::class, 'destroy'])->name('detail-transaksi.destroy');
// });

// Contoh Route Laporan dan Statistik
// Route::prefix('laporan')->group(function () {
//     Route::get('/penjualan', [TransaksiController::class, 'laporanPenjualan'])->name('laporan.penjualan');
//     Route::get('/stok-barang', [BarangController::class, 'laporanStok'])->name('laporan.stok');
//     Route::get('/pembeli-aktif', [PembeliController::class, 'pembeliTeraktif'])->name('laporan.pembeli-aktif');
// });

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');






Route::resource('supplier', SupplierController::class);

// // In web.php or your routes file
// Route::get('/routes', function() {
//     $routes = Route::getRoutes();
//     foreach($routes as $route) {
//         if(str_contains($route->uri, 'transaksi')) {
//             dump([
//                 'uri' => $route->uri,
//                 'middleware' => $route->middleware()
//             ]);
//         }
//     }
// });