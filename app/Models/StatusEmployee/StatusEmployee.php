<?php

namespace App\Models\StatusEmployee;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee\OccupationData\OccupationData;

class StatusEmployee extends Model
{
    protected $fillable = [
        'name'
    ];
    
    public function occupation_data() {
        return $this->hasOne(OccupationData::class);
    }
}
