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
        'approved_by',
        'remarks',
        'trainee_remark'
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