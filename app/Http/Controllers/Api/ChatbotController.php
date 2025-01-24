<?php

namespace App\Http\Controllers\Api;

use App\Models\Report;
use App\Models\Status;
use App\Models\Victim;
use App\Models\Reporter;
use App\Models\Perpetrator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
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
        $validated = $request->validate([
            'message' => 'required|string|max:100|regex:/^[a-zA-Z0-9\s?!.,]+$/',
        ]);

        // Ambil Pesan Dari Pengguna
        $sender = session()->getId();
        $userMessage = strip_tags($validated['message']);

        // URL Rasa
        $rasaUrl = env('RASA_URL');

        // Kirim pesan ke Rasa menggunakan HTTP facade
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('RASA_API_TOKEN'),
            ])->timeout(10)->post($rasaUrl, [
                'sender' => $sender,
                'message' => $userMessage,
            ]);

            // Ambil respons sebagai array
            $botMessages = $response->json();
            $botResponse = $botMessages ? collect($botMessages)->pluck('text')->join(' ') : 'Maaf, tidak ada respons dari chatbot.';

            // Kembalikan respons ke klien
            return response()->json([
                'user_message' => $userMessage,
                'bot_response' => $botResponse ?: 'Maaf, saya tidak mengerti.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat menghubungi chatbot.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    public function storeFromChatbot(Request $request)
    {
        try {
            // Validasi Input
            $validated = $request->validate([
                'violence_category' => 'required|string|max:255',
                'description' => 'required|string|max:1000|strip_tags',
                'date' => 'required|date',
                'scene' => 'required|string|max:500',
                'evidence' => 'nullable|file|mimes:jpg,png,jpeg|max:1024',

                'victim_name' => 'required|string|max:255',
                'victim_age' => 'required|integer|min:0',
                'victim_gender' => ['required', Rule::in(['Pria', 'Wanita'])],
                'victim_description' => 'nullable|string|max:1000',

                'perpetrator_name' => 'nullable|string|max:255',
                'perpetrator_age' => 'nullable|integer|min:0',
                'relationship_between' => 'nullable|string|max:255',
                'perpetrator_description' => 'nullable|string|max:1000',

                'reporter_whatsapp' => 'nullable|string|max:15',
                'reporter_telegram' => 'nullable|string|max:15',
                'reporter_instagram' => 'nullable|string|max:50',
                'reporter_email' => 'nullable|email|max:255',
            ]);

            // Cek Laporan Serupa
            $existingReport = Report::where('description', $validated['description'])
                ->where('date', $validated['date'])
                ->where('scene', $validated['scene'])
                ->first();

            if ($existingReport) {
                return response()->json([
                    'success' => false,
                    'message' => 'Laporan serupa sudah ada.',
                ], 409);
            }

            // Simpan Data Evidence (jika ada)
            if ($request->hasFile('evidence')) {
                $filePath = $request->file('evidence')->store('evidences', 'public');
                $validated['evidence'] = $filePath;
            }

            // Simpan Data Laporan
            $ticket_number = Report::generateTicketNumber();
            $report = Report::create([
                'ticket_number' => $ticket_number,
                'violence_category' => $validated['violence_category'],
                'description' => $validated['description'],
                'date' => $validated['date'],
                'scene' => $validated['scene'],
                'evidence' => $validated['evidence'] ?? null,
            ]);

            // Simpan Data Korban
            Victim::create([
                'report_id' => $report->id,
                'name' => $validated['victim_name'],
                'age' => $validated['victim_age'],
                'gender' => $validated['victim_gender'],
                'description' => $validated['victim_description'] ?? null,
            ]);

            // Simpan Data Pelaku (jika ada)
            if ($request->has('perpetrator_name') || $request->has('perpetrator_age') || $request->has('relationship_between') || $request->has('perpetrator_description')) {
                Perpetrator::create([
                    'report_id' => $report->id,
                    'name' => $validated['perpetrator_name'] ?? null,
                    'age' => $validated['perpetrator_age'] ?? null,
                    'relationship_between' => $validated['relationship_between'] ?? null,
                    'description' => $validated['perpetrator_description'] ?? null,
                ]);
            }

            // Simpan Data Pelapor (jika ada)
            if ($request->has('reporter_whatsapp') || $request->has('reporter_telegram') || $request->has('reporter_instagram') || $request->has('reporter_email')) {
                Reporter::create([
                    'report_id' => $report->id,
                    'whatsapp' => $validated['reporter_whatsapp'] ? encrypt($validated['reporter_whatsapp']) : null,
                    'telegram' => $validated['reporter_telegram'] ? encrypt($validated['reporter_telegram']) : null,
                    'instagram' => $validated['reporter_instagram'] ? encrypt($validated['reporter_instagram']) : null,
                    'email' => $validated['reporter_email'] ? encrypt($validated['reporter_email']) : null,
                ]);
            }

            // Simpan Data Status
            Status::create([
                'report_id' => $report->id,
            ]);

            // Logging laporan baru
            Log::info('Laporan baru dibuat', ['ticket_number' => $ticket_number]);

            return response()->json([
                'success' => true,
                'message' => 'Laporan berhasil dibuat.',
                'ticket_number' => $ticket_number,
            ], 201);
        } catch (\Exception $e) {
            // Tangkap semua error tak terduga
            Log::error('Terjadi kesalahan saat menyimpan laporan', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan laporan.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
