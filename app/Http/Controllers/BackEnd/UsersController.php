<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;
use App\Http\Requests\ForbidRequest;
use App\Handlers\ImageUploadHandler;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    public function IndexPage()
    {
        $users = User::select('id','name','email','created_at','updated_at','is_admin','is_banned')->get();
        return view('backend.user.index',compact('users'));
    }

    public function AdminEdit(User $user)
    {
        // $this->authorize('adminEdit', $user);
        if($user->isAdmin()){

            return abort(403,'請至管理員編輯頁面操作');
        }

        return view('backend.user.edit', compact('user'));
    }

    public function AdminUpdate(UserRequest $request, ImageUploadHandler $uploader,User $user)
    {
 
        $data = $request->validated();

        $user->name = $data['name'];
        $user->introduction = $data['introduction'];
        $user->password =  Hash::make($data['password']);

        if ($request->avatar) {
            $result = $uploader->save($data['avatar'], 'avatars', $user->id, 416);
            if ($result) {
                $data['avatar'] = $result['path'];
                $user->avatar = $data['avatar'];
            }
        }
        // if ($request->password) {
        //     $data['password'] = Hash::make($request->password);
        // }

        $user->save();

        return redirect()->route('admin.users');
    }

    public function publish(ForbidRequest $request , User $user)
    {
       
        $user->is_banned = !!$request->publish;

        $user->save();

        return redirect()->back();
    }

}
