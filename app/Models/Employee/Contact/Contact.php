<?php

namespace App\Models\Employee\Contact;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee\Employee;

class Contact extends Model
{
	protected $fillable = [
		'employee_id',
        'tlf_home',
        'tlf_movil',
        'email',
    ];

    public function employee() {
        return $this->belongsTo(Employee::class);
    }
}
