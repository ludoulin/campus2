<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LinePayRequest extends FormRequest
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
            'channelId' => 'required|string|regex:/^([0-9]{10})$/',
            'channelSecret' => 'required|string|regex:/^(?=.*[a-z])(?=.*\d)[a-z\d]{32}$/'
        ];
    }

    public function messages()
    {
        return [
            'channelId.required'=> '不能空值送出',
            'channelSecret.required'=>'不能空值送出',
            'channelId.regex' => 'ID只能為10碼的數字',
            'channelSecret.regex' => '金鑰只能為32碼的英文和數字',
        ];
    }
}
