<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'reason_id',
        'action_id',
        'remarks'
    ];

    public function employee() {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function reason() {
        return $this->belongsTo(Reason::class);
    }

    public function action() {
        return $this->belongsTo(Action::class);
    }
}
