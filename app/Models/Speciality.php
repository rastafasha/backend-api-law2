<?php

namespace App\Models;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Speciality extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'is_active',
        'isFeatured',
        'user_id',
    ];

    public function user()
    {
        return $this->hasMany(User::class, 'user_id');
    }
    public function profiles()
    {
        return $this->hasMany(Profile::class, 'speciality_id');
    }

    public static function search($query = ''){
        if(!$query){
            return self::all();
        }
        return self::where('title', 'like', "%$query%")
        ->orWhere('description', 'like', "%$query%")
        ->get();
    }
}
