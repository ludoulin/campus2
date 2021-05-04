@php
    use App\Models\Product;
@endphp

@extends('layouts.basic')

@section('basic')
<link href="{{ asset('css/product/show.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
@endsection

@section('content')
<div class="container my-3 product">
    <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-6 left">
            @foreach($product->images as $key => $picture)
                <div class="big-image">
                <img src="{{ url($picture->path) }}" id="picture_{{$key}}" alt="圖片{{$key}}" onclick="showModal(this)">
                </div>
            @endforeach
            <div id ="ImgModal" class="modal">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <img class="modal-content" id="modal-image">
                    <div id="modal-caption"></div>
            </div>     
            <div class="prev" onclick="plusDiv(-1)">&#10094;</div>
            <div class="next" onclick="plusDiv(1)">&#10095;</div>

            <div class="caption-container">
                <p id="caption" style="margin-top:10px"></p>
            </div>    
            
            <div class="row image-row">
                  @foreach($product->images as $key => $picture) 
                    <div class="small-image">
                        <img src="{{ url($picture->path) }}" class="demo cursor" alt="圖片{{$key+1}}" onclick="currentDiv({{$key+1}})">
                    </div>
                  @endforeach
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6 mt-md-0 mt-3 right">
            <div class="product-name">
                <h4 style="text-align:center"><b>{{ $product->name }}</b></h4>
                <hr class="hr-text" data-content="詳細資訊"> 
                <div class="inner-detail">
                    <div class="mb-3">     
                        <span style="font-size:18px">種類：{{Product::PRODUCT_TYPES[$product->type]}}</span>
                        <span style="font-size:14px;float:right;"><p class="text-muted">瀏覽次數：{{ $product->visits()->count() }}</p></span>
                    </div>
                    @if(!empty($product->isbn))  
                      <p class="mb-3 mt-2 text-uppercase" style="font-size:18px">ISBN：{{$product->isbn}}</p>
                    @endif
                    @if(!empty($product->author))  
                      <p class="mb-3 mt-2 text-uppercase" style="font-size:18px">作者：{{$product->author}}</p>
                    @endif
                    <p class="mb-3 mt-2 text-uppercase" style="font-size:18px">課程分類：{{Product::COURSE_TYPES[$product->course_type]}}</p>
                    <p class="mb-3 mt-2" style="font-size:18px;color:#ff5353">二手價：<b style="font-size:22px">NT${{ $product->price }}</b></p>
                    <p class="mb-3 mt-2" style="font-size:16px">書況：{!! $product->content !!}</p>
                    <hr>
                    <div class="mb-3 mt-2" style="font-size:16px">
                        <p>可付款方式：</p>
                            <div class="row">
                            @foreach($product->user->payment_types as $type)
                                <div class="col-3">
                                    <h3>
                                        <span class="badge
                                                @if($type->id===1)
                                                    badge-primary
                                                @elseif($type->id===2)
                                                    badge-success
                                                @elseif($type->id===3)
                                                    badge-secondary
                                                @endif ">
                                                {{$type->name}}
                                        </span>  
                                    <h3>
                                </div>
                              @endforeach  
                          </div>
                    </div>
                    <hr>
                    <div class="mt-2">
                        <p style="font-size:16px">適用系所:</p>
                            <div class="row">
                                @foreach ($product->tags as $tag)
                                   <div class="col-3">
                                        <h3>
                                          <span class="badge badge-pill badge-info text-white">
                                            {{$tag->department->name}}
                                        </span>
                                        <h3>   
                                  </div>
                                @endforeach
                            </div>   
                    </div>
                    @if($product->user->id!==Auth::id())     
                    <hr class="hr-text" data-content="決定一下吧！">
                    <favorite-button :login="{{ Auth::check() ? 1 : 0 }}" :product={{ $product->id }} :favorited={{ !$product->favorited->isEmpty() ? 'true' : 'false' }}></favorite-button>
                    <div>
                        <button type="button" class="btn cart">
                            <i class="fas fa-shopping-cart pr-2"></i>加入購物車
                        </button>
                    </div>
                    <div class="mt-2">
                        <form action="{{route('checkout.payment')}}" name="pay_product" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                            <input id="p_d" name="p_d" type="hidden" value="{{$product->id}}" autocomplete="off">
                              @csrf
                            <button type="submit" class="btn buy">立即購買</button>
                        </form>
                    </div>
                    @endif
                    @can('update', $product)
                    <hr class="hr-text" data-content="賣家操作">
                        <div class="operate">
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-outline-dark" role="button">
                                <i class="far fa-edit"></i> 編輯
                            </a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="post" style="display: inline-block;" onsubmit="return DeleteConfirm('您確定要刪除嗎？');">
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
                      <p class="text-muted">{{$product->user->last_actived_at->diffForHumans()}}上線</p>
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
          <div class="col-lg-12 col-lg-12 col-md-12 card mt-3 product-comment">
              <div class="card-body">
                <comment-board 
                :_comments="{{$product->comments()->with(['user','replies'=> function($query){$query->with("user");}])->get()}}" 
                :product_data="{{$product}}" :auth="{{Auth::check()?Auth::user():0}}">
                </comment-board>
              </div>
          </div> 
      </div> 
</div>   

@endsection

@section('script')
<script>

$(function(){
    init();
})

function init(){

    showDivs(slideIndex = 1);
} 

function showModal(el){
    console.log($(el));
    document.getElementById("ImgModal").style.display = "block";
    document.getElementById("modal-image").src = $(el)["0"].currentSrc;
    document.getElementById("modal-caption").innerHTML = $(el)["0"].alt
}

function closeModal(){

document.getElementById("ImgModal").style.display = "none";

}


function plusDiv(n){
    showDivs(slideIndex += n)
}

function currentDiv(n) {
  showDivs(slideIndex = n);
}

function showDivs(n) {
  let i;
  let slides = document.getElementsByClassName("big-image");
  let dots = document.getElementsByClassName("demo");
  let numberText = document.getElementById("caption");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
  numberText.innerHTML = dots[slideIndex-1].alt;
}

function DeleteConfirm(title){

  let check = false;

    swal.fire({
              title: title,
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#DD6B55',
              confirmButtonText: '確定',
              cancelButtonText: '取消',
              }).then((result) => {
                    if (result.isConfirmed) {
                        check = true;
                 }
              });
  return check;
}
</script>

@endsection