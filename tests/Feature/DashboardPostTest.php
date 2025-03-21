<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardPostTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    protected $admin;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat user dengan role Admin dan Petugas
        $this->admin = User::factory()->create(['role' => 'Admin']);
        $this->user = User::factory()->create(['role' => 'Petugas']);
        Employee::factory()->create(['user_id' => $this->user->id, 'status' => 'Aktif']);
    }

    /** @test */
    public function guest_cannot_access_dashboard_posts_page()
    {
        $response = $this->get(route('dashboard.posts.index'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_access_dashboard_posts_page()
    {
        $response = $this->actingAs($this->user)->get(route('dashboard.posts.index'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.post.index');
    }
}
