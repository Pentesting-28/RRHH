<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class LicenseType extends Model
{
    protected $fillable = [
        'name',
    ];

    public function driving_license() {
        return $this->hasOne(DrivingLicense::class);
    }
}
