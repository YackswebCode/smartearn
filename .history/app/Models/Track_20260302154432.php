<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    protected $fillable = [
        'faculty_id', 'name', 'description', 'detailed_explanation',
        'price_monthly', 'price_quarterly', 'price_yearly', 'currency',
        'image', 'duration_months', 'is_diploma', 'order'
    ];

    protected $casts = [
        'price_monthly' => 'decimal:2',
        'price_quarterly' => 'decimal:2',
        'price_yearly' => 'decimal:2',
    ];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function lectures()
{
    return $this->hasMany(Lecture::class)->orderBy('order');
}
}