<?php

namespace  App\Models\Settings;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee\OccupationData\OccupationData;

class Position extends Model
{
    protected $fillable = [
        'name'
    ];

    public function occupation_data() {
        return $this->hasOne(OccupationData::class);
    }
}
