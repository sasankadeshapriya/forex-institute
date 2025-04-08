<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    // One-to-Many relationship with Orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // One-to-One relationship with Billing
    public function billing()
    {
        return $this->hasOne(Billing::class);
    }

    // One-to-Many relationship with CourseProgress
    public function courseProgress()
    {
        return $this->hasMany(CourseProgress::class);
    }

    // Many-to-Many relationship with Courses through Orders
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'orders');
    }

}
