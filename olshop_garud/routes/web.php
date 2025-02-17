<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProdukController;
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