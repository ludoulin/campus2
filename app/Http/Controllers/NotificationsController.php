<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(20);


        return view('notifications.index', compact('notifications'));
    }

    public function reset(){

        Auth::user()->RestUnread();

        $notification_count = User::where('id', auth()->id())->value('notification_count');

        return response()->json($notification_count);
    }

    public function read(Request $request){
        
        Auth::user()->unreadNotifications()->find($request->id)->markAsRead();

        return 'success';

    }

    public function sync(){
       
        $notifications = Auth::user()->notifications()->data;

        return response()->json($notifications);
        

    }
}
