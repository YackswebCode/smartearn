<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DigitalEnrollment extends Model
{
    use HasFactory;

    protected $table = 'digital_enrollments';

    protected $fillable = [
        'user_id',
        'track_id',
        'plan',            // 'monthly', 'quarterly', 'one_time'
        'amount_paid',
        'currency',
        'status',          // 'active', 'completed', 'cancelled'
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'amount_paid' => 'float',
        'start_date'  => 'datetime',
        'end_date'    => 'datetime',
    ];

    // Relationship to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship to track
    public function track()
    {
        return $this->belongsTo(DigitalTrack::class, 'track_id');
    }
}