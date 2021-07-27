<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee\License;

class LicenseLetter extends Model
{
    protected $fillable = [
        'name',
    ];

    public function license() {
        return $this->belongsToMany(License::class);
    }
}
