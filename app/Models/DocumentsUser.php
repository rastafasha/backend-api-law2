<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentsUser extends Model
{
    use HasFactory;
    protected $table = 'documents_users';
    protected $fillable = [
        'document_id',
        'client_id', 
        'user_id'
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
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
