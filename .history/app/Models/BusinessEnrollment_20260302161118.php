<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessEnrollment extends Model
{
    protected $fillable = [
        'user_id', 'course_id', 'plan', 'amount_paid', 'currency',
        'status', 'start_date', 'end_date'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(BusinessCourse::class);
    }
}