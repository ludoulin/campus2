@extends('layouts.basic')

@section('basic')
<link href="{{ asset('css/user/favorite.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="check-content container-fluid">
   <div class="row">
      <div class="col-sm-12"> 
         <div class="wish-card">
            <div class="wish-card-header d-flex justify-content-between card-border-bottom mb-0">
               <div class="wish-card-header-title">
                  <h4 class="card-title">收藏商品</h4>
               </div>
            </div>
               <div class="card-body wish-card-body">
                 <ul class="list-inline p-0 m-0">
                    @forelse ($myfavorites as $myfavorite)  
                    <li class="checkout-product">
                      <div class="row align-items-center">
                        <div class="col-sm-3 col-lg-2">
                          <div class="row align-items-center"> 
                              <div class="col-sm-3">
                                <my-favorite :product={{ $myfavorite->id }}></my-favorite> 
                              </div>
                              <div class="col-sm-9">
                                 <span class="checkout-product-img">
                                    <a href="{{route('products.show', $myfavorite->id)}}">
                                       <img src="{{asset($myfavorite->images[0]->path)}}" alt class="img-fluid rounded">
                                    </a>   
                                 </span>
                              </div>     
                          </div>
                        </div>
                        <div class="col-sm-3 col-lg-4">
                           <div class="checkout-product-details">
                             <h5>{{ $myfavorite->name }}</h5>
                             @if($myfavorite->is_stock)
                             <p class="text-success">有現貨</p>
                             @else
                             <p class="text-success">已下架</p>
                             @endif
                             <div class="price">
                               <h5>{{ $myfavorite->price }}</h5>
                             </div> 
                           </div>  
                        </div>
                        <div class="col-sm-6 col-lg-6">
                           <div class="row">
                             <div class="col-sm-6">
                               <span class="product-seller">賣家:{{ $myfavorite->user->name }}</span>
                             </div>
                             <div p1-0 class="col-sm-6">
                                <div class="flex align-items-center list-product-action">
                                    <a href="{{route('products.show', $myfavorite->id)}}" class="btn bg-primary">
                                        商品資訊
                                      </a> 
                                    <a href="javascript:void(0)" class="btn btn-success">
                                        立即購買
                                  </a> 
                                </div> 
                             </div> 
                           </div> 
                        </div>   
                      </div>
                    </li>
                    @empty
                    <p>您沒有收藏商品</p>
                    @endforelse 
                 </ul> 
               </div>  
         </div>  
      </div>
  </div>
</div>
@endsection


{{-- <div class="container mt-3">
    <h2 class="mb-3"><i class="fas fa-heart pr-2"></i>我的收藏 ({{$myfavorites->count()}})</h2>
        <div class="row">
                @forelse ($myfavorites as $myfavorite)    
          <div class="col-md-6 col-lg-4 g-mb-30">
            <article class="u-shadow-v18 g-bg-white text-center rounded g-px-20 g-py-40 g-mb-5">
            <img class="img mb-4" src="{{asset($myfavorite->images[0]->path)}}" alt="Image Description">
            <h3 class="h5 g-color-black g-font-weight-600 g-mb-10">{{ $myfavorite->name }}</h3>
                    <span class="d-block g-color-primary g-font-size-16 g-mb-5">${{ $myfavorite->price }}</span>
                    <hr>
                    <div class="feature">
                      <div class="row">
                        <div class="col-lg-4 col-md-4">   
                         <a href="{{route('products.show', $myfavorite->id)}}" class="btn btn-outline-primary"><i class="fas fa-info-circle pr-2"></i>商品資訊</a>
                        </div>
                        <div class="col-lg-3 col-md-3">  
                         <a href="" class="btn btn-outline-success"><i class="far fa-handshake pr-2"></i>購買</a>
                        </div>
                        <div class="col-lg-5 col-md-5">  
                        <my-favorite :product={{ $myfavorite->id }}></my-favorite>
                        </div>
                      </div>
                    </div>
                  </article>
                </div>
                @empty
                <p>您沒有收藏商品</p>
                @endforelse
            </div>
    </div>             --}}