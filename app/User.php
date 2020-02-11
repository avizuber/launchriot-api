<?php

namespace App;
use App\Portfolio;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;
use Laravel\Passport\HasApiTokens;
use App\Traits\Encryptable;

class User extends Authenticatable implements Auditable
{
    use HasApiTokens, Notifiable, Encryptable, \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are encrypted.
     *
     * @var array
     */
    protected $encryptable = [
        'f_name', 'l_name',
    ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'f_name', 'l_name', 'email', 'password',
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

    /**
     * Functions related to User Roles
     *
     */

    public function roles() {
        return $this->belongsToMany('App\Role');
    }

    public function hasAnyRoles($roles) {

        if($this->roles()->whereIn('name', $roles)->first()){
            return true;
        }

        return false;
    }

    public function hasRole($role) {

        if($this->roles()->where('name', $role)->first()){
            return true;
        }

        return false;
    }

    /**
     * Functions related to User Profile
     *
     */

    public function profile() {
        return $this->hasOne('App\Profile');
    }

    public function getAllUserPortfolios() {

        $portfoliosCreatedBy = Portfolio::all()->where('user_id', '=', $this->id);

        return $portfoliosCreatedBy;
    }

}
