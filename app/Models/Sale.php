<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'offer_id',
        'monthly_savings',
        'annual_savings',
        'estimated_cost',
        'estimated_cost_with_net_metering',
        'payback_period',
        'annual_electricity',
        'annual_electricity_bill_no_solar'
    ];

    public function panel() {
        return $this->belongsTo(Offer::class, 'offer_id');
    }

    public function schedule() {
        return $this->hasOne(Schedule::class);
    }

    public function invoice() {
        return $this->hasMany(Invoice::class);
    }
}
