<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PaymentType;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;
use App\Models\LinePayTradeRecord;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['except' => ['cart','show']]);
    }

    public function index()
    {
        return view('chat.home');
    }

    public function show(User $user)
    {
        $selling = $user->products()->where('status', 1)->paginate(9);

        $dealing = $user->products()->where('status', 3)->paginate(9);


        $products = [
            'selling' => $selling,
            'dealing' => $dealing,
        ];

        return view('users.show', compact('user','products'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);

        $payment_types = PaymentType::all();

        return view('users.edit', compact('user','payment_types'));
    }

    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        $this->authorize('update', $user);
        $data = $request->all();

        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id, 416);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }



        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '個人資料更新成功！');
    }

    public function getFavorites(User $user){

        $myfavorites = Auth::user()->favorites;

        return view('users.favorites', compact('myfavorites','user'));
    }

    

     public function products(User $user){

        $this->authorize('update', $user);

        return view('users.products',compact('user'));
     }


     public function orders(User $user){

        $this->authorize('update', $user);

        $id = $user->id;

        $manages = Order::withTrashed()->with(['items'=> function($query){$query->with(["product" => function($query){$query->with('images');}]);}])->where('seller_id', $id)->get();

        $types = collect(Order::Status);

        return view('users.orders_manage',compact('user','manages','types'));
     }

     public function orders_status(User $user){

        $this->authorize('update', $user);

        $orders = $user->orders()->withTrashed()->get();

        return view('users.orders_status',compact('user','orders'));
     }



    public function edit_password(Request $request){

        $user = User::findOrFail($request->id);

        if(!$user){

            return abort(404);

        }

        $this->authorize('update', $user);

        $request->validate([
            'password' => 'required',
            'new_password' => 'required|min:8|max:12',
            'verify_password' => 'same:new_password',
        ]);

        if(!\Hash::check($request->input("password"), $user->password)){

            return abort(422,"您的目前密碼輸入錯誤");

        }else{

            User::find(auth()->user()->id)->update(['password'=> Hash::make($request->input("new_password"))]);

        }

        return abort(200);

    }
}
