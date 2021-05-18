<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\News;
use Illuminate\Http\Request;


class NewsController extends Controller
{
    public function index(){

        $newsCollection = News::orderBy('sticky_flag', 'desc')->orderBy('publish_date', 'desc')->paginate(10);

        $activities = Activity::where('publish', true)->orderBy('id','desc')->take(10)->get();

        return view('news.index',compact('newsCollection','activities'));
    }
}
