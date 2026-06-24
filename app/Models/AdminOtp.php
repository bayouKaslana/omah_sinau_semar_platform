<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminOtp extends Model
{
    protected $fillable = ['email', 'otp', 'expires_at'];

    protected $casts = [
        'expires_at' => 'datetime',
    ];
}
