<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Handlers\ImageUploadHandler;
use Auth;

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
        $data = $request->all();

        if ($request->image) {
            $result = $uploader->save($request->image, 'products', $product->id, 416);
            if ($result) {
                $data['image'] = $result['path'];
            }
        }
		$product->fill($data);
        $product->seller_id = Auth::id();
        $product->save();
         
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
        return redirect()->route('products.show', $product->id)->with('success', '更新成功');
    }

    public function destroy(Product $product)
	{
		$this->authorize('destroy', $product);
		$product->delete();

		return redirect()->route('root')->with('success', '成功刪除');
	}

}
