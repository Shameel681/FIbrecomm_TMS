<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class HR extends Authenticatable
{
    use Notifiable;

    // Matches 'hrs' table
    protected $table = 'hrs';

    protected $fillable = [
        'name', 'email', 'password', 'employee_id'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];
}