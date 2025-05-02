<?php

namespace App\Models;

use App\Models\User;
use App\Models\Client;
use App\Models\Messages;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MessageUsers extends Model
{
    use HasFactory;
    protected $table = 'message_users';
    protected $fillable = [
        'message_id',
        'client_id', 
        'user_id'
    ];

    public function message()
    {
        return $this->belongsTo(Message::class);
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
