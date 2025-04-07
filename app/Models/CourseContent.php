<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseContent extends Model
{
    use HasFactory, SoftDeletes;

    // One-to-Many relationship with CourseProgress
    public function courseProgress()
    {
        return $this->hasMany(CourseProgress::class);
    }

    // Many-to-One relationship with Course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
