<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller; 
use App\Models\Activity;
use Illuminate\Http\Request;
use App\Http\Requests\Activity\StoreAndUpdateActivity;
use App\Http\Requests\Activity\PublishActivity;
use Storage;
use Illuminate\Support\Str ;


class ActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    /**
     * 條列出活動
     * 
     */
    public function index()
    {
        $activities = Activity::OrderBy('id','desc')->paginate(10);

        return view('backend.activity.index', compact('activities'));
    }

    /**
     * 新增活動頁面
     */
    public function create()
    {
        return view('backend.activity.create_or_edit');
    }


    /**
     * 儲存新增之活動
     */
    public function store(StoreAndUpdateActivity $request)
    {
            $name = $request->name;
            $year = $request->year;
            $end_date = $request->end_date;
            $content = $request->content;
            $avatar = $request->avatar;
            $str = Str::random(60);
            Storage::disk('activities')->put($str, $avatar->get());

            Activity::create([
                'name' => $name,
                'year' => $year,
                'end_date' => $end_date,
                'content' => $content,
                'avatar' =>  'storage/activities/' .$str 
            ]);
            
        return redirect()->route('admin.activity.index');
    }

    /**
     * 編輯活動頁面
     */
    public function edit(Activity $activity)
    {
        $this->authorize('operate', $activity);
        return view('backend.activity.create_or_edit', compact('activity'));
    }

    /**
     * 更新活動
     */
    public function update(StoreAndUpdateActivity $request, Activity $activity)
    {
        $this->authorize('operate', $activity);

        $data = $request->validated();

        $activity->name = $data['name'];
        $activity->year = $data['year'];
        $activity->end_date = $data['end_date'];
        $activity->content = $data['content'];
        
        if ($request->avatar) {

            if(file_exists(public_path($activity->avatar))){
                unlink(public_path($activity->avatar));
            }else{
                 dd('檔案不存在');
            }

            $imagePath = Storage::disk('activities')->put($activity->year, $data['avatar']);

            $activity->avatar = '/activities/' .$imagePath;

        }

        $activity->save();

        return redirect()->route('admin.activity.index');
    }

    /**
     * 發布/取消發布活動
     */
    public function publish(PublishActivity $request, Activity $activity)
    {
        $this->authorize('operate', $activity);

        $activity->publish = !!$request->publish;

        $activity->save();

        return redirect()->back();
    }

    /**
     * 刪除活動
     */
    public function destroy(Activity $activity)
    {  
        $this->authorize('operate', $activity);

        if(file_exists(public_path($activity->avatar))){

            unlink(public_path($activity->avatar));

        }else{

             dd('檔案不存在');
        }

        $activity->delete();
        
        return redirect()->back();
    }
}
