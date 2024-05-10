<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Client extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'otp',
        'security_code',
        'street',
        'barangay',
        'province',
        'city',
        'zip',
        'mobile_number',
        'alignment',
        'average_bill',
        'bill',
        'goal',
        'status',
        'date_joined'
    ];

    protected $hidden = [
        'otp',
        'security_code',
        'password',
        'remember_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function schedule() {
        return $this->hasMany(Schedule::class, 'client_id');
    }
}
