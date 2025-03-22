<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ChatbotController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/chatbot', [ChatbotController::class, 'sendMessage'])->middleware('throttle:20,1')->name('chatbot.send');
Route::post('/chatbot/report', [ChatbotController::class, 'storeFromChatbot'])->middleware('throttle:5,1')->name('chatbot.reports.store');
