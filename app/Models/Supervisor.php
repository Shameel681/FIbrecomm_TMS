<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Supervisor extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'department', 'position'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];
}