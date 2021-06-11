<?php

namespace App\Http\Controllers\Auth;

use App\Models\CartItem;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use DebugBar\DebugBar;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
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

    public function showLoginForm(Request $request)
    {
        if(!session()->has('url.intended')){

          session(['path' => url()->previous()]);

          if(session()->has('key')){

            Session::forget('key');
          }

        }else{

            session(['path' => session('url.intended')]);
            Session::forget('url.intended');
        }


        $encrypted = $request->input('linkToken') ? $request->input('linkToken') : null;
        
        return view('auth.login',compact('encrypted'));

    }   

    protected function sendLoginResponse(Request $request)
    {   
        
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        $user = Auth::user();

        if($request->lineToken && !$user->line_user_id){
            $user->nonce = Str::random(16);
            $user->save();
            return response()->view('auth.connect',['linkToken' => $request->lineToken , 'nonce' => $user->nonce]);
        }

        if(!$user->is_admin){

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

            if(Session::has('key')){

                return redirect()->route('checkout.session');
            }

        }


        return $this->authenticated($request, $this->guard()->user())
        ?: redirect()->intended($this->redirectPath());
                
    }


    public function redirectTo()
    {
        if (Auth::user()->is_admin === true) {
            return route('backend');
        }

        return session('path');
    }
}

// if(!session()->has('url.intended'))
// {
//     session(['url.intended' => url()->previous()]);
// }