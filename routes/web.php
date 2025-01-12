<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CheckStatusController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\PostController as DashboardPostController;
use App\Http\Controllers\Dashboard\ReportController as DashboardReportController;

Route::get('/', HomeController::class)->name('home');
Route::get('/berita', [PostController::class, 'index'])->name('posts.index');
Route::get('/berita/{slug}', [PostController::class, 'show'])->name('posts.show');
Route::get('/cek-status', CheckStatusController::class)->name('status');
Route::get('/laporkan', [ReportController::class, 'index'])->name('reports.index');
Route::post('/laporkan', [ReportController::class, 'store'])->name('reports.store');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
});

Route::middleware(['auth', 'auth.session'])->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/berita', [DashboardPostController::class, 'index'])->name('dashboard.posts.index');
    Route::get('/dashboard/berita/tambah', [DashboardPostController::class, 'create'])->name('dashboard.posts.create');
    Route::post('/dashboard/berita/tambah', [DashboardPostController::class, 'store'])->name('dashboard.posts.store');
    Route::get('/dashboard/berita/{slug}', [DashboardPostController::class, 'show'])->name('dashboard.posts.show');
    Route::get('/dashboard/berita/ubah/{slug}', [DashboardPostController::class, 'edit'])->name('dashboard.posts.edit');
    Route::put('/dashboard/berita/ubah/{slug}', [DashboardPostController::class, 'update'])->name('dashboard.posts.update');
    Route::delete('/dashboard/berita/hapus/{slug}', [DashboardPostController::class, 'destroy'])->name('dashboard.posts.destroy');

    Route::get('/dashboard/laporan', [DashboardReportController::class, 'index'])->name('dashboard.reports.index');
    Route::get('/dashboard/laporan/{ticket_number}', [DashboardReportController::class, 'show'])->name('dashboard.reports.show');
    Route::put('/dashboard/laporan/ubah/{ticket_number}', [DashboardReportController::class, 'update'])->name('dashboard.reports.update');
    Route::delete('/dashboard/laporan/hapus/{ticket_number}', [DashboardReportController::class, 'destroy'])->name('dashboard.reports.destroy');
});
