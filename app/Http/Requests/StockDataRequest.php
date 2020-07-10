<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockDataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        $rule =  [
            'general_index'    => 'required',
            'general_index_change'    => 'required',
            'general_index_same_weight'    => 'required',
            'general_index_same_weight_change'    => 'required',
            'market_value'    => 'required',
            'transaction_count'    => 'required',
            'transaction_value'    => 'required',
            'transaction_volume'    => 'required',

        ];
        return $rule;
    }

    // public function messages()
    // {
    //     return [
    //         'priority.required' => 'لطفا اولویت را وارد کنید',
    //         'pic_path.required' => 'لطفا یک عکس انتخاب کنید',
    //         'pic_path.min' => 'لطفا یک عکس انتخاب کنید',
    //     ];
    // }
}
