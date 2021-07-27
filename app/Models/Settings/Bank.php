<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $fillable = [
        'name',
    ];

    public function occupation_data() {
        return $this->hasOne(OccupationData::class);
    }
}
