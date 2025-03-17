<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Post;
use App\Models\User;
use App\Models\Report;
use App\Models\Status;
use App\Models\Victim;
use App\Models\Employee;
use App\Models\Reporter;
use App\Models\Perpetrator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat User dan Karyawan
        $users = User::factory(10)
            ->has(Employee::factory())
            ->create();

        // Ambil data user pertama (index 0) dan update
        $firstUser = $users->first();
        $firstUser->update([
            'username' => 'Theoterra',
            'email' => 'theoterra19@dp3asulut.com',
            'password' => Hash::make('password'),
            'role' => 'Admin',
        ]);

        // Ambil data karyawan pertama (index 0) dan update
        $firstUser->employee()->update([
            'nip' => '210211060067',
            'name' => 'Theoterra Wongkar',
            'gender' => 'Pria',
            'position' => 'Mahasiswa',
            'date_of_birth' => '2003-08-19',
            'address' => 'Wusa, Jaga V',
            'phone' => '082158889973',
            'avatar' => null,
            'status' => 'Aktif',
        ]);

        // Buat Berita
        Post::factory(20)->create();

        // Buat Laporan beserta table anaknya
        Report::factory(20)->create()->each(function ($report) {
            Victim::factory()->create([
                'report_id' => $report->id,
            ]);
            Perpetrator::factory()->create([
                'report_id' => $report->id,
            ]);
            Reporter::factory()->create([
                'report_id' => $report->id,
            ]);
            Status::factory()->create([
                'report_id' => $report->id,
            ]);
        });
    }
}
