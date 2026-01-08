<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraineeForm extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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
        'interest',
        'coursework_req',
        'cv_path',          
        'uni_letter_path',   
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'grad_date' => 'date',
        'start_date' => 'date',
        'duration' => 'integer',
    ];
}