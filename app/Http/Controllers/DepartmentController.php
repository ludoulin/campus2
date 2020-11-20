<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\ProductTag;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function show(Department $department)
    {
        $products = ProductTag::where('department_id',$department->id)->with('product')->get();
        // with(['product'=> function($query){$query->with("images");}])
        return view('department.index', compact('department','products'));
    }
}
