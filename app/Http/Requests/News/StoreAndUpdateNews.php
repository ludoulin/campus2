<?php

namespace App\Http\Requests\News;

use Illuminate\Foundation\Http\FormRequest;

class StoreAndUpdateNews extends FormRequest
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
            'name'    => 'required',
            'type'     => 'required',
            'publish_date'  => 'required|date',
            'start_date'    => 'required|date',
            'end_date'  => 'required|date',
            'content'  => 'required',
            'sticky_flag'  => 'nullable',
        ];  
    }

    public function attributes()
    {
        return [
            'name'    => '標題',
            'type'     => '消息種類',
            'publish_date'  => '發布時間',
            'start_date'    => '顯示開始時間',
            'end_date'  => '顯示結束時間',
            'content'  => '內容',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '標題一定要傳',
            'type.required' => '消息種類一定要填',
            'publish_date.required' => '發布時間一定要填',
            'start_date.required' => '顯示開始時間一定要填',
            'end_date.required' => '顯示結束時間一定要填',
            'content.required' => '內容一定要填'
        ];
    }
}
