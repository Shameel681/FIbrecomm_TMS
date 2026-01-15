<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; // Changed from Authenticatable
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Trainee extends Model // Standard Model
{
    protected $fillable = [
    'user_id', // Add this!
    'name', 
    'email', 
    'start_date', 
    'end_date', 
    'status'
    ];

    /**
     * Link back to the User account
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Link to the application form data via email.
     */
    public function applicationDetails(): HasOne
    {
        return $this->hasOne(TraineeForm::class, 'email', 'email');
    }
}