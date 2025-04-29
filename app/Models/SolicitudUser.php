<?php

namespace App\Models;

use App\Models\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SolicitudUser extends Model
{
    use HasFactory;

    protected $table = 'solicitud_user';

    protected $fillable = [
        'solicitud_id',
        'client_id', 
        'user_id'
    ];

    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
