<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Report;
use App\Models\Status;
use App\Models\Victim;
use App\Models\Suspect;
use App\Models\Reporter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function sendMessage(Request $request)
    {
        // Validasi Input
        $validated = $request->validate([
            'message' => 'required|string|max:1000|regex:/^[a-zA-Z0-9\s?!.,]+$/',
        ]);

        // Respon Pengguna
        $sessionId = $request->cookie('chatbot_session_id');
        $userMessage = strip_tags($validated['message']);

        $chatbotUrl = env('CHATBOT_URL');

        try {
            // Kirim pesan ke chatbot dengan session_id
            $response = Http::timeout(10)->retry(3, 200)->post($chatbotUrl, [
                'session_id' => $sessionId,
                'message' => $userMessage,
            ]);

            $botResponse = $response->json();
            $botMessage = $botResponse['response'] ?? 'Maaf, saya tidak mengerti.';
            $newSessionId = $botResponse['session_id'] ?? $sessionId;

            return response()->json([
                'bot_message' => $botMessage,
            ])->cookie('chatbot_session_id', $newSessionId, 1440);
        } catch (Exception $e) {
            return response()->json([
                'bot_message' => 'Maaf, terjadi kesalahan saat menghubungi chatbot.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function storeFromChatbot(Request $request)
    {
        try {
            // Validasi Input
            $validated = $request->validate([
                'violence_category' => 'required|string|max:255',
                'date' => 'required|date',
                'regency' => 'required|string',
                'district' => 'required|string',
                'scene' => 'required|string|min:3|max:255',
                'evidence' => 'nullable|image|mimes:jpg,jpeg,png|max:3072',

                'victim_name' => 'required|string|min:3|max:255',
                'victim_phone' => 'required|numeric|digits_between:10,13',
                'victim_gender' => 'required|string|in:Pria,Wanita',
                'victim_description' => 'nullable|string|max:255',

                'suspect_name' => 'nullable|string|min:3|max:255',
                'suspect_gender' => 'required|string|in:Pria,Wanita',
                'suspect_description' => 'nullable|string|max:255',

                'reporter_name' => 'required|string|min:3|max:255',
                'reporter_phone' => 'required|numeric|digits_between:10,13',
                'reporter_gender' => 'required|string|in:Pria,Wanita',
                'reporter_relationship_between' => 'required|string|in:Orang Tua,Saudara,Guru,Teman,Lainnya',
            ]);

            // Cek Laporan Serupa
            $existingReport = Report::where('violence_category', $validated['violence_category'])
                ->where('date', $validated['date'])
                ->where('scene', $validated['scene'])
                ->whereHas('victim', function ($query) use ($validated) {
                    $query->where('name', $validated['victim_name']);
                })
                ->first();

            if ($existingReport) {
                return response()->json([
                    'success' => false,
                    'message' => 'Laporan serupa sudah ada.',
                ], 409);
            }

            // Simpan Data Evidence
            if ($request->hasFile('evidence')) {
                $filePath = $request->file('evidence')->store('evidences', 'public');
                $validated['evidence'] = $filePath;
            } else {
                $validated['evidence'] = null;
            }

            // Simpan Data Laporan
            $ticket_number = Report::generateTicketNumber();
            $report = Report::create([
                'ticket_number' => $ticket_number,
                'violence_category' => $validated['violence_category'],
                'date' => $validated['date'],
                'regency' => $validated['regencyName'],
                'district' => $validated['districtName'],
                'scene' => $validated['scene'],
                'evidence' => $validated['evidence'],
            ]);

            // Simpan Data Korban
            Victim::create([
                'report_id' => $report->id,
                'name' => $validated['victim_name'],
                'phone' => $validated['victim_phone'],
                'gender' => $validated['victim_gender'],
                'description' => $validated['victim_description'] ?? null,
            ]);

            // Simpan Data Pelaku
            Suspect::create([
                'report_id' => $report->id,
                'name' => $validated['suspect_name'] ?? null,
                'gender' => $validated['suspect_gender'],
                'description' => $validated['suspect_description'] ?? null,
            ]);

            // Simpan Data Pelapor
            Reporter::create([
                'report_id' => $report->id,
                'name' => $validated['reporter_name'],
                'phone' => $validated['reporter_phone'],
                'gender' => $validated['reporter_gender'],
                'relationship_between' => $validated['reporter_relationship_between'],
            ]);

            // Simpan Data Status
            Status::create([
                'report_id' => $report->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Laporan berhasil dibuat.',
                'ticket_number' => $ticket_number,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan laporan.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
