<?php

namespace App\Models\Creditors;

use Illuminate\Database\Eloquent\Model;
use App\Models\Creditors\TypeExpense;
use App\Models\Creditors\Creditor;
use App\Models\Employee\Employee;

class CreditorsModule extends Model
{
    protected $fillable = [
    	'name',
    	'quantity',
    	'type_expense_id',
    	'creditor_id',
        'employee_id'
    ];

    public function type_expense(){
    	return $this->belongsTo(TypeExpense::class);
    }

    public function creditor(){
    	return $this->belongsTo(Creditor::class);
    }

    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}
