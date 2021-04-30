<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CancelReasonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ord_hash' => 'required',
            'order_cancel' => 'required|max:100',
        ];
    }

    public function messages()
    {
        return [
            'ord_hash.required' =>'請不要惡意操作',
            'order_cancel.required' => '取消理由請一定要填寫',
            'order_cancel.max' => '取消理由最多100字',
        ];
    }
}
