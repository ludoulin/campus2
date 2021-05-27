<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactUs extends FormRequest
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
            'title'    => 'required|max:30',
            'type'     =>  'required',
            'order_number' => 'required_if:type,4|string',
            'user_email' => 'required',
            'content'  => 'required',
            'file'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'title.required' =>'標題一定要填',
            'title.max' => '標題最多30字',
            'type.required' => '活動種類一定要填',
            'user_email.required' => '使用者信箱一定要填',
            'content.required' => '描述一定要填',
            'file.mimes' => '檔案只能為jpeg,png,jpg,gif',
            'file.max' => '檔案大小不能超過2MB'
        ];
    }
}
