<?php

namespace App\Http\Requests\Activity;

use Illuminate\Foundation\Http\FormRequest;

class StoreAndUpdateActivity extends FormRequest
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
        if($this->method()==='POST'){

            $avatar = 'required|mimes:jpeg,jpg,bmp,png,gif|dimensions:min_width=208,min_height=208';

        }elseif($this->method()==='PATCH'){
            
            $avatar = 'mimes:jpeg,jpg,bmp,png,gif|dimensions:min_width=208,min_height=208';
        }
        return [
            'name'    => 'required|max:60',
            'avatar'  =>  $avatar,
            'year'    => 'required',
            'end_date'   => 'required|date',
            'content' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'name'    => '活動名稱',
            'avatar'  => '活動宣傳圖',
            'year'    => '年度',
            'end_date'      => '結束日期',
            'content' => '內容',
        ];
    }

    public function messages()
    {
        return [
            'avatar.required' => '活動宣傳圖一定要傳',
            'avatar.mimes' =>'活動宣傳圖必須是jpeg, png, gif格式的圖片',
            'avatar.dimensions' => '圖片的解析度不夠，寬和高需要208px以上',
            'name.between' => '使用者名稱必須介於3~25個字之間',
            'name.required' => '活動名稱一定要填',
            'name.max' => '活動名稱最多30個字',
            'year.required' => '年度一定要填',
            'end_date.required' => '結束日期一定要填',
            'content.required' => '內容一定要填'
        ];
    }
}
