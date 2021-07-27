<?php

namespace App\Models\Permission;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'name'
    ];

    public function user()
    {
        return $this->belongsToMany(User::class);
    }
}
