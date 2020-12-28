<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Message extends Model
{
    protected $fillable = [
        'user_id', 'title', 'message', 'is_read'
    ];

    public function scopeMessage($query)
    {
        return $query->leftJoin('users', 'users.id', '=', 'messages.user_id')
            ->select([
                'messages.id',
                'messages.user_id',
                'messages.title',
                'messages.message',
                'messages.is_read',
                'messages.created_at',
                'messages.updated_at',
                'users.name as full_name'
            ]);
    }
}
