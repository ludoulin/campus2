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
                <h4 class="title" style="text-align:center"><b>{{ $product->name }}</b></h4>
                <hr class="hr-text" data-content="詳細資訊"> 
                <div class="inner-detail">
                    <div class="mb-3">
                        <span>商品狀態： 
                                <span class="badge
                                        @if($product->status===0)
                                            badge-secondary
                                        @elseif($product->status===1)
                                            badge-success
                                        @elseif($product->status===2)
                                            badge-info
                                        @elseif($product->status===3)
                                            badge-danger
                                        @endif ">
                                        {{Product::PRODUCT_STATUS[$product->status]}}
                                </span>  
                        </span>
                        <span style="float:right;"><p class="text-muted">瀏覽次數：{{ $product->visits()->count() }}</p></span>
                    </div>
                    <div class="d-flex flex-column mb-3">
                      <span class="mb-3">種類：
                            <span class="badge
                                    @if($product->type===1)
                                        badge-secondary
                                    @elseif($product->type===2)
                                        badge-success
                                    @elseif($product->type===3)
                                        badge-primary
                                    @endif ">
                                {{Product::PRODUCT_TYPES[$product->type]}}
                            </span>  
                      </span>  
                    @if(!empty($product->isbn))  
                      <span class="mb-3 text-uppercase">ISBN：{{$product->isbn}}</span>
                    @endif
                    @if(!empty($product->author))  
                        <span class="mb-3 text-uppercase">作者：{{$product->author}}</span>
                    @endif
                        <span class="mb-3">課程分類：
                                <span class="badge
                                    @if($product->course_type===1)
                                            badge-primary
                                    @elseif($product->course_type===2)
                                            badge-success
                                    @elseif($product->course_type===3)
                                            badge-info
                                    @elseif($product->course_type===4)
                                            badge-danger
                                    @elseif($product->course_type===5)
                                            badge-secondary        
                                    @endif ">
                                    {{Product::COURSE_TYPES[$product->course_type]}}
                                </span>  
                        </span>
                        <span class="mb-3" style="color:#ff5353">二手價：<b style="font-size:22px">NT${{ $product->price }}</b></span>
                        <span class="mb-3">書況：{!! $product->content !!}</span>
                    </div>    
                    <hr>
                    <div class="mb-3 mt-2" style="font-size:16px">
                        <p>可付款方式：</p>
                            <div class="row">
                            @foreach($product->user->payment_types as $type)
                                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
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
                        <p>適用系所:</p>
                            <div class="row">
                                @foreach ($product->tags as $index => $tag)
                                   @if($index<=2)
                                   <div class="col-xl-3 col-lg-3 col-md-4 col-6 mt-3">
                                        <div class="mdc-chip mr-1" role="row" style="color:#6129d6;background-color:#dfd4f7">
                                            <div class="mdc-chip__ripple"></div>
                                            <span role="gridcell">
                                                <span role="button" tabindex="0" class="mdc-chip__primary-action">
                                                     <span class="mdc-chip__text">
                                                         {{$tag->name}}
                                                    </span>
                                                </span>
                                            </span>
                                        </div>     
                                  </div>
                                  @else
                                  <div class="col-xl-3 col-lg-3 col-md-4 col-6 mt-3"> 
                                      <div class="mdc-chip mr-1" role="row" style="color:#6129d6;background-color:#dfd4f7" data-departments="{{$product->tags}}" onclick="SeeMore(this)" >
                                          <div class="mdc-chip__ripple"></div>
                                              <span role="gridcell">
                                                    <span role="button" tabindex="0" class="mdc-chip__primary-action">
                                                         <span class="mdc-chip__text">
                                                                查看全部({{count($product->tags)}})
                                                        </span>
                                                    </span>
                                            </span>
                                      </div>    
                                  </div>
                                  @break
                                  @endif
                            @endforeach
                        </div>
                    </div>
                    @if($product->user->id!==Auth::id())     
                    <hr class="hr-text" data-content="決定一下吧！">
                    <favorite-button :login="{{ Auth::check() ? 1 : 0 }}" :product={{ $product->id }} :status={{ $product->status }} :favorited={{ !$product->favorited->isEmpty() ? 'true' : 'false' }}></favorite-button>
                    <div>
                        <cart-button
                            :product={{ $product->id }}
                            :status={{ $product->status }}
                            :carted={{ !$product->carted->isEmpty() ? 'true' : 'false' }}>
                        </cart-button>
                    </div>
                    <div class="mt-2">
                        <form action="{{route('checkout.payment')}}" name="pay_product" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                            <input id="p_d" name="p_d" type="hidden" value="{{$product->id}}" autocomplete="off">
                              @csrf
                            <button type="submit" class="btn buy" {{$product->status!==1 ?'disabled':''}} >立即購買</button>
                        </form>
                    </div>
                    @endif
                    @can('update', $product)
                    <hr class="hr-text" data-content="賣家操作">
                        <div class="operate d-flex justify-content-center">
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-lg btn-outline-dark" role="button">
                                <i class="far fa-edit"></i> 編輯
                            </a>
                        <a href="javascript:void(0)" class="btn btn-lg btn-outline-danger ml-3" data-product="{{$product->id}}" onclick="DeleteConfirm(this)">
                                <i class="far fa-trash-alt"></i> 刪除
                            </a>
                        </div>
                    @endcan
                </div>
            </div>
          </div>
          <div class="col-lg-12 col-md-12 col-sm-12 col-12 mt-3 user">
              <div class="user-data">
                  <div class="user-avatar">
                        <a href="javascript:void(0);">
                            <img src="{{ $product->user->avatar }}"/>
                        </a>
                  </div>
                  <div class="user-name">
                      <p>賣家:{{ $product->user->name }}</p>
                      <p class="text-muted">{{$product->user->last_actived_at->diffForHumans()}}上線</p>
                  </div>
                  <div class="d-flex justify-content-center user-contact min-user-contact">
                      <a href="{{route('users.show', $product->user->id) }}" class="btn btn-outline-dark" role="button">
                          <i class="fas fa-house-user pr-1"></i>賣家資訊
                      </a>
                      <a href="{{ route('products.edit', $product->id) }}" class="btn btn-outline-success" role="button">
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

function SeeMore(el){

    swal.fire({
        icon:'info',
        width:'80rem',
        title: '適用系所',
        html:`<div class="container">
                <div class="department-row row">
            
                </div>
            </div>`,
        confirmButtonText: '確認',

        didOpen:() => {

            $.each($(el).data().departments, function(key, value){
 
            $('.department-row').append(`<div class="col-lg-3 col-md-4 col-sm-12 col-12"><h2><span class="badge badge-pill badge-info text-white">${value.name}</span></h2></div>`);
 
            });

        },
        didClose:() => {

            $('.department-row').empty();

        }
    })    

    return
}     

function DeleteConfirm(el){

    swal.fire({
                icon:  'warning',
                width:  '50rem',
                title: `確定要刪除這個商品嗎?`,
                html: ` <p class="text-danger"><b>提醒:若是刪除商品,商品將從平台上移除</b></p>
                        <form id="DeleteProduct" name="DeleteProduct" method="POST">
                        @method('DELETE')
                        @csrf
                        </form>`,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: '確定',
                cancelButtonText: '取消',
                showCancelButton: true,
                focusConfirm: false,
                allowOutsideClick: false,  
                didOpen:() => {
                    let url = '{{route("products.destroy",":id")}}';
                    url = url.replace(':id',$(el).data().product);
                    document.getElementById("DeleteProduct").action = url;
                }
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById("DeleteProduct").submit();
                }
            })
    return
}
</script>

@endsection






                            