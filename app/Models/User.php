<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    function isAdmin() {
        return $this->id === 1;
    }
    function isManager() {
        return $this->id === 2;
    }

    public function setNewPasswordAttribute($value)
    {
        if(strlen($value) > 5)
        {
            $this->password = bcrypt($value);
        }
    }
}
