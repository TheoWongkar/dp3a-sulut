<?php

namespace Database\Seeders;

use App\Models\Post;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Report;
use App\Models\Status;
use App\Models\Victim;
use App\Models\Suspect;
use App\Models\Employee;
use App\Models\Reporter;
use App\Models\PostCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin pertama
        $adminUser = User::factory()->create([
            'name' => 'Admin Sistem',
            'email' => 'admin@dp3asulut.com',
            'role' => 'Admin',
            'password' => Hash::make('password'),
        ]);

        Employee::factory()->create([
            'user_id' => $adminUser->id,
            'name' => 'Admin DP3A',
            'gender' => 'Laki-laki',
            'position' => 'Administrator',
            'date_of_birth' => '2003-08-19',
            'place_of_birth' => 'Sleman',
            'address' => 'Kali Selatan',
            'phone' => '082158889973',
            'status' => 'Aktif',
        ]);

        // 2. Petugas lainnya
        User::factory(9)->create()->each(function ($user) {
            Employee::factory()->create(['user_id' => $user->id]);
        });

        // 3. Post categories
        PostCategory::factory(5)->create();

        // 4. Posts
        Post::factory(15)->create();

        // 5. Reports
        Report::factory(10)->create();

        // 6. Victim, Suspect, Reporter (1:1)
        Report::all()->each(function ($report) {
            Victim::factory()->create(['report_id' => $report->id]);
            Suspect::factory()->create(['report_id' => $report->id]);
            Reporter::factory()->create(['report_id' => $report->id]);
        });

        // 7. Status log (2 per laporan)
        Report::all()->each(function ($report) {
            $statusFlow = ['Diterima', 'Menunggu Verifikasi', 'Diproses'];
            $finalStatuses = ['Selesai', 'Dibatalkan'];

            // Pilih berapa tahap yang ingin kita simulasikan (1 sampai 4)
            $stepCount = rand(1, 4);

            // Ambil status sesuai urutan langkah
            $statuses = array_slice($statusFlow, 0, min($stepCount, 3));

            // Jika langkah ke-4, tambahkan status akhir
            if ($stepCount === 4) {
                $statuses[] = $finalStatuses[array_rand($finalStatuses)];
            }

            foreach ($statuses as $status) {
                Status::factory()->create([
                    'report_id' => $report->id,
                    'status' => $status,
                    'changed_by' => User::inRandomOrder()->first()->id,
                ]);
            }
        });
    }
}
