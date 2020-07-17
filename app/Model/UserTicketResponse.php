<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserTicketResponse extends Model
{
    protected $fillable = [
        'user_id', 'user_ticket_id', 'response'
    ];
}
