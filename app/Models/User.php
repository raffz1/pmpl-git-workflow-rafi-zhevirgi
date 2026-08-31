<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'username', 'email', 'password', 'role', 'active_path_id', 'frontend_current_step', 'backend_current_step', 'uiux_current_step', 'fullstack_current_step', 'pm_current_step', 'profile_photo', 'cover_photo', 'custom_paths_progress', 'last_seen_update', 'marked_modules'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Check if user has admin role.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'active_path_id' => 'integer',
            'frontend_current_step' => 'integer',
            'backend_current_step' => 'integer',
            'uiux_current_step' => 'integer',
            'fullstack_current_step' => 'integer',
            'pm_current_step' => 'integer',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'custom_paths_progress' => 'array',
            'marked_modules' => 'array',
        ];
    }
}
