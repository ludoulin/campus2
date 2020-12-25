<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Reply;
use Illuminate\Http\Request;
use App\Notifications\ProductReplied;
use App\Http\Requests\CommentRequest;
use Auth;

class CommentsController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function store(Request $request, Comment $comment)
    {
        // $comment->content = $request->content;
        // $comment->user_id = Auth::id();
        // $comment->product_id = $request->product_id;
        // $comment->save();

        $comment = new Comment();
        $comment->content = $request->content;
        $comment->user_id = Auth::id();
        $comment->product_id = $request->product_id;
        $comment->save();


        $comments = Comment::where('product_id',$request->product_id)->with('user')->get();

        
        return response()->json($comments);
        // return redirect()->back()->with('success', '感謝留言！');
    }

    public function update(Request $request){

        $comment = Comment::findOrFail($request->id);

        $this->authorize('update', $comment);

        Comment::where('id',$request->id)->update(['content' => $request->content ]);

        $update_comment = Comment::where('id',$request->id)->value('content');


        return response()->json($update_comment);

    }

    public function destroy(Request $request)
    {
    
        $comment = Comment::findOrFail($request->id);

        // dd($comment);

        $this->authorize('destroy', $comment);
        
        Comment::where('id',$request->id)->delete();
        
        // $comment->delete();

        $comments = Comment::where('product_id',$request->product_id)->with('user')->get();

        return response()->json($comments);

        // return redirect()->back()->with('success', '刪除成功！');
    }


    public function get(Request $request)
    {
        $comment = Comment::where('id',$request->id)->value('content');

        return response()->json($comment);
    }

    public function reply_get(Request $request){

    // $replies = Comment::where('id', $request->id)->with('replies')->get();

    $replies = Reply::where('comment_id', $request->id)->with('user')->get();

    return response()->json($replies);
    }
}
