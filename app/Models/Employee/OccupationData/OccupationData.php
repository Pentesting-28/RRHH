<?php

namespace App\Models\Employee\OccupationData;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee\Employee;
use App\Models\Settings\Position;
use App\Models\ContractType\ContractType;
use App\Models\StatusEmployee\StatusEmployee;
use App\Models\Settings\PaymentMethod;
use App\Models\Settings\DepartmentType;
use App\Models\Settings\Bank;
use App\Models\Employee\ContractTermination\ContractTermination;

class OccupationData extends Model
{
    protected $fillable = [
    	'employee_id',
		'position_id',
        'contract_type_id',
        'status_employee_id',
        'payment_method_id',
        'department_type_id',
        'bank_id',
        'contract_termination_id',

        'start_contract',
        'probationary_period',
        'end_contract',
        'account_number',
        'shirt',
        'trousers',
        'dress',
        'footwear',
        'end_your_contract'
    ];

    public function employee() {
        return $this->belongsTo(Employee::class);
    }

    public function position() {
        return $this->belongsTo(Position::class);
    }

    public function contract_type() {
        return $this->belongsTo(ContractType::class);
    }

    public function status_employee() {
        return $this->belongsTo(StatusEmployee::class);
    }

    public function payment_method() {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function bank() {
        return $this->belongsTo(Bank::class);
    }

    public function department_type() {
        return $this->belongsTo(DepartmentType::class);
    }

    public function contract_termination() {
        return $this->belongsTo(ContractTermination::class);
    }
}
