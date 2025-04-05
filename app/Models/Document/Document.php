<?php

namespace App\Models\Document;

use App\Models\User;
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

    
}
