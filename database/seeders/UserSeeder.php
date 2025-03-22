<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
                'avatar' => null,
                'status' => true,
                'user' => [
                    'username' => 'Theoterra',
                    'email' => 'theoterra19@dp3asulut.com',
                    'password' => Hash::make('theoterra19@dp3asulut'),
                    'role' => 'Admin',
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
                'avatar' => null,
                'status' => true,
                'user' => [
                    'username' => 'kepala_uptd',
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
                'avatar' => null,
                'status' => true,
                'user' => [
                    'username' => 'petugas',
                    'email' => 'petugas@dp3asulut.com',
                    'password' => Hash::make('petugas@dp3asulut'),
                    'role' => 'Petugas',
                ],
            ],
        ];

        // Proses memasukkan data ke database
        foreach ($employees as $employeeData) {
            // Simpan data user terlebih dahulu
            $user = User::create([
                'username' => $employeeData['user']['username'],
                'email' => $employeeData['user']['email'],
                'password' => $employeeData['user']['password'],
                'role' => $employeeData['user']['role'],
            ]);

            // Simpan data employee dengan user_id
            Employee::create([
                'user_id' => $user->id,
                'nip' => $employeeData['nip'],
                'name' => $employeeData['name'],
                'gender' => $employeeData['gender'],
                'position' => $employeeData['position'],
                'date_of_birth' => $employeeData['date_of_birth'],
                'address' => $employeeData['address'],
                'phone' => $employeeData['phone'],
                'avatar' => $employeeData['avatar'],
                'status' => $employeeData['status'],
            ]);
        }
    }
}
