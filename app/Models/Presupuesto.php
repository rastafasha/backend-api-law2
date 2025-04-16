<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Client;
use App\Models\Payment;
use App\Models\Patient\Patient;
use App\Models\Doctor\Specialitie;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Presupuesto extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=[
        "user_id",
        "client_id",
        "n_doc",
        "date_appointment",
        "speciality_id",
        "user_id",
        "status",
        "confimation",
        "description",
        "diagnostico",
        "medical",
        "amount",

    ];
    
    //notificaciones

    // protected static function boot(){

    //     parent::boot();

    //     static::store(function($appointment){

    //         // PaymentRegisterJob::dispatch(
    //         //     $user
    //         // )->onQueue("high");

    //     Mail::to('mercadocreativo@gmail.com')->send(new NewAppointmentRegisterMail($appointment));

    //     });
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

    // relaciones

    public function doctor() {
        return $this->belongsTo(User::class,"user_id");
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    


    // relaciones

    // filtro buscador

    public function scopefilterAdvance($query,$speciality_id, $name_doctor, $date){
        
        if($name_doctor){
            $query->whereHas("doctor", function($q)use($name_doctor){
                $q->where("name", "like","%".$name_doctor."%")
                    ->orWhere("surname", "like","%".$name_doctor."%");
            });
        }

        if($date){
            $query->whereDate("date_presupuesto", Carbon::parse($date)->format("Y-m-d"));
        }
        return $query;
    }
    public function scopefilterAdvancePay($query,$speciality_id, $search_doctor, $search_patient,
    $date_start,$date_end){
        
        if($speciality_id){
            $query->where("speciality_id", $speciality_id);
        }

        if($search_doctor){
            $query->whereHas("doctor", function($q)use($search_doctor){
                $q->where(DB::raw("CONCAT(users.name,' ',IFNULL(users.surname,''),' ',IFNULL(users.email,''))"),"like","%".$search_doctor."%");
                   
            });
        }
        if($search_patient){
            $query->whereHas("patient", function($q)use($search_patient){
                $q->where(DB::raw("CONCAT(patients.name,' ',IFNULL(patients.surname,''),' ',IFNULL(patients.email,''))"),"like","%".$search_patient."%");
                
            });
        }

        if($date_start && $date_end){
            $query->whereBetween("date_presupuesto", [
                Carbon::parse($date_start)->format("Y-m-d"),
                Carbon::parse($date_end)->format("Y-m-d"),
            ]);
        }
        return $query;
    }
    
}
