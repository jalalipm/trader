<?php

namespace App\Http\Controllers\api\v1;

use App\Helpers\MessageHelper;
use App\Http\Controllers\Controller;
use App\Model\PortfolioManagement;
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
