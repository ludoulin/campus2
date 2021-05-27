<?php

namespace App\Http\Controllers;

use App\Models\Problem;
use Illuminate\Http\Request;
use App\Http\Requests\ContactUs;
use Storage;

class ProblemController extends Controller
{
    public function index(){

        $problem_types = collect(Problem::PROBLEM_TYPES);

        return view('contact_us.index',compact('problem_types'));
    }

    public function store(ContactUs $request){

        $title = $request->title;
        $type = $request->type;
        $user_email = $request->user_email;
        $content = $request->content;
        $order_number = $request->order_number;
        $file = $request->file;
        $imagePath = Storage::disk('problems')->put(Problem::PROBLEM_TYPES[$request->type], $file);

        Problem::create([
            'title' => $title,
            'type' => $type,
            'user_email' => $user_email,
            'content' => $content,
            'order_number' => $order_number,
            'file' =>  '/problems/' .$imagePath
        ]);
      return redirect()->back()->with('success','問題提交成功');
    }
}
