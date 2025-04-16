<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Client;
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
        'client_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
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

    public function scopeFilterAdvanceDocument($query, $name_category, $search_document, $created_at, $user_id)
    {
        return $query->where('user_id', $user_id)
            ->when($search_document, function($q) use ($search_document) {
                return $q->where('name_file', 'like', "%$search_document%");
            })
            ->when($name_category, function($q) use ($name_category) {
                return $q->where('name_file', 'like', "%$name_category%");
            })
            ->when($created_at, function($q) use ($created_at) {
                return $q->where('name_file', 'like', "%$created_at%");
            });
    }
}
