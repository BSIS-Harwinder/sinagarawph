<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'user_id',
        'amount',
        'full_price',
        'payment_date',
        'transaction_type',
        'proof_of_payment',
        'approval_status'
    ];

    public function sale() {
        return $this->belongsTo(Sale::class);
    }
}
