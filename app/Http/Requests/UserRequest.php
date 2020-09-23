<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Auth;

class UserRequest extends FormRequest
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

        $current_User = Auth::user();

        if($current_User->is_admin) {

            $user = $this->route('user');

            $userNameRule = 'required|between:3,25|unique:users,name,' . $user->name . ',name';

        }else {

            $userNameRule = 'required|between:3,25|unique:users,name,'. Auth::id();
        }


        return [
            'name' => $userNameRule,
            'email' => 'required|email',
            'introduction' => 'max:80',
            'avatar' => 'mimes:jpeg,bmp,png,gif|dimensions:min_width=208,min_height=208',
        ];
    }
    public function messages()
    {
        return [
            'avatar.mimes' =>'大頭貼必須是jpeg, bmp, png, gif格式的圖片',
            'avatar.dimensions' => '圖片的清晰度不夠，寬和高需要208px以上',
            'name.unique' => '使用者名稱已被使用，請重新填寫',
            'name.between' => '使用者名稱必須介於3~25個字之間。',
            'name.required' => '使用者名稱不能為空。',
        ];
    }
}
