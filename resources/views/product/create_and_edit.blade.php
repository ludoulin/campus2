@extends('layouts.basic')

@section('content')

  <div class="container">
    <div class="col-md-10 offset-md-1">
      <div class="card ">

        <div class="card-body">
          <h2 class="">
            <i class="far fa-edit"></i>
            @if($product->id)
            編輯二手書資訊
            @else
            我要賣二手書
            @endif
          </h2>

          <hr>

          @if($product->id)
            <form action="{{ route('products.update', $product->id) }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                @method('PATCH')
          @else
            <form action="{{ route('products.store') }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="POST">
          @endif
             @csrf
              @include('shared.error')

              <div class="form-group">
                <label for="name">書名:</label>
                <input id="name" class="form-control" type="text" name="name" value="{{ old('name', $product->name ) }}" placeholder="請填寫書名" required />
              </div>

              <div class="form-group">
                <label for="price">價格:</label>
                <input id="price" class="form-control" type="text" name="price" value="{{ old('price', $product->price ) }}" placeholder="請填寫價格" required />
              </div>

              <div class="form-group">
                <label for="content">書況:</label>
                <textarea id="content" name="content" class="form-control" rows="6" placeholder="請填入書況說明,至少3個字。" required>{{ old('content', $product->content ) }}</textarea>
              </div>

              {{-- <div class="form-group mb-4">
                  <label for="image">商品圖片上傳:</label>
                  <input type="file" id="image" name="image" class="form-control-file" required>
      
                  @if($product->image)
                    <br>
                    <img src="{{ $product->image }}" width="200">
                  @endif
                </div> --}}

                <div class="form-group control-group increment" >
                    <label for="images">商品圖片上傳:</label>
                    <input type="file" name="images[]" class="form-control">
                    <div class="input-group-btn"> 
                      <button class="btn btn-success" type="button"><i class="glyphicon glyphicon-plus" required></i>Add</button>
                    </div>
                  </div>
                  <div class="clone hide">
                    <div class="control-group input-group" style="margin-top:10px">
                      <input type="file" name="images[]" class="form-control">
                      <div class="input-group-btn"> 
                        <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                      </div>
                    </div>
                  </div>

              <div class="well well-sm">
                <button type="submit" class="btn btn-primary"><i class="far fa-save mr-2" aria-hidden="true"></i>刊登商品</button>
              </div>
            </form>
        </div>
      </div>
    </div>
  </div>

@endsection


@section('script')
<script>
  $(document).ready(function() {
    var max_input = 5;
    var x = $('.increment');
    var y = x.length;
    $(".btn-success").click(function(){ 
      console.log(y);
      if(y<max_input){
        var html = $(".clone").html();
        $(".increment").after(html);
        y++;
        if(y==max_input){
        $(".btn-success").attr('disabled', true);
        }
        console.log(y);
      }
      return false
    });
    $("body").on("click",".remove",function(){ 
      if(y>1){
        if(y==max_input){
          $(".btn-success").attr('disabled', false);
        }
        $(this).parents(".control-group").remove();
        y--;
        console.log(y);
      }
      return false;
    });
  });
</script>
@endsection