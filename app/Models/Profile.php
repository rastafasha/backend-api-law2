<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Client;
use App\Models\Speciality;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "speciality_id",
        "client_id",
        'nombre',
        'n_doc',
        'surname',
        'email',
        'direccion',
        'pais',
        'lang',
        'estado',
        'ciudad',
        'telhome',
        'telmovil',
        'redessociales', //json
        'precios', //json
        'avatar',
        'status',
        'rating',
        'description',
        'gender',
    ];

    // const VERIFIED = 'VERIFIED';
    // const PENDING = 'PENDING';
    // const REJECTED = 'REJECTED';
    // const PUBLISHED = 'PUBLISHED';

    /*
    |--------------------------------------------------------------------------
    | functions
    |--------------------------------------------------------------------------
    */

    // public function scopeForMember(Builder $builder)
    // {
    //     return $builder
    //         ->where("user_id", auth()->id())
    //         ->get();
    // }

    // public function scopeForPublic(Builder $builder)
    // {
    //     $builder->where("status", Profile::PUBLISHED);
    //     return $builder->get();
    // }

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
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function client()
    {
        return $this->hasMany(Client::class, 'client_id');
    }

    public function speciality()
    {
        return $this->belongsTo(Speciality::class, 'speciality_id');
    }

    // public function solicitudUser()
    // {
    //     return $this->belongsToMany(Solicitud::class, 'solicitud_user');
    // }

    

}
