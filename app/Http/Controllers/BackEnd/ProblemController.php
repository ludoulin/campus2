<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Problem;
use Illuminate\Http\Request;

class ProblemController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    /**
     * 顯示問題列表
     */
    public function index()
    {
        $problemsList = Problem::paginate(10);
        return view('backend.problem.index',compact('problemsList'));
    }


    /**
     * 顯示問題頁面
     */
    public function show(Problem $problem)
    {
        $problem_types = collect(Problem::PROBLEM_TYPES);
        return view('backend.problem.show',compact('problem','problem_types'));
    }

    /**
     * 刪除問題
     */
    public function destroy(Problem $problem)
    {  
        $problem->delete();
        
        return redirect()->back();
    }
}
