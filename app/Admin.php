<?php

namespace App;

use App\Models\Auth\Role;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Admin extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $guard = 'admin';

    protected $fillable = ['name', 'role_id', 'email', 'password'];

    protected $hidden   = ['password', 'remember_token'];

    public function role() {
        return $this->belongsTo(Role::class);
    }
}
