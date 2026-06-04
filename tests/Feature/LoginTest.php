<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test login validasi email dan password harus ada.
     */
    public function test_login_validation_requires_email_and_password(): void
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => '',
        ]);

        $response->assertSessionHasErrors(['email', 'password']);
    }

    /**
     * Test login validasi format email harus benar.
     */
    public function test_login_validation_requires_valid_email(): void
    {
        $response = $this->post('/login', [
            'email' => 'invalid-email-format',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /**
     * Test login berhasil dengan email dan password yang benar.
     */
    public function test_login_success_with_correct_credentials(): void
    {
        // 1. Create user
        $user = User::create([
            'name' => 'Test Student',
            'email' => 'student@example.com',
            'password' => Hash::make('secret123'),
            'role' => 'student',
        ]);

        // 2. Submit
        $response = $this->post('/login', [
            'email' => 'student@example.com',
            'password' => 'secret123',
        ]);

        // 3. redirection dan authentication status
        $response->assertRedirect('/dashboard');
        $this->assertTrue(Auth::check());
        $this->assertEquals($user->id, Auth::id());
    }

    /**
     * Test login gagal dengan email atau password salah.
     */
    public function test_login_fails_with_incorrect_credentials(): void
    {
        // 1. Create user
        User::create([
            'name' => 'Test Student',
            'email' => 'student@example.com',
            'password' => Hash::make('secret123'),
            'role' => 'student',
        ]);

        // 2. Submit password salah
        $response = $this->post('/login', [
            'email' => 'student@example.com',
            'password' => 'wrongpassword',
        ]);

        // 3. redirection dan session errors
        $response->assertRedirect();
        $this->assertFalse(Auth::check());
        $response->assertSessionHasErrors([
            'email' => 'Email atau Password kamu salah, silahkan periksa kembali'
        ]);
    }

    /**
     * Test logout mengarah ke halaman welcome page
     */
    public function test_logout_clears_session_and_authenticates_out(): void
    {
        // 1. Create dan login user
        $user = User::create([
            'name' => 'Test Student',
            'email' => 'student@example.com',
            'password' => Hash::make('secret123'),
            'role' => 'student',
        ]);
        $this->actingAs($user);

        // 2. Submit logout
        $response = $this->post('/logout');

        // 3. redirection dan session is cleared
        $response->assertRedirect('/');
        $this->assertFalse(Auth::check());
    }
}
