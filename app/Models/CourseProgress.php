<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseProgress extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    // Many-to-One relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Many-to-One relationship with Course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Many-to-One relationship with CourseContent
    public function courseContent()
    {
        return $this->belongsTo(CourseContent::class);
    }
}
