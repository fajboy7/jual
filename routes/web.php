<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HomeController; // Tambahkan ini jika HomeController digunakan di /home

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth Routes (Jika menggunakan Laravel UI, atau Breeze/Jetstream akan menggunakan require auth.php)
Auth::routes(); // Ini mendaftarkan rute seperti /login, /register, /password/reset, dll.
require __DIR__.'/auth.php'; // Jika Anda menggunakan Breeze/Jetstream, file ini akan ada. Jika Laravel UI, Auth::routes() sudah cukup.

Route::get('/home', [HomeController::class, 'index'])->name('home');


// Public Routes (Untuk semua pengguna, termasuk tamu)
// products.index akan menampilkan daftar produk
// products.show akan menampilkan detail satu produk
Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');


// Admin/Seller Routes (Hanya untuk pengguna yang terotentikasi DAN memiliki role admin)
Route::middleware(['auth', 'can:isAdmin'])->group(function () {
    // Menggunakan Route::resource untuk CRUD Product Management
    // Ini akan secara otomatis membuat rute-rute berikut:
    // GET /products/create     -> products.create (untuk form tambah)
    // POST /products          -> products.store    (untuk menyimpan produk)
    // GET /products/{product}/edit -> products.edit (untuk form edit)
    // PUT/PATCH /products/{product} -> products.update (untuk update produk)
    // DELETE /products/{product} -> products.destroy (untuk hapus produk)
    // Serta:
    // GET /products          -> products.index (sudah didefinisikan di public, tapi resource juga membuat)
    // GET /products/{product} -> products.show (sudah didefinisikan di public, tapi resource juga membuat)
    // Jika Anda ingin menimpa index/show, tempatkan resource di atas public.
    // Atau, jika hanya ingin membuat subset rute, gunakan: Route::resource('products', ProductController::class)->except(['index', 'show']);
    // Untuk kasus Anda, karena index & show sudah di public, kita bisa mengecualikannya:
    Route::resource('products', ProductController::class)->except(['index', 'show']);

    // Anda juga bisa menambahkan rute untuk admin/seller yang spesifik dan tidak termasuk dalam resource jika ada.
});


// Authenticated User Routes (Untuk pengguna yang terotentikasi, pembeli)
Route::middleware('auth')->group(function () {
    // Rute untuk Order Management (biasanya untuk melihat order yang dibuat user)
    // Jika ada lebih banyak operasi CRUD pada order, pertimbangkan Route::resource di sini juga
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    // Contoh rute lain untuk pembeli:
    // Route::post('/products/{product}/buy', [OrderController::class, 'buy'])->name('products.buy');
});