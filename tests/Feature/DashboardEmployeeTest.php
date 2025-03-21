<?php

namespace Tests\Feature;

use Mockery;
use Tests\TestCase;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardEmployeeTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function test_unauthorized_user_cannot_access_employee_index()
    {
        $response = $this->get(route('dashboard.employees.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_authorized_user_can_access_employee_index()
    {
        // Buat user dan employee dengan status Aktif
        $user = User::factory()->create();
        $employee = Employee::factory()->create([
            'user_id' => $user->id,
            'status' => 'Aktif', // Pastikan statusnya "Aktif"
        ]);

        Gate::define('crud-employee', function ($user) {
            return $user->role === 'Admin';
        });

        $this->actingAs($user);
        $response = $this->get(route('dashboard.employees.index'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.employee.index');
    }
}
