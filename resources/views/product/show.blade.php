{{-- @php
  if(Auth::check()) {
      $AuthUser = 1;
    }else{
      $AuthUser = 0;
    }
@endphp  --}}
@extends('layouts.basic')

@section('basic')
<link href="{{ asset('css/product/show.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
@endsection

@section('content')
<div class="container product">
  <div class="row">
      <div class="col-xl-6 col-lg-6 col-md-6 left">
          <div class="big-image ">
            <div class="tag-left">&#10094;</div>
             @foreach($product->images as $key => $picture)
             @if($key == 0)
             <img src="{{ url($picture->path) }}" class="image">
               @else 
               <img src="{{ url($picture->path) }}" class="image" style="display:none">
               @endif
             @endforeach
             <div class="tag-right">&#10095;</div>
          </div>
          <div class="small-image">
              @foreach($product->images as $key => $picture) 
              <div class="xsimage">
                  <img src="{{ url($picture->path) }}" class="images w3-opacity w3-hover-opacity-off" onclick="currentDiv({{$key+1}})">
            </div>
              @endforeach
          </div>
      </div>
      {{-- <div class="col-xl-1 center"></div> --}}
      <div class="col-xl-6 col-lg-6 col-md-6 mt-md-0 mt-3 right">
          <div class="product-name">
              <h4 style="text-align:center"><b>{{ $product->name }}</b></h4>

              <hr class="hr-text" data-content="詳細資訊">
              
            <div class="inner-detail">
              <div class="mb-3">     
               <span style="font-size:18px">分類：二手書</span>
               {{-- <span style="font-size:14px;float:right;"><p class="text-muted"> |{{ $product->comment_count }}則留言</p></span>   --}}
               <span style="font-size:14px;float:right;"><p class="text-muted">瀏覽次數：{{ $product->visits()->count() }}</p></span>
              </div>
              <p class="mb-3 mt-2 text-uppercase" style="font-size:18px">ISBN：XXXXXXX</p>
              <p class="mb-3 mt-2" style="font-size:18px;color:#ff5353">二手價：<b style="font-size:22px">NT${{ $product->price }}</b></p>
              <p class="mb-3 mt-2" style="font-size:16px">書況：  {!! $product->content !!}</p>
              <hr>
              <div class="mb-3 mt-2" style="font-size:16px">
                  <p>可付款方式：</p>
                  <div class="row">
                  <div class="col-4">校園面交</div>
                  <div class="col-4">LINE PAY</div>
                  <div class="col-4">街口支付</div>
                  </div>
              </div>
              <hr>
              <div class="mt-2">
                  <p style="font-size:16px">適用課程:</p>
                  <div class="row classname">
                     @foreach ($product->tags as $tag)
                  <div class="col-4 book1">{{$tag->department->name}}</div>
                     @endforeach
                  </div>   
              </div>
               @if($product->user->id!==Auth::id())     
              <hr class="hr-text" data-content="決定一下吧！">
              <div><button type="button" class="btn save"><i class="far fa-heart pr-2"></i>加入收藏</button></div>
              <div><button type="button" class="btn cart"><i class="fas fa-shopping-cart pr-2"></i>加入購物車</button></div>
              <div class="mt-2"><button type="button" class="btn buy">立即購買</button></div>
              @endif
              @can('update', $product)
              <hr class="hr-text" data-content="賣家操作">
             <div class="operate">
              <a href="{{ route('products.edit', $product->id) }}" class="btn btn-outline-dark" role="button">
                <i class="far fa-edit"></i> 編輯
              </a>
            <form action="{{ route('products.destroy', $product->id) }}" method="post"
                style="display: inline-block;"
                onsubmit="return confirm('您確定要刪除嗎？');">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" class="btn btn-outline-danger ml-3">
                  <i class="far fa-trash-alt"></i> 刪除
                </button>
              </form>
              </div>
               @endcan
             </div>
          </div>
      </div>
      <div class="col-lg-12 col-lg-12 col-md-12 mt-3 user">
       <div class="user-data">
        <div class="user-avatar">
          <img src="{{ $product->user->avatar }}"/>
        </div>
        <div class="user-name">
          <p>賣家:{{ $product->user->name }}</p>
          <p class="text-muted">x小時前上線</p>
        </div>
        <div class="user-contact">
            <a href="{{route('users.show', $product->user->id) }}" class="btn btn-outline-dark" role="button">
                <i class="fas fa-house-user pr-2"></i>賣家資訊
              </a>
              <a href="{{ route('products.edit', $product->id) }}" class="btn btn-outline-success mt-1" role="button">
                  <i class="fas fa-sms pr-1"></i> 立即聯絡
                </a>  
              </div>
       </div>
      </div>
     {{-- <<------留言板------->>  --}}
     <h4 class="mt-3">買賣回答</h4>
      {{-- <div class="col-lg-12 col-lg-12 col-md-12 card mt-3 product-comment">
          <div class="card-body">
              @include('product.comment_list', ['comments' => $product->comments()->with('user')->get()])
              @includeWhen(Auth::check(), 'product.comment_box', ['product' => $product])
          </div>
      </div>  --}}
      <div class="col-lg-12 col-lg-12 col-md-12 card mt-3 product-comment">
          <div class="card-body">
          <comment-board 
          :_comments="{{$product->comments()->with('user')->get()}}" 
          :product_data="{{$product}}" :auth="{{Auth::check()?Auth::user():0}}"
           >
         </comment-board>
          </div>
      </div> 

  </div>  
</div>   

@endsection

@section('script')
<script>
currentDiv(1);
function currentDiv(n) {
  showDivs(slideIndex = n);
}

function showDivs(n) {
  var i;
  var x = document.getElementsByClassName("image");
  var dots = document.getElementsByClassName("images");
  if (n > x.length) {slideIndex = 1}
  if (n < 1) {slideIndex = x.length}
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" w3-opacity-off", "");
  }
  x[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " w3-opacity-off";
}
</script>

@endsection