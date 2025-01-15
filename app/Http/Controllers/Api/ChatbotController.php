<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function sendMessage(Request $request)
    {
        // Validasi Input
        $request->validate([
            'message' => 'required|string',
        ]);

        // Ambil Pesan Dari Pengguna
        $userMessage = $request->input('message');

        // URL Rasa
        $rasaUrl = 'http://localhost:5005/webhooks/rest/webhook';

        // Kirim pesan ke Rasa menggunakan HTTP facade
        try {
            $response = Http::post($rasaUrl, [
                'sender' => 'user',
                'message' => $userMessage,
            ]);

            // Ambil respons sebagai array
            $botMessages = $response->json();
            $botResponse = collect($botMessages)->pluck('text')->join(' ');

            // Kembalikan respons ke klien
            return response()->json([
                'user_message' => $userMessage,
                'bot_response' => $botResponse ?: 'Maaf, saya tidak mengerti.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat menghubungi chatbot.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
}
