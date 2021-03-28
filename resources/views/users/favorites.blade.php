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
                               <h2><span class="product-seller badge badge-primary">賣家:{{ $myfavorite->user->name }}</span></h2>
                             </div>
                             <div p1-0 class="col-sm-6">
                                <div class="d-flex list-product-action justify-content-center">
                                    <a href="{{route('products.show', $myfavorite->id)}}" class="btn bg-primary mr-2">
                                        商品資訊
                                      </a> 
                                    {{-- <a href="javascript:void(0)" class="btn btn-success">
                                        立即購買
                                  </a>  --}}
                                  <form action="{{route('checkout.payment')}}" name="pay_product" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                                    <input id="p_d" name="p_d" type="hidden" value="{{$myfavorite->id}}" autocomplete="off">
                                    @csrf
                                    <button type="submit" class="btn btn-success">立即購買</button>
                                    </form>
                                </div> 
                             </div> 
                           </div> 
                        </div>   
                      </div>
                    </li>
                    @empty
                    <div class="alert alert-primary" role="alert">
                        <h4 class="alert-heading">您目前沒有收藏任何二手書喔！！</h4>
                    </div>
                    @endforelse 
                 </ul> 
               </div>  
         </div>  
      </div>
  </div>
</div>
@endsection
