<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'course_id',
        'status',
        'total_amount',
        'payment_method',
        'transaction_id',
    ];
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

    // One-to-One relationship with Payment
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
