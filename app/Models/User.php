<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'register_ref',
        'profile_photo_path'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    public function student()
    {
        return $this->hasOne('App\Models\StudentProfile');
    }

    public function teacher()
    {
        return $this->hasOne('App\Models\TeacherProfile');
    }

    public function purchase()
    {
        return $this->hasMany('App\Models\Purchase');
    }

    public function time_log(){
        return $this->hasMany('App\Models\TimeLog', 'student_id');
    }

    public function time_log_teacher(){
        return $this->hasMany('App\Models\TimeLog', 'teacher_id');
    }

    public function payment()
    {
        return $this->hasMany('App\Models\Payment');
    }

    public function student_assign()
    {
        return $this->hasMany('App\Models\AssignStudent', 'teacher_id');
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];
}
