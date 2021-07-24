<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use App\Permissions\HasPermissionsTrait;

/**
 * @property $id
 * @property $created_at
 * @property $updated_at
 * @property $active
 * @property $email
 * @property $email_verified_at
 * @property $password
 * @property $remember_token
 * @property $name
 * @property $surname
 * @property $acc_code
 * @property $deleted
 */
class User extends Authenticatable
{
    use Notifiable;
    use HasPermissionsTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','surname','rights','ucto_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
