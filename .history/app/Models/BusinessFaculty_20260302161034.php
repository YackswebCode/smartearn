<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessFaculty extends Model
{
    protected $fillable = ['name', 'description', 'icon', 'order'];

    public function courses()
    {
        return $this->hasMany(BusinessCourse::class, 'faculty_id');
    }
}