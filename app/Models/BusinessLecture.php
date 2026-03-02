<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessLecture extends Model
{
    protected $table = 'business_lectures';

    protected $fillable = ['course_id', 'title', 'description', 'video_url', 'order', 'is_preview'];

    public function course()
    {
        return $this->belongsTo(BusinessCourse::class, 'course_id');
    }
}