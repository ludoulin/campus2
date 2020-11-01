@extends('layouts.basic')


@section('content')

  <div class="row">

    <div class="col-lg-3 col-md-3 hidden-sm hidden-xs author-info">
      <div class="card ">
        <div class="card-body">
          <div class="text-center">
           賣家:{{ $product->user->name }}
          </div>
          <hr>
          <div class="media">
            <div align="center">
                <img class="thumbnail img-fluid" src="{{$product->user->avatar}}" width="300px" height="300px">
              <a href="{{ route('users.show', $product->seller_id) }}">賣家資訊</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    

    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 topic-content">
      <div class="card ">
        <div class="card-body">
            <div class="mt-4 mb-4" style="text-align:center;">
              <img src="{{ $product->image }}" alt="{{ $product->name }}">
            </div>
          <h1 class="text-center mt-3 mb-3">
            書名:{{ $product->name }}
          </h1>
          <hr>
          <h1 class="text-center text-danger mt-3 mb-3">
                價錢:＄{{ $product->price }}
         </h1>
         <hr>
          <div class="topic-body mt-4 mb-4">
            {!! $product->content !!}
          </div>

          @can('update', $product)
          <div class="operate">
            <hr>
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-outline-secondary btn-sm" role="button">
              <i class="far fa-edit"></i> 編輯
            </a>
            <form action="{{ route('products.destroy', $product->id) }}" method="post"
                style="display: inline-block;"
                onsubmit="return confirm('您確定要刪除嗎？');">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button type="submit" class="btn btn-outline-secondary btn-sm">
              <i class="far fa-trash-alt"></i> 刪除
            </button>
          </form>
        </div>
      @endcan
        </div>
      </div>
    </div>
  </div>
@stop