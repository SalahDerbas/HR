<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable , HasRoles , SoftDeletes;

    protected  $guard_name = 'web';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_ar',
        'name_en',
        'email',
        'password',
        'fcm_token',
        'usrename',
        'phone',
        'ID_code',
        'passport_code',
        'salary',
        'location_ar',
        'location_en',
        'date_of_brith',
        'join_date',
        'country_id',
        'gender_id',
        'reigon_id',
        'material_status_id',
        'work_type_id',
        'contract_type_id',
        'directory_id',
        'status_user_id',
        'photo',
        'is_directory',
        'code_auth',
        'expire_time',
        'last_login',
        'google_id',
        'facebook_id',
        'twitter_id',
        'enable_notification',
        'ip',
        'user_agent',



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
}
