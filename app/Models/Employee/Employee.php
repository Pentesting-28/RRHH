<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee\Address\Address;
use App\Models\Employee\Contact\Contact;
use App\Models\Employee\MedicalInformation\MedicalInformation;
use App\Models\Employee\OccupationData\OccupationData;
use App\Models\StatusMarital\StatusMarital;
use App\Models\Creditors\CreditorsModule;
use App\Models\Settings\DrivingLicense;


class Employee extends Model
{
    protected $fillable = [
        'name',
        'middle_name',
        'last_name',
        'second_surname',
        'dni',
        'photo_dni',
        'photo',
        'social_security',
        'status_marital_id',
        'date_birth',
        'age'
    ];

    public function license() {
        return $this->hasMany(License::class);
    }

    public function creditors_module() {
        return $this->hasMany(CreditorsModule::class);
    }

    public function status_marital() {
        return $this->belongsTo(StatusMarital::class);
    }

    public function contact() {
        return $this->hasOne(Contact::class);
    }

    public function address() {
        return $this->hasOne(Address::class);
    }    

    public function dependent() {
        return $this->hasOne(Dependent::class);
    }

    public function medical_information() {
        return $this->hasOne(MedicalInformation::class);
    }

    public function occupation_data() {
        return $this->hasOne(OccupationData::class);
    }

    public function salary() {
        return $this->hasMany(Salary::class);
    }

    public function history_salary() {
        return $this->hasMany(SalaryHistoryModule::class);
    }

    public function history_creditor() {
        return $this->hasMany(CreditorsHistoryModule::class);
    }

    public function dnis() {
        return $this->hasOne(Dni::class);
    }

    public function driving_license() {
        return $this->hasOne(DrivingLicense::class);
    }
}
