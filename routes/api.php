<?php

use App\Http\Controllers\Api\ChatbotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/chatbot', [ChatbotController::class, 'sendMessage'])->name('chatbot.send');
