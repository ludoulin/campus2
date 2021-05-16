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
                     'product_type' => 'required',
                     'course_type' => 'required',
                     'isbn'       => 'required_if:product_type,0|string',
                     'name'       => 'required|string|min:2',
                     'author'       => 'required_if:product_type,0|string|min:2',
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
                    'product_type' => 'required',
                    'course_type' => 'required',
                    'isbn'       => 'required_if:product_type,0|string|regex:/^([0-9]{10}|[0-9]{13})$/',
                    'name'       => 'required|string|min:2',
                    'author'       => 'required_if:product_type,0|string|min:2',
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
            'product_type.required'   => '請記得勾選類型',
            'course_type.required'   => '請選擇課程分類',
            'images.mimes' =>'大頭貼必須是jpeg, bmp, png, gif格式的圖片',
            'images.required' =>'請記得上傳商品照片',
            'name.required'   => '請記得填書名',
            'name.min' => '書名至少兩個字',
            'content.required'   => '請記得填書況',
            'content.min' => '書況內容至少三個字',
            'price.required' => '請記得填寫價錢。',
            'price.not_in' => '價格不能為0。',
            'price.regex' => '價格不能是負數或以0為開頭。',
            'departments.required'=> '請記得按下新增Tag將所選科系產生Tag',
            'isbn.required'       => '請記得填isbn碼',
            'author.required'       => '請記得填作者',
        ];
    }
}
