<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\PortfolioManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class PortfolioManagementController extends Controller
{
    public function index()
    {
        return view('admin.portfolio_managements.index');
    }

    public function anyData()
    {
        return datatables()->of(PortfolioManagement::get())
            ->addColumn('action', function ($portfolio_management) {
                return view('admin.portfolio_managements.operations', compact('portfolio_management'));
            })->make(true);
    }

    public function create()
    {
        // return view('admin.portfolio_managements.form-modal');
        return view('admin.portfolio_managements.create');
    }

    public function store(Request $request)
    {

        $portfolio_management_data = [
            'title' => request()->input('title'),
            'describtion' => request()->input('describtion'),
        ];
        $new_name = request()->input('title') . '_' . str_random(8) . '.' . request()->file('avatar')->getClientOriginalExtension();
        $result_save_file = request()->file('avatar')->move(public_path('images/portfolio_managements'), $new_name);
        if ($result_save_file instanceof \Symfony\Component\HttpFoundation\File\File) {
            $portfolio_management_data['avatar'] = url("/images/portfolio_managements/{$new_name}");
            $new_portfolio_management = PortfolioManagement::create($portfolio_management_data);
            if ($new_portfolio_management instanceof PortfolioManagement) {
                // return response('new', 200);
                return response(route('admin.portfolio_managements.edit', $new_portfolio_management->id), 200);
            }
        }


        return response(false, 400);
    }

    public function edit($id)
    {
        if ($id && ctype_digit($id)) {
            $portfolio_management = PortfolioManagement::find($id);
            if ($portfolio_management && $portfolio_management instanceof PortfolioManagement) {
                // return view('admin.portfolio_managements.form-modal', compact('portfolio_management'));
                return view('admin.portfolio_managements.create', compact('portfolio_management'));
            }
        }
    }

    public function update(Request $request)
    {
        if (Request()->hasFile('avatar')) {
            $input = request()->except('_token');
            $new_name = request()->input('title') . '_' . str_random(8) . '.' . request()->file('avatar')->getClientOriginalExtension();
            $result_save_file = request()->file('avatar')->move(public_path('images/portfolio_managements'), $new_name);
            if ($result_save_file instanceof \Symfony\Component\HttpFoundation\File\File) {
                $input['avatar'] = url("/images/portfolio_managements/{$new_name}");
                $portfolio_management_item = PortfolioManagement::find($request->id);
                $base_url = URL::to('/');
                $file_name = public_path() . substr($portfolio_management_item->avatar, strlen($base_url));
                if ($portfolio_management_item->avatar != null && $portfolio_management_item->avatar != '' && file_exists($file_name))
                    unlink($file_name);
                $portfolio_management_item->update($input);
                // return response('edit', 200);
                return response(route('admin.portfolio_managements.edit', $portfolio_management_item->id), 200);
            } else {
                return response('error', 400);
            }
        } else {
            $portfolio_management_item = PortfolioManagement::find($request->id);
            $input = request()->except('_token', 'avatar');

            $portfolio_management_item->update($input);
            // return response('edit', 200);
            return response(route('admin.portfolio_managements.edit', $portfolio_management_item->id), 200);
        }
    }

    public function destroy($id)
    {
        if ($id && ctype_digit($id)) {
            $portfolio_management = PortfolioManagement::find($id);
            // dd($portfolio_management);
            if ($portfolio_management && $portfolio_management instanceof PortfolioManagement) {
                $portfolio_management->delete();
                if (isset($portfolio_management->avatar)) {
                    $base_url = URL::to('/');
                    $file_name = public_path() . substr($portfolio_management->avatar, strlen($base_url));
                    if (file_exists($file_name))
                        unlink($file_name);
                }
                return response('delete', 200);
            }
        }
    }
}
