<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SolicitudUser extends Model
{
    use HasFactory;

    protected $table = 'solicitud_user';

    protected $fillable = [
        'solicitud_id',
        'cliente_id', 
        'user_id'
    ];

    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class);
    }

    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
