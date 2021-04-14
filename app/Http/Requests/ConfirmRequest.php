<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmRequest extends FormRequest
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
            'confirm' => 'required',
            'transaction' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'confirm.required'=> '請不要亂設定空值',
            'transaction.required'=>'請不要亂設定空值'
        ];
    }
}
