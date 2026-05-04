<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DigitalTrack extends Model
{
    use HasFactory;

    protected $table = 'digital_tracks';

    protected $fillable = [
        'faculty_id',
        'title',
        'slug',
        'description',
        'instructors',
        'image',
        'rating',
        'reviews_count',
        'duration_months',
        'price',              // base price (monthly if not overridden)
        'monthly_price',      // nullable
        'quarterly_price',    // nullable
        'one_time_price',     // nullable
        'currency',           // e.g., NGN, USD, etc.
        'order',
        'is_active',
    ];

    protected $casts = [
        'rating'         => 'float',
        'reviews_count'  => 'integer',
        'duration_months'=> 'integer',
        'price'          => 'float',
        'monthly_price'  => 'float',
        'quarterly_price'=> 'float',
        'one_time_price' => 'float',
        'order'          => 'integer',
        'is_active'      => 'boolean',
    ];

    // Inverse relationship
    public function faculty()
    {
        return $this->belongsTo(DigitalFaculty::class, 'faculty_id');
    }

    // A track has many lectures (optional – you may keep this separate)
    public function lectures()
    {
        return $this->hasMany(DigitalLecture::class, 'track_id');
    }

    // A track has many enrollments
    public function enrollments()
    {
        return $this->hasMany(DigitalEnrollment::class, 'track_id');
    }
}