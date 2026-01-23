<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        return $this->hasOne(Hr::class, 'user_id', 'id');
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
     * Renamed to 'trainee' to match Controller calls: $user->trainee
     */
    public function trainee(): HasOne
    {
        return $this->hasOne(Trainee::class, 'user_id', 'id');
    }

    /**
     * For Supervisors: Get assigned trainees
     */
    public function subordinates(): HasMany
    {
        // A supervisor (User) can have many trainees via supervisor_id in trainees table
        return $this->hasMany(Trainee::class, 'supervisor_id');
    }

    // Role Checks
    public function isHR(): bool { return $this->role === 'hr'; }
    public function isSupervisor(): bool { return $this->role === 'supervisor'; }
    public function isTrainee(): bool { return $this->role === 'trainee'; }
    public function isAdmin(): bool { return $this->role === 'admin'; }
}