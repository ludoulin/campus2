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
                    //  'image' => 'mimes:jpeg,bmp,png,gif|dimensions:min_width=208,min_height=208',
                     'images' => 'required',
                     'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:3048',
                     'price' => 'required',
                     'departments' => 'required'
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
                    // 'image' => 'mimes:jpeg,bmp,png,gif|dimensions:min_width=208,min_height=208',
                    'images' => 'required',
                    'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:3048',
                    'price' => 'required',
                    'department' => 'required',
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
            // 'image.dimensions' => '圖片的清晰度不夠，寬和高需要208px以上',
            'images.required' =>'商品照片不能不貼',
            'name.min' => '書名至少兩個字',
            'content.min' => '書況內容至少三個字',
            'price.required' => '價格不能為空。',
        ];
    }
}
