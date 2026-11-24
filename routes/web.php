<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderStatusController;
use App\Http\Controllers\Admin\RekapController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// ===== HALAMAN PUBLIK / PELANGGAN =====
Route::get('/', [OrderController::class, 'index'])->name('home');
Route::post('/pesan', [OrderController::class, 'store'])
    ->middleware('throttle:10,1') // maksimal 10 pesanan per menit per pengunjung
    ->name('orders.store');

// Riwayat Pesanan Customer (Wajib Login)
Route::middleware('auth')->get('/riwayat-pesanan', [OrderController::class, 'customerOrders'])->name('customer.orders');

// ===== HALAMAN STAF (ADMIN & KASIR) =====
Route::middleware(['auth', 'staff'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        // Daftar Layanan (Read-only bisa dilihat oleh Kasir & Admin)
        Route::get('services', [ServiceController::class, 'index'])->name('services.index');

        // Perubahan Status Pesanan & Pembayaran (Bisa dilakukan oleh Kasir & Admin)
        Route::patch('orders/{order}/status', [OrderStatusController::class, 'update'])->name('orders.status');

        // Rekapitulasi Transaksi (Bisa dilihat oleh Kasir & Admin)
        Route::get('rekap', [RekapController::class, 'index'])->name('rekap');

        // CRUD Layanan (KHUSUS HANYA ADMIN: Tambah, Simpan, Edit, Update, Hapus)
        Route::middleware('admin')->group(function () {
            Route::get('services/create', [ServiceController::class, 'create'])->name('services.create');
            Route::post('services', [ServiceController::class, 'store'])->name('services.store');
            Route::get('services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
            Route::match(['put', 'patch'], 'services/{service}', [ServiceController::class, 'update'])->name('services.update');
            Route::delete('services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
        });
    });
});

require __DIR__.'/auth.php'; // route login/logout/register dari Breeze
