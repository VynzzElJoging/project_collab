<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DataManagementController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AnggotaController;

Route::get('/', function () {
    return view('landing');
})->name('landing');

// IEU JANG AUTENTIKASI DATA, BENTUKNA GROUP (SAACAN LOGIN, USR NA GUEST)

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login']);
});


// ROUTE JANG USER ADMIN
Route::get('/admin/home', function () {
    return view('admin.home');
})
    ->middleware(['auth', 'admin'])
    ->name('admin.home');

// DATA MANAGEMENT PASSWORD -> JANG NGATUR ADMIN SUPAYA BISA MASUK KANA PENGATURAN DATA

Route::post('/admin/data/verify-password', [DataManagementController::class, 'verifyPassword'])
    ->middleware(['auth', 'admin'])
    ->name('admin.data.verify-password');

// TERMASUK KANA GROUP DATA MANGEMENT -> DIMANA SETIAP NGAKSES PASTI AWALAN NA MAKE ADMIN/DATA
Route::middleware(['auth', 'admin', 'data.management'])
    ->prefix('admin/data')
    ->group(function () {
        Route::resource('/buku', BookController::class)
            ->parameters(['buku' => 'book'])
            ->except(['show'])
            ->names('admin.data.buku');

        Route::resource('/anggota', AnggotaController::class)
    ->except(['show'])
    ->names('admin.data.anggota');

        Route::get('/peminjaman', function () {
            return view('admin.data.peminjaman');
        })->name('admin.data.peminjaman');

        Route::get('/laporan', function () {
            return view('admin.data.laporan');
        })->name('admin.data.laporan');
    });

// ROUTE GUEST -> JANG USER ANU ROLE NA GUEST
Route::get('/guest/home', function () {
    return view('guest.home');
})
    ->middleware(['auth', 'guest.role'])
    ->name('guest.home');

// ROUTE LOGOUT
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');