<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use Auth;

class ReplysController extends Controller
{
    public function store(Request $request, Reply $reply){


        $product = Product::findOrFail($request->product_id);
        
        if($product){

        $comment = Comment::findOrFail($request->comment_id);

        if(!$comment){

         return abort(404);

        }else{
        
        $reply = new Reply();
        $reply->reply_content = $request->reply_content;
        $reply->user_id = Auth::id();
        $reply->product_id = $request->product_id;
        $reply->comment_id = $request->comment_id;
        $reply->save();

        $replies = Comment::where('product_id',$request->product_id)->with(['user','replies'=> function($query){$query->with("user");}])->get();

        }

    }else{

        return response()->json("商品已遭刪除");
    }  

        // $replies = Reply::where('comment_id',$request->comment_id)->with('user')->get();


        return response()->json($replies);
    }

    public function update(Request $request){

        $reply = Reply::findOrFail($request->id);

        if(!$reply){

            return abort(404);

        }

        $this->authorize('update', $reply);

        Reply::where('id',$request->id)->update(['reply_content' => $request->content ]);

        $update_comment = Reply::where('id',$request->id)->value('reply_content');


        return response()->json($update_comment);

    }
    
    public function destroy(Request $request){
       
        $reply = Reply::findOrFail($request->id);

        if(!$reply){

            return abort(404);

        }

        $this->authorize('destroy', $reply);
        
        Reply::where('id',$request->id)->delete();
        

        $replies = Comment::where('product_id',$request->product_id)->with(['user','replies'=> function($query){$query->with("user");}])->get();

        return response()->json($replies);

    }

    public function get_reply(Request $request)
    {
        
        $reply = Reply::where('id', $request->reply_id)->value('reply_content');

        return response()->json($reply);
    }

}
