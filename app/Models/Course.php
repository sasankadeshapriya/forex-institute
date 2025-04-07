<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    // One-to-Many relationship with CourseContents
    public function contents()
    {
        return $this->hasMany(CourseContent::class);
    }

    // Many-to-Many relationship with Users through Orders
    public function users()
    {
        return $this->belongsToMany(User::class, 'orders');
    }

    // One-to-Many relationship with CourseProgress
    public function courseProgress()
    {
        return $this->hasMany(CourseProgress::class);
    }

    // One-to-Many relationship with Orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
