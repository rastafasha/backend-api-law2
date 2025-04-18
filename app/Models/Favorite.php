<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Favorite extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'cliente_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
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
