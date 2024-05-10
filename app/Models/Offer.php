<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'cost',
        'size',
        'panels',
        'savings'
    ];

    protected $casts = [
        'cost' => 'int',
        'savings' => 'int'
    ];
}
