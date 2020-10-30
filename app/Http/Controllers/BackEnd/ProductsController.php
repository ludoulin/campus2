<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Handlers\ImageUploadHandler;
use App\Models\Product;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    public function index()
    {
        $products = Product::with('user')->paginate(10);
        return view('backend.product.index',compact('products'));

    }

    public function edit(Product $product)
    {
        return view('backend.product.edit', compact('product'));
    }

    public function update(ProductRequest $request, Product $product, ImageUploadHandler $uploader)
    {
        $data = $request->all();

        $product->name = $data['name'];
        $product->price = $data['price'];
        $product->content = $data['content'];

        if ($request->image) {
            $result = $uploader->save($request->image, 'products', $product->id, 416);
            if ($result) {
                $data['image'] = $result['path'];
            }
        }

        $product->save();

        return redirect()->route('admin.products.index')->with('success', '更新商品成功');
    }


    public function destroy(Product $product)
	{
		$product->delete();

		return back()->with('success', '成功刪除');
	}
}
