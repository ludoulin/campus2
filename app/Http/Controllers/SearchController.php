<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Department;

class SearchController extends Controller
{
    public function index(Request $request){

        $search = $request->input('query');

        $users = User::where('name','like','%'.$search.'%')->get();
        $products = Product::where('name','like','%'.$search.'%')->get();
        $departments = Department::where('name','like','%'.$search.'%')->get();
        

        return view('search.index',compact('search','products','departments','users'));
    }
}
