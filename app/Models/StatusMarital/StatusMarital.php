<?php

namespace App\Models\StatusMarital;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee\Employee;

class StatusMarital extends Model
{
    protected $fillable = [
        'name'
    ];
    
    public function employee() {
        return $this->hasOne(Employee::class);
    }
}
