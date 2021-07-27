<?php

namespace App\Models\Employee\ContractTermination;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee\OccupationData\OccupationData;

class ContractTermination extends Model
{

	protected $fillable = [
    	'name'
    ];

    public function employee() {
        return $this->hasOne(OccupationData::class);
    }
}
