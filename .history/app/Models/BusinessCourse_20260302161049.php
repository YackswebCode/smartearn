<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BusinessCourse extends Model
{
    protected $fillable = [
        'faculty_id', 'title', 'slug', 'description', 'detailed_explanation',
        'instructors', 'rating', 'reviews_count', 'price', 'currency',
        'image', 'is_diploma', 'duration_months', 'order'
    ];

    protected $casts = [
        'rating' => 'decimal:2',
        'price' => 'decimal:2',
    ];

    public function faculty()
    {
        return $this->belongsTo(BusinessFaculty::class, 'faculty_id');
    }

    public function lectures()
    {
        return $this->hasMany(BusinessLecture::class)->orderBy('order');
    }

    public function enrollments()
    {
        return $this->hasMany(BusinessEnrollment::class);
    }

    protected static function booted()
    {
        static::creating(function ($course) {
            if (empty($course->slug)) {
                $course->slug = Str::slug($course->title);
            }
        });
    }
}