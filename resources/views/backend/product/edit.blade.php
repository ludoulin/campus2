@extends('layouts.control_panel')

@section('title', '商品管理編輯')

@section('content')

  <div class="container">
    <div class="col-md-10 offset-md-1">
      <div class="card ">

        <div class="card-body">
          <h2 class="">
            <i class="far fa-edit"></i>
            編輯二手書資訊
          </h2>

          <hr>

            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                @method('PATCH')
             @csrf
              @include('shared.error')

              <div class="form-group">
                <label for="name">書名:</label>
                <input id="name" class="form-control" type="text" name="name" value="{{ old('name', $product->name ) }}" placeholder="請填寫書名" required />
              </div>

              <div class="form-group">
                <label for="product_price">價格:</label>
                <input id="product_price" class="form-control" type="text" name="price" value="{{ old('price', $product->price ) }}" placeholder="請填寫價格" required />
              </div>

              <div class="form-group">
                <label for="product_content">價格:</label>
                <textarea id="product_content" name="product_content" class="form-control" rows="6" placeholder="請填入書況說明,至少3個字。" required>{{ old('content', $product->content ) }}</textarea>
              </div>

              <div class="form-group mb-4">
                  <label for="image">商品圖片上傳:</label>
                  <input type="file" id="image" name="image" class="form-control-file" required>
      
                  @if($product->image)
                    <br>
                    <img src="{{ $product->image }}" width="200">
                  @endif
                </div>

              <div class="well well-sm">
                <button type="submit" class="btn btn-primary"><i class="far fa-save mr-2" aria-hidden="true"></i>刊登商品</button>
                <a class="btn btn-secondary" href="{{ route('admin.products.index') }}">離開</a>
              </div>
            </form>
        </div>
      </div>
    </div>
  </div>

@endsection