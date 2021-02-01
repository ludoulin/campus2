<?php

use App\Models\Department;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/search', function(Request $request){
    $query = $request->input('query');
    $users = User::where('name','like','%'.$query.'%')->get();
    $products = Product::where('name','like','%'.$query.'%')->get();
    $departments = Department::where('name','like','%'.$query.'%')->get();
    $merged = $products->merge($users);
    $merged = $merged->merge($departments);
    return response()->json($merged);
   });
