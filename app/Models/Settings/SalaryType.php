<?php

namespace  App\Models\Settings;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee\Salary;

class SalaryType extends Model
{
    protected $fillable = [
        'name'
    ];

    public function salary() {
        return $this->hasMany(Salary::class);
    }
}
