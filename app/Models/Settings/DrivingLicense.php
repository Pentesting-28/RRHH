<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee\Employee;

class DrivingLicense extends Model
{
	protected $fillable = [
	    'employee_id',
	    'number',
	    'observation',
	    'license_path',
	    'expiration',
	    'license_types_id',
    ];

    public function employee() {
        return $this->belongsTo(Employee::class);
    }

    public function license_types() {
        return $this->belongsTo(LicenseType::class);
    }
}
