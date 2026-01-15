<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraineeForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'address',
        'institution',
        'major',
        'study_level',
        'grad_date',
        'duration',
        'start_date',
        'expected_end_date',
        'interest',
        'coursework_req',
        'cv_path',          
        'uni_letter_path',
        'is_read',
        'status', // <--- ADDED THIS LINE
    ];

    protected $casts = [
        'grad_date' => 'date',
        'start_date' => 'date:Y-m-d',
        'expected_end_date' => 'date:Y-m-d',
        'duration' => 'integer',
        'is_read' => 'boolean',
    ];
}