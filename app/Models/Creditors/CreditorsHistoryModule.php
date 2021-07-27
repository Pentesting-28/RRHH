<?php

namespace App\Models\Creditors;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee\Employee;
use App\User;

class CreditorsHistoryModule extends Model
{
    protected $fillable = [
        'employee_id',
        'user_id',
        'amount',
        'action',
    ];

    public function employee() {
        return $this->belongsTo(Employee::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
