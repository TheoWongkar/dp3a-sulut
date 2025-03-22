<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Report;
use App\Models\Victim;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReportTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function test_report_page_is_accessible()
    {
        $response = $this->get(route('reports.create'));
        $response->assertStatus(200);
        $response->assertViewIs('reports');
    }

    public function user_can_submit_valid_report()
    {
        // Data yang akan diuji
        $data = [
            'violence_category' => 'KDRT',
            'date' => '2025-03-22',
            'regency' => 7101, // ID bukan nama
            'district' => 710101,
            'scene' => 'Jalan Merdeka No.1',
            'evidence' => null,

            'victim_name' => 'John Doe',
            'victim_phone' => '081234567890',
            'victim_gender' => 'Pria',
            'victim_description' => 'Korban mengalami luka ringan',

            'suspect_name' => 'Jane Doe',
            'suspect_gender' => 'Wanita',
            'suspect_description' => 'Pelaku adalah teman dekat',

            'reporter_name' => 'James Doe',
            'reporter_phone' => '081298765432',
            'reporter_gender' => 'Pria',
            'reporter_relationship_between' => 'Teman',
        ];

        // Kirim request POST ke route laporan
        $response = $this->post(route('reports.store'), $data);

        // Harus sukses dan redirect
        $response->assertRedirect(route('reports.create'));
        $response->assertSessionHas('success');

        // Ambil laporan terbaru
        $report = Report::latest()->first();
        $this->assertNotNull($report);

        // Periksa apakah korban tersimpan dengan benar
        $victim = Victim::where('report_id', $report->id)->first();
        $this->assertNotNull($victim, 'Korban tidak ditemukan di database');
        $this->assertEquals('John Doe', $victim->name); // Pastikan namanya sesuai
    }

    public function test_report_submission_fails_with_invalid_data()
    {
        $response = $this->post(route('reports.store'), [
            'violence_category' => '',
            'date' => 'invalid-date',
            'regency' => '',
            'district' => '',
            'scene' => 'Jl',
            'evidence' => 'invalid-file',

            'victim_name' => '',
            'victim_phone' => 'abc',
            'victim_gender' => 'Unknown',
            'victim_description' => str_repeat('A', 300),

            'suspect_name' => '',
            'suspect_gender' => 'Unknown',
            'suspect_description' => str_repeat('B', 300),

            'reporter_name' => '',
            'reporter_phone' => '123',
            'reporter_gender' => 'Unknown',
            'reporter_relationship_between' => 'Tidak Valid',
        ]);

        $response->assertSessionHasErrors([
            'violence_category',
            'date',
            'regency',
            'district',
            'scene',
            'evidence',
            'victim_name',
            'victim_phone',
            'victim_gender',
            'victim_description',
            'suspect_gender',
            'suspect_description',
            'reporter_name',
            'reporter_phone',
            'reporter_gender',
            'reporter_relationship_between'
        ]);
    }

    public function test_report_submission_is_throttled()
    {
        for ($i = 0; $i < 5; $i++) {
            $response = $this->post(route('reports.store'), [
                'violence_category' => 'KDRT',
                'date' => now()->toDateString(),
                'regency' => 7101,
                'district' => 710101,
                'scene' => 'Jl. Ahmad Yani No. 10',
                'evidence' => UploadedFile::fake()->image('bukti.jpg'),

                'victim_name' => 'John Doe',
                'victim_phone' => '081234567890',
                'victim_gender' => 'Pria',
                'victim_description' => 'Korban mengalami luka ringan.',

                'suspect_name' => 'Jane Doe',
                'suspect_gender' => 'Wanita',
                'suspect_description' => 'Pelaku diduga seorang anggota keluarga.',

                'reporter_name' => 'James Doe',
                'reporter_phone' => '081298765432',
                'reporter_gender' => 'Pria',
                'reporter_relationship_between' => 'Orang Tua',
            ]);
        }

        $response = $this->post(route('reports.store'), [
            'violence_category' => 'KDRT',
            'date' => now()->toDateString(),
            'regency' => 7101,
            'district' => 710101,
            'scene' => 'Jl. Ahmad Yani No. 10',
            'evidence' => UploadedFile::fake()->image('bukti.jpg'),

            'victim_name' => 'John Doe',
            'victim_phone' => '081234567890',
            'victim_gender' => 'Pria',
            'victim_description' => 'Korban mengalami luka ringan.',

            'suspect_name' => 'Jane Doe',
            'suspect_gender' => 'Wanita',
            'suspect_description' => 'Pelaku diduga seorang anggota keluarga.',

            'reporter_name' => 'James Doe',
            'reporter_phone' => '081298765432',
            'reporter_gender' => 'Pria',
            'reporter_relationship_between' => 'Orang Tua',
        ]);

        $response->assertStatus(429);
    }
}
