<?php

use App\Http\Controllers\CheckStatusController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/berita', [PostController::class, 'index'])->name('posts.index');
Route::get('/berita/{slug}', [PostController::class, 'show'])->name('posts.show');
Route::get('/cek-status', [CheckStatusController::class, 'index'])->name('status.index');
Route::get('/laporkan', [ReportController::class, 'create'])->name('reports.create');
Route::post('/laporkan', [ReportController::class, 'store'])->middleware('throttle:5,5')->name('reports.store');
