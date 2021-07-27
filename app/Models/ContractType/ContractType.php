<?php

namespace App\Models\ContractType;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee\OccupationData\OccupationData;

class ContractType extends Model
{
	protected $fillable = [
        'name'
    ];
    
    public function occupation_data() {
        return $this->hasOne(OccupationData::class);
    }
}
