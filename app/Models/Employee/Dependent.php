<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee\Children\Children;
use App\Models\Employee\Employee;

class Dependent extends Model
{
    protected $fillable = [
        'employee_id',
        'name_father',
        'name_mother',
        'name_spouse',
        'date_spouse',
        'spouse_job',
        'spouse_position',
        'family_business',
        'urgency_notify',
        'urgency_relationship',
        'urgency_res',
        // 'urgency_office',
        'urgency_address',
        'children_status',
    ];

    public function employee() {
        return $this->belongsTo(Employee::class);
    }

    public function children() {
        return $this->hasMany(Children::class);
    }
}
