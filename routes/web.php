<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\EmployeeController as DashboardEmployeeController;
use App\Http\Controllers\Dashboard\PostCategoryController as DashboardPostCategoryController;
use App\Http\Controllers\Dashboard\PostController as DashboardPostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Berita
Route::get('/berita', [PostController::class, 'index'])->name('post.index');
Route::get('/berita/{slug}', [PostController::class, 'show'])->name('post.show');

// Laporan
Route::get('/cek-status-laporan', [ReportController::class, 'checkStatus'])->name('report.check-status');
Route::get('/buat-laporan', [ReportController::class, 'create'])->name('report.create');
Route::post('/buat-laporan', [ReportController::class, 'store'])->middleware('throttle:5,5')->name('report.store');

Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->middleware('throttle:5,5')->name('authenticate');
});

Route::middleware(['auth', 'active_user'])->group(function () {
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->middleware('throttle:5,5')->name('logout');

    // Profile
    Route::get('/profil-saya', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil-saya/ubah', [ProfileController::class, 'update'])->middleware('throttle:5,5')->name('profile.update');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Dashboard Pegawai
    Route::get('/dashboard/pegawai', [DashboardEmployeeController::class, 'index'])->name('dashboard.employee.index');
    Route::get('/dashboard/pegawai/tambah', [DashboardEmployeeController::class, 'create'])->name('dashboard.employee.create');
    Route::post('/dashboard/pegawai/tambah', [DashboardEmployeeController::class, 'store'])->middleware('throttle:10,5')->name('dashboard.employee.store');
    Route::get('/dashboard/pegawai/{nip}/ubah', [DashboardEmployeeController::class, 'edit'])->name('dashboard.employee.edit');
    Route::put('/dashboard/pegawai/{nip}/ubah', [DashboardEmployeeController::class, 'update'])->middleware('throttle:10,5')->name('dashboard.employee.update');
    Route::delete('/dashboard/pegawai/{nip}/hapus', [DashboardEmployeeController::class, 'destroy'])->middleware('throttle:10,5')->name('dashboard.employee.destroy');

    // Dashboard Berita
    Route::get('/dashboard/berita', [DashboardPostController::class, 'index'])->name('dashboard.post.index');
    Route::get('/dashboard/berita/tambah', [DashboardPostController::class, 'create'])->name('dashboard.post.create');
    Route::post('/dashboard/berita/tambah', [DashboardPostController::class, 'store'])->middleware('throttle:10,5')->name('dashboard.post.store');
    Route::get('/dashboard/berita/{slug}/ubah', [DashboardPostController::class, 'edit'])->name('dashboard.post.edit');
    Route::put('/dashboard/berita/{slug}/ubah', [DashboardPostController::class, 'update'])->middleware('throttle:10,5')->name('dashboard.post.update');
    Route::delete('/dashboard/berita/{slug}/hapus', [DashboardPostController::class, 'destroy'])->middleware('throttle:10,5')->name('dashboard.post.destroy');

    // Dashboard Kategori Berita
    Route::get('/dashboard/kategori-berita', [DashboardPostCategoryController::class, 'index'])->name('dashboard.post-category.index');
    Route::post('/dashboard/kategori-berita/tambah', [DashboardPostCategoryController::class, 'store'])->middleware('throttle:10,5')->name('dashboard.post-category.store');
    Route::put('/dashboard/kategori-berita/{slug}/ubah', [DashboardPostCategoryController::class, 'update'])->middleware('throttle:10,5')->name('dashboard.post-category.update');
    Route::delete('/dashboard/kategori-berita/{slug}/hapus', [DashboardPostCategoryController::class, 'destroy'])->middleware('throttle:10,5')->name('dashboard.post-category.destroy');
});
