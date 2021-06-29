<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\College;
use App\Models\Department;
use App\Models\ProductTag;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Auth;
use Storage;

class ProductsController extends Controller
{
    public function __construct(){

        $this->middleware('auth', ['except' => ['addToCart','show','removeCart','index','search']]);
    }

    public function index(){

        return view('product.index');
    }

    public function search(Request $request){
      
        $builder = Product::with(['images','user','favorited','carted']);

        if ($search = $request->input('keywords', '')) {
            $like = '%'.$search.'%';
            $builder->where(function($query) use ($like) {
                $query->where('name', 'like', $like)
                    ->orWhereHas('user', function ($query) use ($like) {
                        $query->where('name', 'like', $like);
                    });
                });
        }

        if ($product_type = $request->input('product_type','')) {
    
            $builder->where('type', '=' , $product_type);

        }

        if ($course_type = $request->input('course_type', '')) {
    
            $builder->where('course_type', '=' , $course_type);

        }

        if ($order = $request->input('order', '')) {
            if (preg_match('/^(.+)_(asc|desc|month|week|day|hour|)$/', $order, $m)) {
                if (in_array($m[1], ['price', 'created_at'])) {

                    if($m[2]==='week'){
                        $week = Carbon::now()->subWeek(); 
                        $builder->where($m[1],'>=',$week);

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
     
        $products = $builder->where('status', 1)->paginate(8);

        return response()->json($products);
    }
    
    public function create(Product $product){

        $colleges = College::all();

        $product_types = collect(Product::PRODUCT_TYPES);

        $course_types = collect(Product::COURSE_TYPES);
            
        return view('product.create_and_edit',compact('product','colleges','product_types','course_types'));
    }

    public function getDepartment($id){
      
        $departments = Department::where("college_id", $id)->pluck("name","id");
        
        return json_encode($departments);

    }
    
    public function store(ProductRequest $request, Product $product){
            $user = Auth::user();
            $type = $request->product_type;
            $course_type = $request->course_type;
            $isbn = $request->isbn;
            $name = $request->name;
            $authors = $request->author;
            $price = $request->price;
            $content = $request->content;
            $departments = $request->departments;

            $product = Product::create([
                'type' => $type,
                'course_type' => $course_type,
                'isbn' => $isbn,
                'name' => $name,
                'author'=> $authors,
                'price' => $price,
                'content' =>$content,
                'seller_id' => $user->id,
            ]);
           
        if($departments){
            foreach($departments as $department){
                if(!empty($department)){
                    $product_tag = new ProductTag();
                    $product_tag->product_id = $product->id;
                    $product_tag->department_id = $department;
                    $product_tag->save();
                }
            }
        }

        if($request->hasfile('images')){
            foreach($request->file('images') as $image){
                $imagePath = Storage::disk('product_image')->put($product->id, $image);  // your folder path
                ProductImage::create([
                        'path'=> '/product_image/' .$imagePath,
                        'product_id' => $product->id,
                    ]);
                }
            }
        return redirect()->route('products.show', $product->id)->with('success', '新增成功');
    }
    public function show(Product $product){

        if(Auth::check()){

            if($product->status===0 && $product->seller_id != Auth::id()){

                return response()->view('errors.404', ['message' => '抱歉商品已下架'], 404);
            }

        }else{

            if($product->status===0){

                return response()->view('errors.404', ['message' => '抱歉商品已下架'], 404);
            }
        }

        $product->visits()->increment();

        return view('product.show', compact('product'));

        // if(!$product->is_stock&&$product->seller_id!=Auth::id()){

        //     return abort(404);
        // }
    }

    public function edit(Product $product){

        $this->authorize('update', $product);

        $colleges = College::all();

        $product_types = collect(Product::PRODUCT_TYPES);

        $course_types = collect(Product::COURSE_TYPES);
            
        return view('product.create_and_edit', compact('product','colleges','product_types','course_types'));
    }

    public function update(ProductRequest $request, Product $product){

        $this->authorize('update', $product);

        $data = $request->all();
    
        if($request->add_departments){
            foreach($request->add_departments as $add_department){
                if(!empty($add_department)){
                    $product_tag = new ProductTag();
                    $product_tag->product_id = $product->id;
                    $product_tag->department_id = $add_department;
                    $product_tag->save();
                }
            }
        }

        if($request->remove_departments){
            foreach($request->remove_departments as $remove_department){
                if(!empty($remove_department)){
                    ProductTag::where('product_id',$product->id)->where('department_id',$remove_department)->delete();
                }
            }
        }
        
        if(($request->hasfile('new_images'))){
            foreach($request->file('new_images') as $image){
                    // 將圖片檔放入資料夾
                    $imagePath = Storage::disk('product_image')->put($product->id, $image); 
                     ProductImage::create([
                        'path'=> '/product_image/' .$imagePath,
                        'product_id' => $product->id,
                ]);
            }
        }
        
        if($request->remove_images){
            foreach($request->remove_images as $remove_image){
                if(!empty($remove_image)){
                    $del = ProductImage::find($remove_image);
                    // 將圖片檔移出資料夾
                    if(file_exists(public_path($del->path))){
                        unlink(public_path($del->path));
                        $del->delete();
                    }else{
                        dd('File does not exists.');
                    }
                }
            }
        }

        $product->update($data);

        return redirect()->route('products.show', $product->id)->with('success', '更新成功');
    }

    public function destroy(Product $product){

        $this->authorize('destroy', $product);
        
		$product->delete();

		return redirect()->route('users.products', Auth::id())->with('success', '成功刪除');
    }


    /**
     * 發布/取消發布商品
     */
    public function publish(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $product->status = $request->publish;

        $product->save();

        return back();
    }

    public function favoriteProduct(Request $request){

        $id = $request->id;

        $product = Product::find($id);

        if(!$product) {

            return response('商品已不存在於平台', 404);

        }else{

            if($product->status===0){
                return response('商品已下架', 403);
            }elseif($product->status===3){
                return response('商品已售出', 404);
            }
        }

        Auth::user()->favorites()->attach($product->id);

        return response("加入收藏", 200);
    }

    public function unFavoriteProduct(Request $request){

        $id = $request->id;

        $product = Product::find($id);

        if(!$product) {

            return response('商品已不存在於平台', 404);

        }else{

            if($product->status===0){
                return response('商品已下架', 403);
            }elseif($product->status===3){
                return response('商品已售出', 404);
            }
        }

        Auth::user()->favorites()->detach($product->id);

        return response("成功移除", 200);
    }

    public function addToCart(Request $request){
        
        $id = $request->id;

        $product = Product::find($id);

        if(!$product) {

            return response('商品已不存在於平台', 404);

        }else{

            if($product->status===0){
                return response('商品已下架', 403);
            }elseif($product->status===3){
                return response('商品已售出', 404);
            }
        }

        if(!Auth::check()){
            //未登入加入購物車
            $cart = session()->get('cart');
            // 如果cart為空就假設為一個新物件
            if(!$cart) {
                $cart = [
                    $id => [
                        "name" => $product->name,
                        "product_id" => $product->id,
                        "seller_id" => $product->user->id,
                        "price" => $product->price,
                        "image" => $product->images[0]->path,
                        "is_stock" => $product->is_stock
                    ]
               ];

                session()->put('cart', $cart);

                Log::info(session()->get('reply'));

                return response("加入購物車成功", 200);
            }

            if(isset($cart[$id])) {
                //已存在於購物車
                return response("商品已存在於購物車", 200);

            }else{

                $cart[$id] = [
                    "name" => $product->name,
                    "product_id" => $product->id,
                    "seller_id" => $product->user->id,
                    "price" => $product->price,
                    "image" => $product->images[0]->path,
                    "is_stock" => $product->is_stock
                ];

                session()->put('cart', $cart);

                Log::info(session()->get('reply'));

                return response("加入購物車成功", 200);
            }
        }else{
            //登入後加入購物車
            Auth::user()->cartitems()->attach($product->id);

            return response("加入購物車", 200);
        }
    }

    public function removeCart(Request $request){

            $id = $request->id;

            $product = Product::find($id);

            if(!$product) {

                return response('商品已不存在於平台', 404);
    
            }else{
    
                if($product->status===0){
                    return response('商品已下架', 403);
                }elseif($product->status===3){
                    return response('商品已售出', 404);
                }
            }
        
            if(!Auth::check()){

                if($request->id) {

                    $cart = session()->get('cart');

                    if(isset($cart[$request->id])) {
                        unset($cart[$request->id]);
                        session()->put('cart', $cart);
                    }
                }
            }else{

                Auth::user()->cartitems()->detach($product->id);

                return response('成功移除', 200);

            }
        }
}

                    // $filename=$image->getClientOriginalName();
                    // $filepath = $image->move(public_path().'/product_image/'. $product->id, $filename);  // your folder path
                    // $uploader->reduceSize($filepath, 416);
                    // $data[] = $filename;

                    //  $product_image = new ProductImage;
                    //  $product_image->path = config('app.url') . '/product_image/' .$imagePath;
                    //  $product_image->product_id = $product->id;
                    //  $product_image->save();


                     // $product->name = $data['name'];
                     // $product->price = $data['price'];
                     // $product->content = $data['content'];

                     // if ($request['new_images']){
                     //     dd('test');
                        // } else{
                        //     dd('pass');
                    // }
                    // if ($request->file('new_images')){
                    //     dd('test');
                    // } else{
                    //     dd('pass');
                     // }