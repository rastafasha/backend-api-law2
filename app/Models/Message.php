<?php

namespace App\Models;

use App\Models\MessagesUsers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;
    
    protected $table = 'message';
    protected $fillable = [
        'message',
        'tema',
        'created_at',
        'updated_at'
    ];

    public function messageUsers()
    {
        return $this->hasMany(MessageUsers::class);
    }
}
