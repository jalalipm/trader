<?php

namespace App\Http\Controllers\api\v1;

use App\Helpers\MessageHelper;
use App\Http\Controllers\Controller;
use App\Model\PortfolioManagement;
use App\Model\UserAccount;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpseclib\Crypt\Random;

class DashboardController extends Controller
{

    public function get_dashboard()
    {
        // dd(date('Y-m-d h:i:s', 1595415847000 / 1000), date('Y-m-d h:i:s', 1595414332597 / 1000));
        $x = [];
        $y = [];
        for ($i = 29; $i >= 0; $i--) {
            $x[] = Carbon::now(new \DateTimeZone('Asia/Tehran'))->subDay($i)->timestamp * 1000;
            if ($i > 20)
                $rnd = random_int(5000000, 6500000);
            else if ($i >= 10 && $i < 20)
                $rnd = random_int(6600000, 8000000);
            else $rnd = random_int(8000000, 9000000);
            $y[] = $rnd;
        }
        $portfolio_list = PortfolioManagement::orderBy('interest_rate', 'Desc')->take(5)->get();
        $data = [
            'dashboard' => [
                'user_balance' => UserAccount::GetByUserID(Auth::user()->id)->sum('user_accounts.price'),
                'portfolio_managements' => $portfolio_list,
                'today_income' => 262300,
                'today_income_percent' => 2.23,
                'income' => 8432500,
                'income_percent' => 1.28,
                'x' => $x,
                'y' => $y,
            ]
        ];

        return MessageHelper::instance()->sendResponse('Successfully received', $data, 200);
    }
}
