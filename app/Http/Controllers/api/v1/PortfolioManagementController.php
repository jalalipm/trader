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
        // dd(auth()->user());

        // if (auth()->user()) {
        $list = PortfolioManagement::get();
        $data = ['portfolio_managements' => $list];
        return MessageHelper::instance()->sendResponse('Successfully received', $data, 200);
        // }
        // return MessageHelper::instance()->sendError('Unauthorized', [], 401);
    }

    public function get_by_user()
    {
        $list = UserAccount::GetByUserID(Auth::user()->id)->get();
        $portfolio_list = UserAccount::GetByUserID(Auth::user()->id)->distinct()
            ->select(['user_accounts.portfolio_management_id', 'portfolio_managements.title as portfolio_management_title'])->get();
        // dd($portfolio_list);
        $data = [];
        foreach ($portfolio_list as $item) {
            $data[] = [
                'id' => $item->portfolio_management_id,
                'title' => $item->portfolio_management_title,
                'remain' =>  $list->where('portfolio_management_id', $item->portfolio_management_id)->where('payment_kind', 'credit')->sum('price') -
                    $list->where('portfolio_management_id', $item->portfolio_management_id)->where('payment_kind', 'debit')->sum('price')
            ];
        }
        // dd($data);
        $data = ['portfolio_managements' => $data];
        return MessageHelper::instance()->sendResponse('Successfully received', $data, 200);
    }

    public function interest()
    {
        // dd(auth()->user());

        // if (auth()->user()) {
        $list = PortfolioManagement::orderBy('interest_rate', 'Desc')->take(5)->get();
        $data = ['portfolio_managements' => $list];
        return MessageHelper::instance()->sendResponse('Successfully received', $data, 200);
        // }
        // return MessageHelper::instance()->sendError('Unauthorized', [], 401);
    }


    public function store(Request $request)
    {
        //
    }


    public function show(PortfolioManagement $portfolioManagement, $id)
    {
        // if (auth()->user()) {
        $item = PortfolioManagement::where('id', $id)->first();
        $data = ['portfolio_management' => $item];
        return MessageHelper::instance()->sendResponse('Successfully received', $data, 200);
        // }
        // return MessageHelper::instance()->sendError('Unauthorized', [], 401);
    }


    public function update(Request $request, PortfolioManagement $portfolioManagement, $id)
    {
        //
    }


    public function destroy(PortfolioManagement $portfolioManagement, $id)
    {
        //
    }
}
