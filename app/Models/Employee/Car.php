<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee\Address\Address;

class Car extends Model
{
	protected $fillable = [
        'brand',
       	'model',
       	'license_plate',
       	'driver_license',
        'address_id',
    ];
    
    public function address() {
        return $this->belongsTo(Address::class);
    }
}
