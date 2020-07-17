<?php

namespace App\Http\Controllers\api\v1;

use App\Helpers\MessageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StockDataRequest;
use App\Model\PortfolioManagement;
use App\Model\StockData;
use Illuminate\Http\Request;

class StockDataController extends Controller
{
    public function index()
    {
        // if (auth()->user()) {
        $list = StockData::first();
        $portfolio_list = PortfolioManagement::orderBy('interest_rate', 'Desc')->take(5)->get();
        $data = [
            'stock_data' => $list,
            'portfolio_managements' => $portfolio_list
        ];
        return MessageHelper::instance()->sendResponse('Successfully received', $data, 200);
        // }
        // return MessageHelper::instance()->sendError('Unauthorized', [], 401);
    }

    public function store(StockDataRequest $request)
    {
        $stock_data = StockData::create($request->all());
        return MessageHelper::instance()->sendResponse('Successfully registered', $stock_data, 201);
    }

    public function show(StockData $stockData)
    {
        //
    }

    public function update(Request $request, StockData $stockData)
    {
        //
    }

    public function destroy(StockData $stockData)
    {
        //
    }
}
