<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Report;
use App\Models\Status;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CheckStatusTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase; // Bersihkan database sebelum setiap test

    /** @test */
    public function test_user_can_check_status_with_valid_ticket_number()
    {
        $user = User::factory()->create(); // Buat user terlebih dahulu

        $report = Report::factory()->create(['handled_id' => $user->id]); // Pastikan ada handled_id yang valid

        $response = $this->get(route('status.index', ['search' => $report->ticket_number]));

        $response->assertStatus(200);
        $response->assertSee($report->ticket_number);
    }


    /** @test */
    public function test_user_cannot_check_status_with_invalid_ticket_number()
    {
        // Kirim request GET dengan tiket yang tidak ada
        $response = $this->get(route('status.index', ['search' => 'INVALID123']));

        // Pastikan halaman bisa diakses
        $response->assertStatus(200);
        $response->assertViewIs('check-status');

        // Pastikan laporan tidak ditemukan
        $response->assertDontSee('Laporan ditemukan');

        // Pastikan nomor tiket tidak muncul di halaman
        $response->assertDontSeeText('INVALID123');
    }

    /** @test */
    public function user_can_access_check_status_page_without_search()
    {
        // Kirim request GET tanpa parameter pencarian
        $response = $this->get(route('status.index'));

        // Pastikan halaman tetap bisa diakses
        $response->assertStatus(200);
        $response->assertViewIs('check-status');
        $response->assertSee('Cek Status');
    }
}
