<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'client_id',
        'sale_id',
        'visit_date',
        'visit_status',
        'confirmation_image',
        'remarks'
    ];

    protected $casts = [
        'visit_date' => 'datetime'
    ];

    public function employee() {
        return $this->belongsTo(User::class);
    }

    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function sale() {
        return $this->belongsTo(Sale::class);
    }
}
