<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'image',
        'file',
        'type',
        'is_active',
        'user_id',
    ];


    public function users()
    {
        return $this->hasMany(User::class, 'user_id');
    }

    public static function search($query = ''){
        if(!$query){
            return self::all();
        }
        return self::where('title', 'like', "%$query%")
        ->orWhere('description', 'like', "%$query%")
        ->get();
    }

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
}
