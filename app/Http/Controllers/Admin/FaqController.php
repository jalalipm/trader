<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        return view('admin.faqs.index');
    }

    public function anyData()
    {
        return datatables()->of(Faq::get())
            ->addColumn('action', function ($faq) {
                return view('admin.faqs.operations', compact('faq'));
            })->make(true);
    }

    public function create()
    {
        return view('admin.faqs.form-modal');
    }

    public function store(Request $request)
    {

        $faq_data = [
            'code' => request()->input('code'),
            'question' => request()->input('question'),
            'answer' => request()->input('answer'),
        ];
        $new_faq = Faq::create($faq_data);
        if ($new_faq instanceof Faq) {
            return response('new', 200);
        }


        return response(false, 400);
    }

    public function edit($id)
    {
        if ($id && ctype_digit($id)) {
            $faq = Faq::find($id);
            if ($faq && $faq instanceof Faq) {
                return view('admin.faqs.form-modal', compact('faq'));
            }
        }
    }

    public function update(Request $request)
    {
        $faq_item = Faq::find($request->id);
        $input = request()->except('_token');
        $faq_item->update($input);
        return response('edit', 200);
    }

    public function destroy($id)
    {
        if ($id && ctype_digit($id)) {
            $faq = Faq::find($id);
            if ($faq && $faq instanceof Faq) {
                $faq->delete();
                return response('delete', 200);
            }
        }
    }
}
