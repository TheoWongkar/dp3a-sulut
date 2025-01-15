<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Perpetrator;
use App\Models\Post;
use App\Models\Report;
use App\Models\Reporter;
use App\Models\Status;
use App\Models\User;
use App\Models\Victim;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Employee::factory(5)->create()->each(function ($employee, $index) {
            $userData = [
                'employee_id' => $employee->id,
                'name' => $employee->name,
            ];

            if ($index === 0) {
                $userData['name'] = 'Admin';
                $userData['email'] = 'admin@example.com';
                $userData['role'] = 'Super Admin';
            }

            User::factory()->create($userData);
        });

        Post::factory(10)->create();

        Report::factory(5)->create()->each(function ($report) {
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
