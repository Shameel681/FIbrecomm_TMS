<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', 
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relationship with HR Profile
     */
    public function hrProfile(): HasOne
    {
        return $this->hasOne(HR::class, 'user_id', 'id');
    }

    /**
     * Relationship with Supervisor Profile
     */
    public function supervisorProfile(): HasOne
    {
        return $this->hasOne(Supervisor::class, 'user_id', 'id');
    }

    /**
     * Relationship with Trainee Profile
     */
    public function traineeProfile(): HasOne
    {
        return $this->hasOne(Trainee::class, 'user_id', 'id');
    }

    // --- Role Checks ---

    public function isHR() {
        return $this->role === 'hr';
    }

    public function isSupervisor() {
        return $this->role === 'supervisor';
    }

    public function isTrainee() {
        return $this->role === 'trainee';
    }

    public function isAdmin() {
        return $this->role === 'admin';
    }
}