<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; // Changed from Authenticatable since User model handles Auth
use Illuminate\Notifications\Notifiable;

class HR extends Model
{
    use Notifiable;

    protected $table = 'hrs';

    protected $fillable = [
        'user_id',
        'employee_id',
        'name',
        'email',
        'password', // Added to allow dummy values for DB satisfaction
    ];

    protected $hidden = [
        'password', 
        'remember_token',
    ];

    // Link back to the main User account
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}