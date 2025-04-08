<?php

namespace App\Models\Document;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable =[
        'user_id',
        'client_id',
        'name_file',
        'name_category',
        'size',
        'time',
        'resolution',
        'file',
        'type',

    ];

    public function getSizeAttribute($size)
    {
        $size = (int) $size;
        $base = log($size) / log(1024);
        $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');
        return round(pow(1024, $base - floor($base)), 2) . $suffixes[floor($base)];
    }

    public function clientes()
    {
        return $this->hasMany(User::class, 'cliente_id');
    }
    public function users()
    {
        return $this->hasMany(User::class, 'cliente_id');
    }

    public function scopefilterAdvanceDocument(
        $query,
        // $speciality_id,
        // $date_end,
        $search_document,
        $name_category,
        $created_at,
        $user_id
    ) {

        // if($speciality_id){
        //     $query->where("speciality_id", $speciality_id);
        // }

        if ($search_document) {
            $query->whereHas(function ($q) use ($search_document) {
                $q->where( "like", "%" . $search_document . "%");
            });
        }
        if ($name_category) {
            $query->whereHas(function ($q) use ($name_category) {
                $q->where( "like", "%" . $name_category . "%");
            });
        }
        

        if ($created_at) {
            $query->whereBetween("created_at", [
                Carbon::parse($created_at)->format("Y-m-d")
            ]);
        }
        if ($user_id) {
            $query->where("user_id", $user_id);
        }
        // if ($date_start && $date_end) {
        //     $query->whereBetween("session_date", [
        //         Carbon::parse($date_start)->format("Y-m-d"),
        //         Carbon::parse($date_end)->format("Y-m-d"),
        //     ]);
        // }
        return $query;
    }

    
}
