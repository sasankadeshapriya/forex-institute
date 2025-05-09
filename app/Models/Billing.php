<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Billing extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    // Many-to-One relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
