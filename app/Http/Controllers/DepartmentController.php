<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Product;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function show(Department $department , Request $request)
    {
        // $products = ProductTag::where('department_id',$department->id)->
        // with(['product'=> function($query){$query->with('images');}])->get();
        // // with('product')->get();
        // return view('department.index', compact('department','products'));

        $builder = Product::with(['images'])->where(function($query) use ($department) {
            $query->whereHas('tags',function ($query) use ($department) {
                            $query->where('department_id', '=', $department->id);
                    });
        });
    

        if ($search = $request->input('search', '')) {
            $like = '%'.$search.'%';
    
            
            $builder->where(function($query) use ($like) {
                $query->where('name', 'like', $like)
                    ->orWhereHas('user', function ($query) use ($like) {
                        $query->where('name', 'like', $like);
                    });
                
            });

        }

        if ($order = $request->input('order', '')) {
            if (preg_match('/^(.+)_(asc|desc)$/', $order, $m)) {
                if (in_array($m[1], ['price', 'created_at'])) {

                    $builder->orderBy($m[1], $m[2]);

                }
            }
        }
     
        $filters= [
            'search' => $search,
            'order'  => $order,
        ] ;


        $products = $builder->get();

        return view('department.index', compact('department','products','filters'));
    }
}
