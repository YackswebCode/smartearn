<?php
// app/Models/Lecture.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    protected $fillable = [
        'track_id',
        'title',
        'description',
        'video_url',
        'order',
        'is_preview',
    ];

    protected $casts = [
        'is_preview' => 'boolean',
    ];

    public function track()
    {
        return $this->belongsTo(Track::class);
    }
}