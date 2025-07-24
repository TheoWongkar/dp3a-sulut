<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/berita', [PostController::class, 'index'])->name('post.index');
Route::get('/berita/{slug}', [PostController::class, 'show'])->name('post.show');
Route::get('/cek-status-laporan', [ReportController::class, 'checkStatus'])->name('report.check-status');
Route::get('/buat-laporan', [ReportController::class, 'create'])->name('report.create');
Route::post('/buat-laporan', [ReportController::class, 'store'])->middleware('throttle:5,5')->name('report.store');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->middleware('throttle:5,5')->name('authenticate');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->middleware('throttle:5,5')->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
