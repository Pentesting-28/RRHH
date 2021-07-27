<?php

namespace App\Models\Employee\MedicalInformation;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee\Employee;

class MedicalInformation extends Model
{
    protected $fillable = [
		'employee_id',
        'height',
        'weight',
        'blood_type',
        'donor',
        'hospitalized',
        'hospitalized_explain',
        'disease',
        'disease_explain',
        'treatment',
        'treatment_explain',
        'allergic',
        'allergic_explain',
        'lenses',
        'hearing',
        'drugs',
        'drugs_explain',
        'psychiatric',
        'psychiatric_explain',
    ];

    public function employee() {
        return $this->belongsTo(Employee::class);
    }
}
