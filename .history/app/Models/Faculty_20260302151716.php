<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    protected $fillable = ['name', 'description', 'icon', 'order'];

    public function tracks()
    {
        return $this->hasMany(Track::class);
    }
}