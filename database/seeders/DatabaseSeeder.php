<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Report;
use App\Models\Status;
use App\Models\Victim;
use App\Models\Employee;
use App\Models\Reporter;
use App\Models\Perpetrator;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Employee::factory(20)->create()->each(function ($employee, $index) {
            $userData = [
                'employee_id' => $employee->id,
                'name' => $employee->name,
            ];

            if ($index === 0) {
                $employee->update([
                    'nip' => '210211060067',
                    'name' => 'Theoterra Wongkar',
                    'gender' => 'Pria',
                    'position' => 'Developer',
                    'date_of_birth' => '2003-08-19',
                    'address' => 'Desa Kali Selatan, Kec. Pineleng, Kab. Minahasa',
                    'phone' => '082158889973',
                    'picture' => null,
                    'status' => true,
                ]);
            }

            if ($index === 0) {
                $userData['name'] = 'Theoterra';
                $userData['email'] = 'developer@dp3asulut.com';
                $userData['password'] = Hash::make('developer@dp3asulut');
                $userData['role'] = 'Developer';
            }

            User::factory()->create($userData);
        });

        Post::factory(20)->create();

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
