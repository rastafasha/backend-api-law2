<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\DocumentsUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_category',
        'name_file',
        'size',
        'resolution',
        'file',
        'type',
    ];

    public function documentsUsers()
    {
        return $this->hasMany(DocumentsUser::class);
    }

    public function setCreatedAtAttribute($value)
    {
        date_default_timezone_set('America/Caracas');
        $this->attributes["created_at"] = Carbon::now();
    }

    public function setUpdatedAtAttribute($value)
    {
        date_default_timezone_set("America/Caracas");
        $this->attributes["updated_at"] = Carbon::now();
    }

    public function getSizeAttribute($size)
    {
        $size = (int) $size;
        $base = log($size) / log(1024);
        $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');
        return round(pow(1024, $base - floor($base)), 2) . $suffixes[floor($base)];
    }


    public static function search($query = '')
    {
        if (!$query) {
            return self::all();
        }
        return self::where('name_file', 'like', "%$query%")
            ->get();
    }

    public function scopeFilterAdvanceDocument($query, $name_category, $search_document, $created_at, $user_id)
    {
        return $query->when($user_id, function ($q) use ($user_id) {
            return $q->whereHas('documentsUsers', function ($q2) use ($user_id) {
                $q2->where('user_id', $user_id);
            });
        })
        ->when($search_document, function ($q) use ($search_document) {
            return $q->where('name_file', 'like', "%$search_document%");
        })
        ->when($name_category, function ($q) use ($name_category) {
            return $q->where('name_category', 'like', "%$name_category%");
        })
        ->when($created_at, function ($q) use ($created_at) {
            return $q->whereDate('created_at', $created_at);
        });
    }



    public function scopefilterAdvanceDocument1(
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
