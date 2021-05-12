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
use Auth;
use Storage;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['addToCart','show','removeCart','index','search']]);
    }

    public function index()
    {

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
     
        $products = $builder->where('is_stock',true)->paginate(8);

        return response()->json($products);
    }
    
    public function create(Product $product)
    {

     $colleges = College::all();

     $product_types = collect(Product::PRODUCT_TYPES);

     $course_types = collect(Product::COURSE_TYPES);
         
     return view('product.create_and_edit',compact('product','colleges','product_types','course_types'));
    }

    public function getDepartment($id){
      
     $departments = Department::where("college_id", $id)->pluck("name","id");
     
     return json_encode($departments);

    }
    
    public function store(ProductRequest $request, Product $product)
    {
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

            if($request->hasfile('images'))
            {
                foreach($request->file('images') as $image)
                {
                     $imagePath = Storage::disk('product_image')->put($product->id, $image);  // your folder path
        
                     ProductImage::create([
                        'path'=> '/product_image/' .$imagePath,
                        'product_id' => $product->id,
                        ]);
                }
            }
 
        return redirect()->route('products.show', $product->id)->with('success', '新增成功');
    }

    public function show(Product $product)
    {
        if(!$product->is_stock&&$product->seller_id!=Auth::id()){

            return abort(404);
        }

        $product->visits()->increment();

        return view('product.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $this->authorize('update', $product);

        $colleges = College::all();

        $product_types = collect(Product::PRODUCT_TYPES);

        $course_types = collect(Product::COURSE_TYPES);
            
        return view('product.create_and_edit', compact('product','colleges','product_types','course_types'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $this->authorize('update', $product);
        
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
        

        if(($request->hasfile('new_images')))
            {
                foreach($request->file('new_images') as $image)
                {
                     $imagePath = Storage::disk('product_image')->put($product->id, $image);  // your folder path
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

    public function destroy(Product $product)
	{
        $this->authorize('destroy', $product);
        
		$product->delete();

		return redirect()->route('root')->with('success', '成功刪除');
    }

    
    
    public function favoriteProduct(Product $product)
    {

        Auth::user()->favorites()->attach($product->id);

        return back();
    }

    public function unFavoriteProduct(Product $product)
    {
        Auth::user()->favorites()->detach($product->id);

        return back();
    }

    public function addToCart(Request $request){
        
        $id = $request->id;

        $product = Product::find($id);

        if(!$product) {

            return abort(404);
        }

        if(!Auth::check()){
 
        $cart = session()->get('cart');
        // if cart is empty then this the first product
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

             return "加入購物車成功";
        }

        if(isset($cart[$id])) {
           
            return "商品已存在於購物車";

        }else{

        // if item not exist in cart then add to cart with quantity = 1
        $cart[$id] = [
           "name" => $product->name,
           "product_id" => $product->id,
           "seller_id" => $product->user->id,
           "price" => $product->price,
           "image" => $product->images[0]->path,
           "is_stock" => $product->is_stock
        ];

        session()->put('cart', $cart);

        return "加入購物車成功";
    }

        }else{

            Auth::user()->cartitems()->attach($product->id);

            return "登入狀態加入購物車成功";

        }

    }

    public function removeCart(Request $request)
    {
        $id = $request->id;

        $product = Product::find($id);

        if(!$product) {
            
            return abort(404);
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

            // return back();
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