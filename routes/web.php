<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DataManagementController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AnggotaController;
use Illuminate\Support\Facades\Auth;

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
    $books = \App\Models\Book::all();

    return view('guest.home', compact('books'));
})
    ->middleware(['auth', 'guest.role'])
    ->name('guest.home');
Route::get('/guest/profile', function () {
    return view('guest.profile');
})->middleware('auth')->name('guest.profile');

Route::post('/guest/profile', function (Illuminate\Http\Request $request) {

    $validated = $request->validate([
        'nama' => 'required|string|max:100',
        'email' => 'required|email|max:100',
        'tanggal_lahir' => 'required|date',
        'jenis_kelamin' => 'required|string',
        'alamat' => 'required|string|max:255',
        'no_hp' => 'required|string|max:20',
    ]);

    $anggota = Auth::user()->anggota;

    if (!$anggota) {
        $anggota = Auth::user()->anggota()->create($validated);
    } else {
        $anggota->update($validated);
    }

    return redirect()->route('guest.home')->with(
        'success',
        'Data profile berhasil disimpan.'
    );

})->middleware('auth')->name('guest.profile.update');
Route::post('/guest/profile/foto', function (Illuminate\Http\Request $request) {

    $request->validate([
        'foto' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $anggota = Auth::user()->anggota;

    if ($request->hasFile('foto')) {

        $path = $request->file('foto')->store('foto-anggota', 'public');

        $anggota->foto = $path;
        $anggota->save();
    }

    return back();

})->middleware('auth')->name('guest.profile.foto');
// ROUTE LOGOUT
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');