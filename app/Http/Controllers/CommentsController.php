<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use Auth;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Comment $comment){

        $product = Product::find($request->product_id);
        
        if(!$product){
            return response('商品已不存在於平台', 404);
        }else{
            if($product->status===0){
                return response('抱歉！商品已被下架', 403);
            }
        }
       
        $comment = new Comment();
        $comment->content = $request->content;
        $comment->user_id = Auth::id();
        $comment->product_id = $request->product_id;
        $comment->save();


        $comments = Comment::where('product_id',$request->product_id)->with(['user','replies'=> function($query){$query->with("user");}])->get();

        
        return response()->json($comments);

    }

    public function update(Request $request){

        $product = Product::find($request->product_id);

        $comment = Comment::find($request->id);

        if(!$product){
            return response("商品已不存在於平台", 404);
        }else{
            if($product->status===0){
                return response("商品已被下架", 403);
            }
            if(!$comment){
                return response("找不到此留言", 404);
            }
        }

        $this->authorize('update', $comment);

        Comment::where('id',$request->id)->update(['content' => $request->content ]);

        $update_comment = Comment::where('id',$request->id)->value('content');

        return response()->json($update_comment);

    }

    public function destroy(Request $request){
    
        $product = Product::find($request->product_id);

        $comment = Comment::find($request->id);

        if(!$product){
            return response("商品已不存在於平台", 404);
        }else{
            if($product->status===0){
                return response("商品已被下架", 403);
            }
            if(!$comment){
                return response("找不到此留言", 404);
            }
        }

        $this->authorize('destroy', $comment);
        
        Comment::where('id',$request->id)->delete();
        
        $comments = Comment::where('product_id',$request->product_id)->with(['user','replies'=> function($query){$query->with("user");}])->get();

        return response()->json($comments);

    }

    public function get(Request $request){

        $comment = Comment::where('id',$request->id)->value('content');

        return response()->json($comment);
    }
}
