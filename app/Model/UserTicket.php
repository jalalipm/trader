<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserTicket extends Model
{
    protected $fillable = [
        'user_id', 'title', 'comment', 'full_name', 'cell_phone'
    ];

    public function UserResponses()
    {
        return $this->hasMany(UserTicketResponse::class, 'user_ticket_id', 'id');
    }

    public function scopeUserTicket($query)
    {
        return $query->join('users', 'users.id', '=', 'user_tickets.user_id')
            ->select([
                'user_tickets.id',
                'user_tickets.user_id',
                'user_tickets.title',
                'user_tickets.comment',
                'user_tickets.created_at',
                DB::raw("pdate(user_tickets.created_at) as shamsi_created_at"),
                'user_tickets.updated_at',
                'users.name as full_name',
            ]);
    }
}
