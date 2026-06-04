<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Path;
use App\Models\Module;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SequentialUnlockTest extends TestCase
{
    use RefreshDatabase;

    private Path $path;
    private Module $module0;
    private Module $module1;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Create dummy learning path (Frontend)
        $this->path = Path::create([
            'id' => 1,
            'title' => 'Frontend Development',
            'slug' => 'frontend',
            'icon' => 'frontend',
            'image' => 'https://example.com/frontend.png',
            'description' => 'Learn HTML, CSS, JS',
            'theme' => 'cyan',
            'salary_range' => 'Rp 5M - 10M',
            'skills' => ['HTML', 'CSS', 'JS'],
            'suitability' => ['Pemula'],
            'career_description' => 'Frontend Developer',
        ]);

        // 2. Create module
        $this->module0 = Module::create([
            'path_id' => $this->path->id,
            'step_number' => 0,
            'title' => 'Modul 1: HTML Dasar',
            'desc' => 'Materi HTML Dasar',
            'side' => 'left',
            'icon' => '01',
            'content_title' => 'Pengenalan HTML',
            'content_body' => '<p>HTML adalah...</p>',
        ]);

        $this->module1 = Module::create([
            'path_id' => $this->path->id,
            'step_number' => 1,
            'title' => 'Modul 2: CSS Dasar',
            'desc' => 'Materi CSS Dasar',
            'side' => 'right',
            'icon' => '02',
            'content_title' => 'Pengenalan CSS',
            'content_body' => '<p>CSS adalah...</p>',
        ]);
    }

    /**
     * Test guest bisa akses explore page tapi redirect saat di path detail.
     */
    public function test_guest_can_access_explore_but_redirected_on_detail(): void
    {
        $response = $this->get('/explore');
        $response->assertStatus(200);

        $response = $this->get('/path/detail/frontend');
        $response->assertRedirect('/login');
    }

    /**
     * Test student mengakses path detail page melihat langkahnya saat ini
     */
    public function test_student_accesses_path_detail_and_sees_current_step(): void
    {
        $student = User::create([
            'name' => 'Test Student',
            'email' => 'student@example.com',
            'password' => bcrypt('secret123'),
            'role' => 'student',
            'frontend_current_step' => 0,
        ]);

        $response = $this->actingAs($student)->get('/path/detail/frontend');

        $response->assertStatus(200);
        $response->assertViewHas('currentStep', 0);
    }

    /**
     * Test complete step progress (Sequential Unlock).
     */
    public function test_student_can_complete_step_via_post_and_increments_step(): void
    {
        $student = User::create([
            'name' => 'Test Student',
            'email' => 'student@example.com',
            'password' => bcrypt('secret123'),
            'role' => 'student',
            'frontend_current_step' => 0,
        ]);

        // Complete module pertama
        $response = $this->actingAs($student)->post('/path/detail/frontend/complete');

        // Redirect back atau ke detail path dengan sukses
        $response->assertRedirect(route('path.detail.frontend'));
        
        // Assert current step incremented ke 1 di database
        $student->refresh();
        $this->assertEquals(1, $student->frontend_current_step);
    }

    /**
     * Test student tidak bisa increment progress melebihi jumlah modul.
     */
    public function test_student_cannot_increment_beyond_total_modules(): void
    {
        $student = User::create([
            'name' => 'Test Student',
            'email' => 'student@example.com',
            'password' => bcrypt('secret123'),
            'role' => 'student',
            'frontend_current_step' => 2
        ]);

        // complete step ketika progress sudah di index tertinggi
        $response = $this->actingAs($student)->post('/path/detail/frontend/complete');

        $student->refresh();
        $this->assertEquals(2, $student->frontend_current_step);
    }

    /**
     * Test admin bypasses mekanik terkucni
     */
    public function test_admin_bypasses_locking_mechanic(): void
    {
        $admin = User::create([
            'name' => 'Test Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('secret123'),
            'role' => 'admin',
            'frontend_current_step' => 0,
        ]);

        $response = $this->actingAs($admin)->get('/path/detail/frontend');

        $response->assertStatus(200);
        // Admin mendapatkan step value dari total modules count (terbuka semua)
        $response->assertViewHas('currentStep', 2);
    }

    /**
     * Test reset progress reset step ke nol.
     */
    public function test_reset_progress_resets_step_to_zero(): void
    {
        $student = User::create([
            'name' => 'Test Student',
            'email' => 'student@example.com',
            'password' => bcrypt('secret123'),
            'role' => 'student',
            'frontend_current_step' => 1,
        ]);

        $response = $this->actingAs($student)->post('/path/detail/frontend/reset');

        $response->assertRedirect(route('path.detail.frontend'));
        
        $student->refresh();
        $this->assertEquals(0, $student->frontend_current_step);
    }
}
