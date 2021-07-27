<?php

namespace App\Models\Creditors;

use Illuminate\Database\Eloquent\Model;
use App\Models\Creditors\CreditorsModule;

class Creditor extends Model
{
    protected $fillable = [
    	'name'
    ];

    public function creditors_modules(){
    	return $this->hasOne(CreditorsModule::class);
    }
}
