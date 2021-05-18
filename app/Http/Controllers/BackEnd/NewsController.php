<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Http\Requests\News\StoreAndUpdateNews;
use Illuminate\Support\Carbon;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }
    /**
     * 顯示最新消息條列表
     */
    public function index()
    {
        $newsList = News::paginate(10);
        return view('backend.news.index',compact('newsList'));
    }

    /**
     * 最新消息新增頁面
     */
    public function create()
    {
        $news_types = collect(News::NEWS_TYPES);

        return view('backend.news.create_or_edit',compact('news_types'));
    }

    /**
     * 新增最新消息請求
     */
    public function store(StoreAndUpdateNews $request)
    {
        $name = $request->name;
        $type = $request->type;
        $publish_date = $request->publish_date;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $sticky_flag = $request->sticky_flag ? true : false;
        $content = $request->content;

        News::create([
            'name' => $name,
            'type' => $type,
            'publish_date' => $publish_date,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'sticky_flag' => $sticky_flag,
            'content' => $content,
        ]);

        return redirect()->route('admin.news.index');
    }

    /**
     * 編輯最新消息頁面
     */
    public function edit(News $news)
    {
        $this->authorize('operate', $news);

        $news_types = collect(News::NEWS_TYPES);

        return view('backend.news.create_or_edit', compact('news','news_types'));
    }

    /**
     * 編輯最新消息請求
     */
    public function update(StoreAndUpdateNews $request, News $news)
    {
        $news->name = $request->name;
        $news->type = $request->type;
        $news->publish_date = $request->publish_date;
        $news->start_date = $request->start_date;
        $news->end_date = $request->end_date;
        $news->sticky_flag = $request->sticky_flag ? true : false ;
        $news->content = $request->content;


        $news->save();
        
        return redirect()->route('admin.news.index');
    }

    /**
     * 刪除最新消息
     */
    public function destroy(News $news)
    {
        $this->authorize('operate', $news);

        $news->delete();

        return redirect()->back();
    }
}
