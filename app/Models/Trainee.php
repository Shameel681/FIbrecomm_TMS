<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Trainee extends Model
{
    protected $fillable = [
        'user_id',
        'supervisor_id', 
        'name', // Keep this if you actually store name in the trainees table
        'email', 
        'start_date', 
        'end_date', 
        'status'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function applicationDetails(): HasOne
    {
        return $this->hasOne(TraineeForm::class, 'email', 'email');
    }

    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function monthlySubmissions(): HasMany
    {
        return $this->hasMany(MonthlySubmission::class);
    }
}