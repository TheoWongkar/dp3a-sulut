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
                'nip' => '999999999999999',
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
                    'password' => Hash::make('dp3asulut@developer190803'),
                    'role' => 'Developer',
                ],
            ],
            [
                'nip' => '989898989898989898',
                'name' => 'Marcel Siregar',
                'gender' => 'Pria',
                'position' => 'Kepala UPTD',
                'date_of_birth' => '1990-05-20',
                'address' => 'Jl. Melati No. 456',
                'phone' => '081298765432',
                'picture' => null,
                'status' => true,
                'user' => [
                    'email' => 'kepala_bagian@dp3asulut.com',
                    'password' => Hash::make('dp3asulut@admin0128'),
                    'role' => 'Admin',
                ],
            ],
            [
                'nip' => '525252525252525252',
                'name' => 'Alice Brown',
                'gender' => 'Wanita',
                'position' => 'Staff',
                'date_of_birth' => '1995-08-10',
                'address' => 'Jl. Anggrek No. 789',
                'phone' => '081345678901',
                'picture' => null,
                'status' => true,
                'user' => [
                    'email' => 'staff@dp3asulut.com',
                    'password' => Hash::make('dp3asulut@petugas0132'),
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
