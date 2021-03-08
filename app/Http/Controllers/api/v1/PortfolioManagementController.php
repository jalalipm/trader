<?php

namespace App\Http\Controllers\api\v1;

use App\Helpers\MessageHelper;
use App\Http\Controllers\Controller;
use App\Model\PortfolioManagement;
use App\Model\UserAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortfolioManagementController extends Controller
{

    public function index(PortfolioManagement $portfolioManagement)
    {
        $list = PortfolioManagement::get();
        $data = ['portfolio_managements' => $list];
        return MessageHelper::instance()->sendResponse('Successfully received', $data, 200);
    }

    public function get_by_user()
    {
        $list = UserAccount::GetByUserID(Auth::user()->id)->get();
        $portfolio_list = UserAccount::GetByUserID(Auth::user()->id)->distinct()
            ->select(['user_accounts.portfolio_management_id', 'portfolio_managements.title as portfolio_management_title'])->get();
        $data = [];
        foreach ($portfolio_list as $item) {
            $data[] = [
                'id' => $item->portfolio_management_id,
                'title' => $item->portfolio_management_title,
                'remain' =>  $list->where('portfolio_management_id', $item->portfolio_management_id)->where('payment_kind', 'credit')->sum('price') -
                    $list->where('portfolio_management_id', $item->portfolio_management_id)->where('payment_kind', 'debit')->sum('price')
            ];
        }
        $data = ['portfolio_managements' => $data];
        return MessageHelper::instance()->sendResponse('Successfully received', $data, 200);
    }

    public function interest()
    {
        $list = PortfolioManagement::orderBy('interest_rate', 'Desc')->take(5)->get();
        $data = ['portfolio_managements' => $list];
        return MessageHelper::instance()->sendResponse('Successfully received', $data, 200);
    }


    public function show(PortfolioManagement $portfolioManagement, $id)
    {
        $item = PortfolioManagement::where('id', $id)->first();
        $data = ['portfolio_management' => $item];
        return MessageHelper::instance()->sendResponse('Successfully received', $data, 200);
    }
}
