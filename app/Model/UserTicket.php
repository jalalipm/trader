<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserTicket extends Model
{
    protected $fillable = [
        'user_id', 'title', 'comment', 'full_name', 'cell_phone'
    ];

    public function UserTicketResponses()
    {
        return $this->hasMany(UserTicketResponse::class, 'user_ticket_id', 'id');
    }
}
