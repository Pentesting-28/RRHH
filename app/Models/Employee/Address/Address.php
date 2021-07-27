<?php

namespace App\Models\Employee\Address;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee\Employee;
use App\Models\Employee\Car;

class Address extends Model
{
	protected $fillable = [
		'employee_id',
        'name',
        'status_car',
    ];

    public function employee() {
        return $this->belongsTo(Employee::class);
    }

    public function car() {
        return $this->hasOne(Car::class);
    }
}
