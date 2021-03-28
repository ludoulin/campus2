<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone_number' => 'nullable|string|max:10',
            'face_time' => 'required',
            'payment' => 'required',
            'notes' => 'nullable|string|max:80'
        ];
    }

    public function messages()
    {
        return [
            'first_name.required'=> '請填寫姓氏',
            'last_name.required'=> '請填寫名字',
            'face_time.required' => '請選擇面交時間',
            'notes.max' => '備註最多80字',
            'payment.required' => '請勾選付款方式',
            'phone_number.max' => '電話號碼最多10碼',
        ];
    }
}
