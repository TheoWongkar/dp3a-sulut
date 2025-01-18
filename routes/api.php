<?php

use App\Http\Controllers\Api\ChatbotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/chatbot', [ChatbotController::class, 'sendMessage'])->middleware('throttle:30,1')->name('chatbot.send');
Route::post('/chatbot/report', [ChatbotController::class, 'storeFromChatbot'])->middleware('throttle:10,1')->name('chatbot.reports.store');
