<?php

namespace App\Models;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Solicitud extends Model
{
    use HasFactory;
    protected $fillable = [
        'pedido',
        'status',
    ];

    public function solicitudUsers()
    {
        return $this->hasMany(SolicitudUser::class);
    }
}
