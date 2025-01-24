<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\CheckStatusController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\PostController as DashboardPostController;
use App\Http\Controllers\Dashboard\ReportController as DashboardReportController;
use App\Http\Controllers\Dashboard\EmployeeController as DashboardEmployeeController;

Route::get('/', HomeController::class)->name('home');
Route::get('/berita', [PostController::class, 'index'])->name('posts.index');
Route::get('/berita/{slug}', [PostController::class, 'show'])->name('posts.show');
Route::get('/cek-status', CheckStatusController::class)->name('status.index');
Route::get('/laporkan', [ReportController::class, 'create'])->name('reports.create');
Route::post('/laporkan', [ReportController::class, 'store'])->name('reports.store');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
});

Route::middleware(['auth', 'auth.session'])->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile/ubah', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('profile/ubah-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::delete('profile/hapus', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/dashboard/berita', [DashboardPostController::class, 'index'])->name('dashboard.posts.index');
    Route::get('/dashboard/berita/tambah', [DashboardPostController::class, 'create'])->name('dashboard.posts.create');
    Route::post('/dashboard/berita/tambah', [DashboardPostController::class, 'store'])->name('dashboard.posts.store');
    Route::get('/dashboard/berita/{slug}', [DashboardPostController::class, 'show'])->name('dashboard.posts.show');
    Route::get('/dashboard/berita/ubah/{slug}', [DashboardPostController::class, 'edit'])->name('dashboard.posts.edit');
    Route::put('/dashboard/berita/ubah/{slug}', [DashboardPostController::class, 'update'])->name('dashboard.posts.update');
    Route::delete('/dashboard/berita/hapus/{slug}', [DashboardPostController::class, 'destroy'])->name('dashboard.posts.destroy');

    Route::get('/dashboard/karyawan', [DashboardEmployeeController::class, 'index'])->name('dashboard.employees.index');
    Route::get('/dashboard/karyawan/tambah', [DashboardEmployeeController::class, 'create'])->name('dashboard.employees.create');
    Route::post('/dashboard/karyawan/tambah', [DashboardEmployeeController::class, 'store'])->name('dashboard.employees.store');
    Route::get('/dashboard/karyawan/{nip}', [DashboardEmployeeController::class, 'show'])->name('dashboard.employees.show');
    Route::get('/dashboard/karyawan/ubah/{nip}', [DashboardEmployeeController::class, 'edit'])->name('dashboard.employees.edit');
    Route::put('/dashboard/karyawan/ubah/{nip}', [DashboardEmployeeController::class, 'update'])->name('dashboard.employees.update');
    Route::delete('/dashboard/karyawan/hapus/{nip}', [DashboardEmployeeController::class, 'destroy'])->name('dashboard.employees.destroy');

    Route::get('/dashboard/laporan/diterima', [DashboardReportController::class, 'received'])->name('dashboard.reports.received');
    Route::get('/dashboard/laporan/diterima/{ticket_number}', [DashboardReportController::class, 'receivedShow'])->name('dashboard.reports.received-show');
    Route::post('/dashboard/laporan/diterima/{ticket_number}', [DashboardReportController::class, 'receivedVerification'])->name('dashboard.reports.received-verification');

    Route::get('/dashboard/laporan/diproses', [DashboardReportController::class, 'processed'])->name('dashboard.reports.processed');
    Route::get('/dashboard/laporan/diproses/{ticket_number}', [DashboardReportController::class, 'processedShow'])->name('dashboard.reports.processed-show');
    Route::post('/dashboard/laporan/diproses/{ticket_number}', [DashboardReportController::class, 'processedUpdate'])->name('dashboard.reports.processed-update');

    Route::get('/dashboard/laporan/selesai', [DashboardReportController::class, 'completed'])->name('dashboard.reports.completed');
    Route::get('/dashboard/laporan/selesai/{ticket_number}', [DashboardReportController::class, 'completedShow'])->name('dashboard.reports.completed-show');

    Route::get('/dashboard/laporan/tambah', [DashboardReportController::class, 'create'])->name('dashboard.reports.create');
    Route::post('/dashboard/laporan/tambah', [DashboardReportController::class, 'store'])->name('dashboard.reports.store');
    Route::delete('/dashboard/laporan/{ticket_number}/hapus', [DashboardReportController::class, 'destroy'])->name('dashboard.reports.destroy');

    Route::get('/dashboard/laporan/{ticket_number}/print', [DashboardReportController::class, 'printPDF'])->name('dashboard.reports.print');
});
