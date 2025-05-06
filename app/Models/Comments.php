<?php

namespace App\Models;

use App\Models\User;
use App\Models\Client;
use App\Models\Solicitud;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comments extends Model
{

    use HasFactory;
    protected $fillable = [
        'comment',
        'rating',
        'solicitud_id',
        'user_id',
        'client_id'
    ];
    


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class);
    }
}
