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

        $product = Product::find($request->product_id);
        
        if($product){

            if($product->status===0){

                return response('商品已下架', 403);
            }

            $comment = Comment::find($request->comment_id);

            if(!$comment){

                return response("找不到此留言", 404);

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

            return response("商品已不存在於平台", 404);
        }  

        return response()->json($replies);
    }

    public function update(Request $request){

        $product = Product::find($request->product_id);

        $comment = Comment::find($request->comment_id);

        $reply = Reply::find($request->id);

        if(!$product){

            return response("商品已不存在於平台", 404);

        }else{

            if($product->status===0){
                return response('商品已下架', 403);
            }

            if(!$comment){
                return response("找不到此留言", 404);
            }else{
                if(!$reply){
                    return response("找不到此回覆", 404);
                }
            }
        }

        $this->authorize('update', $reply);

        Reply::where('id',$request->id)->update(['reply_content' => $request->content ]);

        $update_comment = Reply::where('id',$request->id)->value('reply_content');

        return response()->json($update_comment);

    }
    
    public function destroy(Request $request){
       
        $product = Product::find($request->product_id);

        $comment = Comment::find($request->comment_id);

        $reply = Reply::find($request->id);

        if(!$product){

            return response("商品已不存在於平台", 404);

        }else{

            if($product->status===0){
                return response('商品已下架', 403);
            }

            if(!$comment){
                return response("找不到此留言", 404);
            }else{
                if(!$reply){
                    return response("找不到此回覆", 404);
                }
            }
        }

        $this->authorize('destroy', $reply);
        
        Reply::where('id',$request->id)->delete();
        

        $replies = Comment::where('product_id',$request->product_id)->with(['user','replies'=> function($query){$query->with("user");}])->get();

        return response()->json($replies);

    }

    public function get_reply(Request $request){

        $reply = Reply::where('id', $request->reply_id)->value('reply_content');

        return response()->json($reply);
    }

}
