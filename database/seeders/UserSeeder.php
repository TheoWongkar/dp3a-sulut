<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = [
            [
                'nip' => '210211060067',
                'name' => 'Theoterra Wongkar',
                'gender' => 'Pria',
                'position' => 'Developer',
                'date_of_birth' => '2003-08-19',
                'address' => 'Desa Kali Selatan, Kec. Pineleng, Kab. Minahasa',
                'phone' => '082158889973',
                'picture' => null,
                'status' => true,
                'user' => [
                    'email' => 'theoterra@dp3asulut.com',
                    'password' => Hash::make('developer@dp3asulut'),
                    'role' => 'Developer',
                ],
            ],
            [
                'nip' => '111111111111111111',
                'name' => 'Marcel',
                'gender' => 'Pria',
                'position' => 'Kepala UPTD',
                'date_of_birth' => '2025-01-01',
                'address' => 'Jl. Melati No. 456',
                'phone' => '082100000000',
                'picture' => null,
                'status' => true,
                'user' => [
                    'email' => 'kepala_uptd@dp3asulut.com',
                    'password' => Hash::make('kepalauptd@dp3asulut'),
                    'role' => 'Admin',
                ],
            ],
            [
                'nip' => '222222222222222222',
                'name' => 'Maria',
                'gender' => 'Wanita',
                'position' => 'Petugas',
                'date_of_birth' => '2025-01-01',
                'address' => 'Jl. Anggrek No. 789',
                'phone' => '082100000000',
                'picture' => null,
                'status' => true,
                'user' => [
                    'email' => 'petugas@dp3asulut.com',
                    'password' => Hash::make('petugas@dp3asulut'),
                    'role' => 'Petugas',
                ],
            ],
        ];

        // Proses memasukkan data ke database
        foreach ($employees as $employeeData) {
            // Simpan data employee
            $employee = Employee::create([
                'nip' => $employeeData['nip'],
                'name' => $employeeData['name'],
                'gender' => $employeeData['gender'],
                'position' => $employeeData['position'],
                'date_of_birth' => $employeeData['date_of_birth'],
                'address' => $employeeData['address'],
                'phone' => $employeeData['phone'],
                'picture' => $employeeData['picture'],
                'status' => $employeeData['status'],
            ]);

            // Simpan data user yang terkait dengan employee
            User::create([
                'employee_id' => $employee->id,
                'name' => $employee->name,
                'email' => $employeeData['user']['email'],
                'password' => $employeeData['user']['password'],
                'role' => $employeeData['user']['role'],
            ]);
        }
    }
}
