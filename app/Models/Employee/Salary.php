<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;
use App\Models\Settings\SalaryType;

class Salary extends Model
{
    protected $fillable = [
        'salary',
        'salary_type_id',
        'employee_id',
    ];

    public function employee() {
        return $this->belongsTo(Employee::class);
    }

    public function salary_type() {
        return $this->belongsTo(SalaryType::class);
    }
}
