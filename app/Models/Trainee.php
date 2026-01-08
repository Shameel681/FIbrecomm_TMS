<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Trainee extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'start_date', 'end_date', 'status'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    /**
     * Link to the application form data via email.
     * This allows us to call $trainee->applicationDetails
     */
    public function applicationDetails(): HasOne
    {
        // First 'email' is the column in TraineeForm, second 'email' is the column in Trainee
        return $this->hasOne(TraineeForm::class, 'email', 'email');
    }
}