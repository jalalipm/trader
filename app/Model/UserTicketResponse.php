<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserTicketResponse extends Model
{
    protected $fillable = [
        'user_id', 'user_ticket_id', 'response'
    ];

    public function scopeTicketResponse($query)
    {
        return $query->join('users', 'users.id', '=', 'user_ticket_responses.user_id')
            ->select([
                'user_ticket_responses.id',
                'user_ticket_responses.user_id',
                'user_ticket_responses.response',
                'user_ticket_responses.created_at',
                DB::raw("pdate(user_ticket_responses.created_at) as shamsi_created_at"),
                'user_ticket_responses.updated_at',
                'users.name as full_name',
            ]);
    }
}
