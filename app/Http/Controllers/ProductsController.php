<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductImage;
use App\Handlers\ImageUploadHandler;
use Auth;
use Storage;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }
    
    public function create(Product $product)
    {
         
     return view('product.create_and_edit',compact('product'));
    }
    
    public function store(ProductRequest $request, Product $product,ImageUploadHandler $uploader)
    {
            $user = Auth::user();
            $name = $request->name;
            $price = $request->price;
            $content = $request->content;
            $price = $request->price;

            $product = Product::create([
                'name' => $name,
                'price' => $price,
                'content' =>$content,
                'seller_id' => $user->id,
            ]);
    

            if($request->hasfile('images'))
            {
                foreach($request->file('images') as $image)
                {
                    // $filename=$image->getClientOriginalName();
                    // $filepath = $image->move(public_path().'/product_image/'. $product->id, $filename);  // your folder path
                    // $uploader->reduceSize($filepath, 416);
                    // $data[] = $filename;  

                     $imagePath = Storage::disk('product_image')->put($product->id, $image);  // your folder path
                     $product_image = new ProductImage;
                     $product_image->path = config('app.url') . '/product_image/' .$imagePath;
                     $product_image->product_id = $product->id;
                     $product_image->save();
                }
            }
           
         
        return redirect()->route('products.show', $product->id)->with('success', '新增成功');
    }

    public function show(Product $product)
    {
        return view('product.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $this->authorize('update', $product);
        return view('product.create_and_edit', compact('product'));
    }

    public function update(ProductRequest $request, Product $product, ImageUploadHandler $uploader)
    {
        $this->authorize('update', $product);
        $data = $request->all();

        if ($request->image) {
            $result = $uploader->save($request->image, 'products', $product->id, 416);
            if ($result) {
                $data['image'] = $result['path'];
            }
        }
        $product->update($data);

        return redirect()->route('products.show', $product->id)->with('success', '更新成功');
    }

    public function destory(Product $product)
	{
		$this->authorize('destroy', $product);
		$product->delete();

		return redirect()->route('root')->with('success', '成功刪除');
	}

}
