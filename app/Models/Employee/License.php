<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;
use App\Models\Settings\TypeLicense;

class License extends Model
{
    protected $fillable = [
        'number',
        'observation',
        'license_path',
        'expiration',
        'employee_id',
    ];

    public function employee() {
        return $this->belongsTo(Employee::class);
    }

    public function type_license() {
        return $this->belongsToMany(TypeLicense::class);
    }
}
