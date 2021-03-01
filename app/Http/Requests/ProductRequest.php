<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        switch($this->method())
        {
            // CREATE
            case 'POST':
            {
                return [
                     // UPDATE ROLES
                     'name'       => 'required|min:2',
                     'content'        => 'required|min:3',
                     'images' => 'required',
                     'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:3048',
                     'price' => 'required|integer|regex:/^[1-9][0-9]+/|not_in:0',
                     'departments' => 'required',
                ];
            }
            // UPDATE
            case 'PUT':
            case 'PATCH':
            {
                return [
                    // UPDATE ROLES
                    'name'       => 'required|min:2',
                    'content'        => 'required|min:3',
                    'images' => 'nullable',

                    'new_images' => 'nullable',
                    'new_images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:3048',
                    

                    'price' => 'required|integer|regex:/^[1-9][0-9]+/|not_in:0',
                    'departments' => 'nullable',
                    'add_departments' => 'nullable',
                    'remove_departments' => 'nullable',
                ];
            }
            case 'GET':
            case 'DELETE':
            default:
            {
                return [];
            }
        }
    }
    public function messages()
    {
        return [
            'images.mimes' =>'大頭貼必須是jpeg, bmp, png, gif格式的圖片',
            'images.required' =>'商品照片不能不貼',
            // 'new_images.filled' =>'新增照片欄位不能為空送出,若沒有要新增照片請移除新增照片之欄位',
            'name.min' => '書名至少兩個字',
            'content.min' => '書況內容至少三個字',
            'price.required' => '價格不能為空。',
            'price.not_in' => '價格不能為0。',
            'price.regex' => '價格不能是負數或以0為開頭。',
            'departments.required'=> '請記得按下新增Tag將所選科系產生Tag',
            'payment.required' => '請記得勾選可接受的付費方式'
        ];
    }
}
