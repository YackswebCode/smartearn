<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DigitalFaculty extends Model
{
    use HasFactory;

    protected $table = 'digital_faculties';

    protected $fillable = [
        'name',
        'icon',      // FontAwesome class, e.g. 'fa-laptop-code'
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order'     => 'integer',
    ];

    // A faculty has many tracks
    public function tracks()
    {
        return $this->hasMany(DigitalTrack::class, 'faculty_id');
    }
}