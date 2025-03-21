<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CheckStatusController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\EmployeeController as DashboardEmployeeController;
use App\Http\Controllers\Dashboard\PostController as DashboardPostController;
use App\Http\Controllers\Dashboard\ReportController as DashboardReportController;

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

Route::middleware(['auth', 'employee.status.check'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('profil-saya', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('profil-saya/ubah', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profil-saya/ubah', [ProfileController::class, 'updateProfile'])->middleware('throttle:10,5')->name('profile.update');
    Route::put('profil-saya/ubah-password', [ProfileController::class, 'updatePassword'])->middleware('throttle:10,5')->name('profile.updatePassword');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/dashboard/berita', [DashboardPostController::class, 'index'])->name('dashboard.posts.index');
    Route::get('/dashboard/berita/tambah', [DashboardPostController::class, 'create'])->name('dashboard.posts.create');
    Route::post('/dashboard/berita/tambah', [DashboardPostController::class, 'store'])->middleware('throttle:10,5')->name('dashboard.posts.store');
    Route::get('/dashboard/berita/{slug}', [DashboardPostController::class, 'show'])->name('dashboard.posts.show');
    Route::get('/dashboard/berita/{slug}/ubah', [DashboardPostController::class, 'edit'])->name('dashboard.posts.edit');
    Route::put('/dashboard/berita/{slug}/ubah', [DashboardPostController::class, 'update'])->middleware('throttle:10,5')->name('dashboard.posts.update');
    Route::delete('/dashboard/berita/{slug}/hapus', [DashboardPostController::class, 'destroy'])->middleware('throttle:10,5')->name('dashboard.posts.destroy');

    Route::get('/dashboard/karyawan', [DashboardEmployeeController::class, 'index'])->name('dashboard.employees.index');
    Route::get('/dashboard/karyawan/tambah', [DashboardEmployeeController::class, 'create'])->name('dashboard.employees.create');
    Route::post('/dashboard/karyawan/tambah', [DashboardEmployeeController::class, 'store'])->middleware('throttle:10,5')->name('dashboard.employees.store');
    Route::get('/dashboard/karyawan/{nip}', [DashboardEmployeeController::class, 'show'])->name('dashboard.employees.show');
    Route::get('/dashboard/karyawan/{nip}/ubah', [DashboardEmployeeController::class, 'edit'])->name('dashboard.employees.edit');
    Route::put('/dashboard/karyawan/{nip}/ubah', [DashboardEmployeeController::class, 'update'])->middleware('throttle:10,5')->name('dashboard.employees.update');
    Route::delete('/dashboard/karyawan/{nip}/hapus', [DashboardEmployeeController::class, 'destroy'])->middleware('throttle:10,5')->name('dashboard.employees.destroy');

    Route::get('/dashboard/laporan/tambah', [DashboardReportController::class, 'create'])->name('dashboard.reports.create');
    Route::post('/dashboard/laporan/tambah', [DashboardReportController::class, 'store'])->name('dashboard.reports.store');
    Route::get('/dashboard/laporan/{ticket_number}/ubah', [DashboardReportController::class, 'edit'])->name('dashboard.reports.edit');
    Route::put('/dashboard/laporan/{ticket_number}/ubah', [DashboardReportController::class, 'update'])->name('dashboard.reports.update');

    Route::get('/dashboard/laporan/{status}', [DashboardReportController::class, 'index'])->name('dashboard.reports.index');
    Route::get('/dashboard/laporan/{status}/{ticket_number}/verifikasi', [DashboardReportController::class, 'receivedShow'])->name('dashboard.reports.received.show');
    Route::post('/dashboard/laporan/{status}/{ticket_number}/verifikasi', [DashboardReportController::class, 'receivedUpdate'])->name('dashboard.reports.received.update');

    Route::get('/dashboard/laporan/{status}/{ticket_number}/update-status', [DashboardReportController::class, 'processedShow'])->name('dashboard.reports.processed.show');
    Route::post('/dashboard/laporan/{status}/{ticket_number}/update-status', [DashboardReportController::class, 'processedUpdate'])->name('dashboard.reports.processed.update');

    Route::get('/dashboard/laporan/{status}/{ticket_number}/review', [DashboardReportController::class, 'completedShow'])->name('dashboard.reports.completed.show');
    Route::get('/dashboard/laporan/{status}/{ticket_number}/review/print', [DashboardReportController::class, 'printPDF'])->name('dashboard.reports.completed.print');
});
