<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'App\Http\Controllers\Auth\LoginController@login');
Route::post('/logout', 'App\Http\Controllers\Auth\LogoutController@signout')->name('logout');
Route::get('/register', 'App\Http\Controllers\Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/register', 'App\Http\Controllers\Auth\RegisterController@register');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('adminHome');
});

Route::get('/produk', [ProdukController::class, 'index'])->name('managerHome');
Route::get('produk/create', [ProdukController::class, 'create'])->name('produk.create');
Route::post('produk', [ProdukController::class, 'store'])->name('produk.store');
Route::get('produk/{id}', [ProdukController::class, 'show'])->name('produk.show');
Route::get('produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
Route::put('produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
Route::delete('produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');

// Cart Routes
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

// User Transaction Routes
Route::get('/transaction/approval', [TransactionController::class, 'userApproval'])->name('transaction.approval');
Route::post('/transaction/{id}/cancel', [TransactionController::class, 'cancel'])->name('transaction.cancel');
Route::get('/transaction/{id}/download', [TransactionController::class, 'downloadPDF'])->name('transaction.download');
Route::get('/transaction/{id}/download', [TransactionController::class, 'generatePdf'])->name('transaction.download');

// Admin Approval Routes
Route::get('/transaction/admin/approval', [TransactionController::class, 'adminApproval'])->name('transaction.adminApproval');
Route::post('/transaction/{id}/approve', [TransactionController::class, 'approve'])->name('admin.transaction.approve');
Route::post('/transaction/{id}/reject', [TransactionController::class, 'reject'])->name('admin.transaction.reject');

// Kategori
Route::resource('kategori', KategoriController::class);