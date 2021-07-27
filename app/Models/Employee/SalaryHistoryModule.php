<?php

namespace App\Models\Employee;
use App\User;

use Illuminate\Database\Eloquent\Model;

class SalaryHistoryModule extends Model
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
