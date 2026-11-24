<?php

use App\Http\Controllers\AuthController;
use App\Models\Catatan;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('dashboard'));

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard', [
            'catatanAktif' => Catatan::latest()->take(4)->get(),
            'jumlahAktif' => Catatan::count(),
            'jumlahTerhapus' => Catatan::onlyTrashed()->count(),
        ]);
    })->name('dashboard');
    Route::livewire('/catatan', 'catatan-index')->name('catatan');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
