<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        $rule =  [
            'user_id'    => 'required',
            'transaction_date'    => 'required',
            'ref_id'    => 'required',
            'amount'    => 'required',
            'payment_kind'    => 'required',

        ];
        return $rule;
    }

    public function messages()
    {
        //     return [
        //         'priority.required' => 'لطفا اولویت را وارد کنید',
        //         'pic_path.required' => 'لطفا یک عکس انتخاب کنید',
        //         'pic_path.min' => 'لطفا یک عکس انتخاب کنید',
        //     ];
    }
}
