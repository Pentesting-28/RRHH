<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Role extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    public function user() {
    	return $this->hasMany(User::class);
    }
}
