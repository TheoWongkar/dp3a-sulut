<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CheckStatusController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\PostController as DashboardPostController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/berita', [PostController::class, 'index'])->name('posts.index');
Route::get('/berita/{slug}', [PostController::class, 'show'])->name('posts.show');
Route::get('/cek-status', [CheckStatusController::class, 'index'])->name('status.index');
Route::get('/laporkan', [ReportController::class, 'create'])->name('reports.create');
Route::post('/laporkan', [ReportController::class, 'store'])->middleware('throttle:5,5')->name('reports.store');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->middleware('throttle:5,5');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('profil-saya', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('profil-saya/ubah', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profil-saya/ubah', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('profil-saya/ubah-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/dashboard/berita', [DashboardPostController::class, 'index'])->name('dashboard.posts.index');
    Route::get('/dashboard/berita/tambah', [DashboardPostController::class, 'create'])->name('dashboard.posts.create');
    Route::post('/dashboard/berita/tambah', [DashboardPostController::class, 'store'])->name('dashboard.posts.store');
    Route::get('/dashboard/berita/{slug}', [DashboardPostController::class, 'show'])->name('dashboard.posts.show');
    Route::get('/dashboard/berita/{slug}/ubah', [DashboardPostController::class, 'edit'])->name('dashboard.posts.edit');
    Route::put('/dashboard/berita/{slug}/ubah', [DashboardPostController::class, 'update'])->name('dashboard.posts.update');
    Route::delete('/dashboard/berita/{slug}/hapus', [DashboardPostController::class, 'destroy'])->name('dashboard.posts.destroy');
});
