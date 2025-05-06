<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Profile;
use App\Models\Location;
use App\Models\MessageUsers;
use App\Traits\HavePermission;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Doctor\Specialitie;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Doctor\DoctorScheduleDay;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable implements JWTSubject
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

    const GUEST = 'GUEST';

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

    public function isGuest()
    {
        return $this->role === User::GUEST;
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

    public function clients_user()
    {
        return $this->hasMany(ClientsUser::class, 'client_id');
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function solicitudUsersAsCliente()
    {
        return $this->hasMany(SolicitudUser::class, 'client_id');
    }

    public function messagesUsersAsCliente()
    {
        return $this->hasMany(MessageUsers::class, 'client_id');
    }


    
    


}
