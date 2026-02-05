<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MonthlySubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainee_id',
        'month',
        'year',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function trainee(): BelongsTo
    {
        return $this->belongsTo(Trainee::class);
    }
}
