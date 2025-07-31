<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Str;
use App\Models\PostCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
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

        // 2. Post categories
        $categories = [
            'Kekerasan',
            'Kegiatan DP3A',
            'Hukum & Kebijakan',
            'Pendidikan Publik',
            'Berita Daerah',
            'Prestasi & Apresiasi',
        ];

        foreach ($categories as $name) {
            PostCategory::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => fake()->sentence(),
            ]);
        }
    }
}
