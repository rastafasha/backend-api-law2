<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Payment;
use App\Models\Profile;
use App\Models\Location;
use App\Traits\HavePermission;
use App\Jobs\NewUserRegisterJob;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Doctor\Specialitie;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Doctor\DoctorScheduleDay;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, HavePermission,  HasRoles;
    use SoftDeletes;
    /*
    |--------------------------------------------------------------------------
    | goblan variables
    |--------------------------------------------------------------------------
    */

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    const SUPERADMIN = 'SUPERADMIN';
    const ADMIN = 'ADMIN';
    const GUEST = 'GUEST';
    const DOCTOR = 'DOCTOR';
    const LABORATORIO = 'LABORATORIO';
    const RECEPCION = 'RECEPCION';
    const ASISTENTE = 'ASISTENTE';
    const ENFERMERA = 'ENFERMERA';
    const PERSONAL = 'PERSONAL';

    public function setCreatedAtAttribute($value)
    {
    	date_default_timezone_set('America/Caracas');
        $this->attributes["created_at"]= Carbon::now();
    }

    public function setUpdatedAtAttribute($value)
    {
    	date_default_timezone_set("America/Caracas");
        $this->attributes["updated_at"]= Carbon::now();
    }


    /*
    |--------------------------------------------------------------------------
    | functions
    |--------------------------------------------------------------------------
    */

    public function isSuperAdmin()
    {
        return $this->role === User::SUPERADMIN;
    }

    public function isAdmin()
    {
        return $this->role === User::ADMIN;
    }
    public function isGuest()
    {
        return $this->role === User::GUEST;
    }
    public function isRecepcion()
    {
        return $this->role === User::RECEPCION;
    }
    public function isDoctor()
    {
        return $this->role === User::DOCTOR;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */



    public function speciality()
    {
        return $this->belongsTo(Specialitie::class, 'speciality_id');
    }

    public function schedule_days()
    {
        return $this->hasMany(DoctorScheduleDay::class);
    }
    public function location()
    {
        return $this->hasMany(Location::class, 'location_id');
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    
    


}
