<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DigitalLecture extends Model
{
    use HasFactory;

    protected $table = 'digital_lectures';

    protected $fillable = [
        'track_id',
        'title',
        'content',
        'video_url',
        'order',
    ];

    public function track()
    {
        return $this->belongsTo(DigitalTrack::class);
    }
}