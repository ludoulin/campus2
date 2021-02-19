<?php

namespace App\Http\Controllers\Auth;

use App\Models\CartItem;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        if(!session()->has('url.intended'))
        {
        session(['url.intended' => url()->previous()]);
        }
        return view('auth.login');

    }   

    protected function sendLoginResponse(Request $request)
    {   
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        $user = Auth::user();

        if($user->is_admin){
           
            return redirect()->route('backend');

        }else{

            if (Session::has('cart'))
            {
                $carts = session()->get('cart');

                foreach($carts as $cart){

                    $id = $cart["product_id"];

                    $result = CartItem::where('user_id', Auth::id())->where('product_id', $id)->count();
                     
                    if($result==0){
                    
                    $cart_item = new CartItem();
                    $cart_item->product_id = $cart["product_id"];
                    $cart_item->user_id = Auth::id();
                    $cart_item->save();

                    }
                    
                }
            }

        }

        return $this->authenticated($request, $this->guard()->user())
        ?: redirect()->intended($this->redirectPath())->with('success', '您已成功登入！');
                
    }
}
