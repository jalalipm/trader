<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PortfolioManagement extends Model
{
    protected $table = 'portfolio_managements';
    protected $fillable = [
        'title', 'avatar', 'describtion', 'interest_rate'
    ];
}
