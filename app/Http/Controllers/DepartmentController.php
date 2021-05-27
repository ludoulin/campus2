<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DepartmentController extends Controller
{
    public function show(Department $department){
        
        return view('department.index', compact('department'));

    }

    public function search(Request $request){
        
        $id = $request->department;
        $builder = Product::with(['images','user','favorited','carted'])->where(function($query) use ($id) {
            $query->whereHas('tags',function ($query) use ($id) {
                            $query->where('department_id', '=', $id);
                    });
        });
    

        if ($search = $request->input('keywords', '')) {
            $like = '%'.$search.'%';
    
            
            $builder->where(function($query) use ($like) {
                $query->where('name', 'like', $like)
                    ->orWhereHas('user', function ($query) use ($like) {
                        $query->where('name', 'like', $like);
                    });
                
            });

        }

        if ($order = $request->input('order', '')) {
            if (preg_match('/^(.+)_(asc|desc|month|week|day|hour|)$/', $order, $m)) {
                if (in_array($m[1], ['price', 'created_at'])) {

                    if($m[2]==='week'){
                        $week = Carbon::now()->subWeek(); 
                        $builder->where($m[1],'>=',$week);
                        // $builder->whereBetween($m[1], [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);

                    }elseif($m[2]==='day'){
                        $day = Carbon::now()->subDay(1);
                        $builder->where($m[1],'>=',$day);

                    }elseif($m[2]==='hour'){
                            $hour = Carbon::now()->subHours(1);
                            $builder->where($m[1],'>=',$hour);
    
                    }elseif($m[2]==='month'){
                        $month = Carbon::now()->subMonth();
                        $builder->where($m[1],'>=',$month);

                     }else{
                        $builder->orderBy($m[1], $m[2]);
                    }

                }
            }
        }
     
        $products = $builder->get();

        return response()->json($products);

    }
}
