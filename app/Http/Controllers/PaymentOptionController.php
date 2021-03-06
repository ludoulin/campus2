<?php

namespace App\Http\Controllers;

use App\Models\PaymentOption;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\OptionRequest;
use Auth;

class PaymentOptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit(OptionRequest $request){

        $user = User::findOrFail($request->id);


        if(!$user){

            return abort(404);

        }

        $this->authorize('update', $user);
        

        if($request->input('option')){

            if(in_array(2, $request->input('option'))&&!$user->linepay){

                return abort(422,"你還沒有設定LinePay帳號");

            }

            foreach($request->input('option') as $option){
                 
                $result = PaymentOption::where("user_id",$request->id)->where("payment_type_id", $option)->count();

                if($result == 0){

                    $paymeant_option = new PaymentOption();
                    $paymeant_option->user_id = $request->id;
                    $paymeant_option->payment_type_id = $option;
                    $paymeant_option->save();

                }else{

                    continue;
                }
            }
        }

        if(!empty($request->unchecked)){

            foreach($request->unchecked as $unoption){
                 
                $result = PaymentOption::where("user_id",$request->id)->where("payment_type_id", $unoption)->count();

                if($result!=0){

                    PaymentOption::where("user_id",$request->id)->where("payment_type_id", $unoption)->delete();

                }else{

                    continue;
                }
            }
        }

        return json_encode(Auth::user()->payment_types);
    }
}
