<?php

use App\Http\Middleware\AuthCheck;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OpdController;
use App\Http\Controllers\SopController;
use App\Http\Controllers\TteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;

Route::get('/', [HomeController::class, 'index'])->name('home');
// Halaman login: hanya bisa diakses kalau BELUM login
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Logout: hanya bisa dilakukan kalau SUDAH login
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');


Route::get('/logout', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }

    return redirect('/login');
});

// Halaman setelah login
Route::middleware(['auth', AuthCheck::class . ':admin,user'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::resource('/sops', SopController::class)->middleware('auth');


Route::get('/sops/preview/{slug}', [SopController::class, 'preview'])->name('sops.preview')->middleware('auth');
Route::get('/sops/stream/{slug}', [SopController::class, 'stream'])->name('sops.stream')->middleware('auth');
Route::post('/sops/update-status/{id}', [SopController::class, 'updateStatus'])->name('sops.update_status')->middleware('auth');

Route::post('/sops/review/{slug}', [SopController::class, 'review'])->name('sops.review')->middleware('auth');

Route::resource('sops', SopController::class)->except(['show']);

Route::get('/sops/{sop}', [SopController::class, 'show'])->name('sops.show');

Route::post('/sops/tte/{slug}', [SopController::class, 'processTte'])->name('sops.process_tte')->middleware('auth');


Route::post('/sops/{slug}/tte', [TteController::class, 'submitTte'])->name('sops.tte.form');


Route::resource('/opds', OpdController::class)->middleware('auth');


Route::resource('users', UserController::class)->middleware('auth', 'role:admin');
