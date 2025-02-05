<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Report;
use App\Models\Status;
use App\Models\Victim;
use App\Models\Reporter;
use App\Models\Perpetrator;
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
                'chronology' => 'required|string|max:1000',
                'date' => 'required|date',
                'scene' => 'required|string|max:255',
                'evidence' => 'nullable|image|mimes:jpg,jpeg,png|max:3072',

                'victim_name' => 'required|string|max:255',
                'victim_phone' => 'required|string|max:13',
                'victim_address' => 'required|string|max:255',
                'victim_age' => 'required|integer|min:0',
                'victim_gender' => 'required|string|in:Pria,Wanita',
                'victim_description' => 'nullable|string|max:255',

                'perpetrator_name' => 'nullable|string|max:255',
                'perpetrator_age' => 'nullable|integer|min:0',
                'perpetrator_gender' => 'required|string|in:Pria,Wanita',
                'perpetrator_description' => 'nullable|string|max:255',

                'reporter_name' => 'nullable|string|max:255',
                'reporter_phone' => 'nullable|string|max:13',
                'reporter_address' => 'nullable|string|max:255',
                'reporter_relationship_between' => 'required|string|max:255',
            ]);

            // Cek Laporan Serupa
            $existingReport = Report::where('chronology', $validated['chronology'])
                ->where('date', $validated['date'])
                ->where('scene', $validated['scene'])
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
                'chronology' => $validated['chronology'],
                'date' => $validated['date'],
                'scene' => $validated['scene'],
                'evidence' => $validated['evidence'],
            ]);

            // Simpan Data Korban
            Victim::create([
                'report_id' => $report->id,
                'name' => $validated['victim_name'],
                'phone' => $validated['victim_phone'],
                'address' => $validated['victim_address'],
                'age' => $validated['victim_age'],
                'gender' => $validated['victim_gender'],
                'description' => $validated['victim_description'] ?? null,
            ]);

            // Simpan Data Pelaku
            Perpetrator::create([
                'report_id' => $report->id,
                'name' => $validated['perpetrator_name'] ?? null,
                'age' => $validated['perpetrator_age'] ?? null,
                'gender' => $validated['perpetrator_gender'],
                'description' => $validated['perpetrator_description'] ?? null,
            ]);

            // Simpan Data Pelapor
            Reporter::create([
                'report_id' => $report->id,
                'name' => $validated['reporter_name'] ?? null,
                'phone' => $validated['reporter_phone'] ?? null,
                'address' => $validated['reporter_address'] ?? null,
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
