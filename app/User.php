<?php

namespace App;

use App\Models\Auth\Role;
use App\Models\Companies\Company;
use App\Models\Permission\Permission;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\Employee\SalaryHistoryModule;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'role_id', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role() {
        return $this->belongsTo(Role::class);
    }

    public function permission()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function history_salary() {
        return $this->hasMany(SalaryHistoryModule::class);
    }

    public function history_creditor() {
        return $this->hasMany(CreditorsHistoryModule::class);
    }
}
