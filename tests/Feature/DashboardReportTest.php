<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Report;
use App\Models\Status;
use App\Models\Employee;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardReportTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function test_can_access_report_index()
    {
        // Buat pengguna admin
        $user = User::factory()->create([
            'username' => 'AdminUser',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'Admin',
        ]);

        Employee::factory()->create([
            'user_id' => $user->id,
            'nip' => '123456789',
            'name' => 'Admin Name',
            'gender' => 'Pria',
            'position' => 'Administrator',
            'date_of_birth' => '1990-01-01',
            'address' => 'Jl. Contoh No. 123',
            'phone' => '08123456789',
        ]);

        // Login sebagai pengguna admin
        $this->actingAs($user);

        // Buat laporan dengan handled_id sesuai user
        $report = Report::factory()->create([
            'ticket_number' => Crypt::encrypt('Laporan123'),
            'violence_category' => Crypt::encrypt('Fisik'),
            'regency' => Crypt::encrypt('Manado'),
            'district' => Crypt::encrypt('Tuminting'),
            'handled_id' => $user->id,
        ]);

        // Tambahkan status ke laporan
        Status::factory()->create([
            'report_id' => $report->id,
            'status' => 'Diterima',
        ]);

        // Akses halaman laporan
        $response = $this->get(route('dashboard.reports.index', ['status' => 'diterima']));

        // Pastikan respons berhasil
        $response->assertStatus(200);
        $response->assertViewIs('dashboard.report.index');
        $response->assertViewHas('reports', function ($reports) use ($report) {
            return $reports->contains(function ($item) use ($report) {
                return Crypt::decrypt($item->ticket_number) === Crypt::decrypt($report->ticket_number);
            });
        });
    }
}
