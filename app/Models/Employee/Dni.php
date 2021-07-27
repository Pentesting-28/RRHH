<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class Dni extends Model
{
    protected $fillable = [
        'employee_id',
        'number',
        'status_dni',
        'photo_dni',
        'expiration',
    ];

    public function employee() {
        return $this->belongsTo(Employee::class);
    }
}
