<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainee_id',
        'date',
        'clock_in',
        'status',
        'is_auto_approved',
        'approved_by',
        'remarks',
        'trainee_remark'
    ];

    protected $casts = [
        'is_auto_approved' => 'boolean',
    ];

    public function trainee()
    {
        return $this->belongsTo(Trainee::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}