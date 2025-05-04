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
}
