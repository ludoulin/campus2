@php
use App\Models\User;  

// $prd = array();

@endphp

@extends('layouts.basic')

@section('basic')
<link href="{{ asset('css/user/cart.css') }}" rel="stylesheet">
@endsection

@section('content')
@guest
    @if(!$datas->isEmpty())
        @foreach($datas as $name => $items)
        <?php $total = 0 ?>
        <?php $prd = array()?>
        <div class="check-content container-fluid">
                <div class="row">
                   <div class="col-sm-12"> 
                      <div class="wish-card">
                         <div class="wish-card-header d-flex justify-content-between card-border-bottom mb-0">
                            <div class="wish-card-header-title">
                             <?php $seller = User::findOrFail($name) ?>
                                <h4 class="card-title">賣家:{{$seller->name}}</h4>
                            </div>
                         </div>
                            <div class="card-body wish-card-body">
                                <div class="row">
                                    <div class="col-sm-7">
                                         <ul class="list-inline p-0 m-0">
                                            @foreach ($items as $item)
                                            <?php $total += $item['price'] ?>  
                                            <?php array_push($prd ,$item["product_id"]) ?>
                                            <li class="checkout-product">
                                                <div class="row align-items-center">
                                                    <div class="col-sm-3 col-lg-2">
                                                        <div class="row align-items-center"> 
                                                            <div class="col-sm-3">
                                                                <a class="btn badge badge-danger remove-from-cart" href="javascript:void(0)" data-id="{{ $item["product_id"] }}"><i class="fas fa-times"></i></a> 
                                                            </div>
                                                            <div class="col-sm-9 mt-2">
                                                                <span class="checkout-product-img">
                                                                    <a href="{{route('products.show', $item["product_id"])}}">
                                                                        <img src="{{asset($item["image"])}}" alt class="img-fluid rounded">
                                                                    </a>   
                                                                </span>
                                                            </div>     
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3 col-lg-4 mt-3">
                                                        <div class="checkout-product-details">
                                                            <h3>書名: {{ $item["name"] }}</h3>
                                                            <div class="price mt-3">
                                                                <h5>單價: ${{ $item["price"] }}元</h5>
                                                            </div> 
                                                            @if($item["is_stock"])
                                                             <p class="text-success">有現貨</p>
                                                            @else
                                                             <p class="text-danger">已下架</p>
                                                            @endif
                                                        </div>  
                                                    </div>
                                                    <div class="col-sm-6 col-lg-6">
                                                        <div class="single-price">
                                                            <span class="price-title">小計: <span>{{ $item["price"] }}</span>元</span>
                                                        </div>    
                                                    </div>   
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                        <div class="col-sm-5 cart">
                                            <div class="cart-summary">
                                                <div class="pricing-summary">
                                                    <ul class="list-unstyled">
                                                        <li class="summary-title">商品小計<span class="pricing"><span class="b-text-prime">{{$total}}</span>元</span></li>
                                                        <li><h3 class="summary-title summary-product-total">訂單總計<span class="total-pricing"><span>$ {{$total}}</span>元</span></h3></li>   
                                                    </ul>
                                                </div>
                                                <div class="checkout-submit">
                                                    <?php $t_ids = collect($prd) ?>
                                                 <form action="{{ route('checkout.index') }}" name="pay_product" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                                                    {{-- <input id="p_type" name="p_type" type="hidden" value="{{$seller->payment_types}}"> --}}
                                                    <input name="p_ids" type="hidden" value="{{$t_ids}}">
                                                    @csrf      
                                                    <button class="btn primary btn-lg btn-block">立即付費</button>
                                                    <a class="btn btn-outline-primary btn-lg btn-block" href="javascript:void(0)">繼續購物</a>
                                                </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                            </div>  
                        </div>  
                   </div>
               </div>
        @endforeach
    @else
    <div class="alert alert-primary" role="alert">
        <h4 class="alert-heading">購物車目前沒有任何二手書商品喔！！</h4>
    </div>
    @endif
@else
@if(!$my->isEmpty())
@foreach($my as $name => $items)
<?php $total = 0 ?>
<?php $prd = array()?>
<div class="check-content container-fluid">
        <div class="row">
           <div class="col-sm-12"> 
              <div class="wish-card">
                 <div class="wish-card-header d-flex justify-content-between card-border-bottom mb-0">
                    <div class="wish-card-header-title">
                            <?php $seller = User::findOrFail($name) ?>
                        <h4 class="card-title">賣家:{{$seller->name}}</h4>
                    </div>
                 </div>
                    <div class="card-body wish-card-body">
                        <div class="row">
                            <div class="col-sm-7">
                                 <ul class="list-inline p-0 m-0">  
                                    @foreach ($items as $item)
                                    <?php $total += $item->price ?>
                                    <?php array_push($prd ,$item->id) ?>
                                    <li class="checkout-product">
                                        <div class="row align-items-center">
                                            <div class="col-sm-3 col-lg-2">
                                                <div class="row align-items-center"> 
                                                    <div class="col-sm-3">
                                                        <a class="btn badge badge-danger remove-from-cart" href="javascript:void(0)" data-id="{{ $item->id }}"><i class="fas fa-times"></i></a> 
                                                    </div>
                                                    <div class="col-sm-9 mt-2">
                                                        <span class="checkout-product-img">
                                                            <a href="{{route('products.show', $item->id)}}">
                                                                <img src="{{asset($item->images[0]->path)}}" alt class="img-fluid rounded">
                                                            </a>   
                                                        </span>
                                                    </div>     
                                                </div>
                                            </div>
                                            <div class="col-sm-3 col-lg-4 mt-3">
                                                <div class="checkout-product-details">
                                                <h3>書名: {{ $item->name }}</h3>

                                                    <div class="price mt-3">
                                                        <h5>單價: ${{ $item->price }}元</h5>
                                                    </div> 
                                                    @if($item->is_stock)
                                                        <p class="text-success">有現貨</p>
                                                    @else
                                                        <p class="text-success">已下架</p>
                                                    @endif
                                                </div>  
                                            </div>
                                            <div class="col-sm-6 col-lg-6">
                                                <div class="single-price">
                                                    <span class="price-title">小計: <span>{{ $item->price }}</span>元</span>
                                                </div>    
                                            </div>   
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                                <div class="col-sm-5 cart">
                                    <div class="cart-summary">
                                        <div class="pricing-summary">
                                            <ul class="list-unstyled">
                                                <li class="summary-title">商品小計<span class="pricing"><span class="b-text-prime">{{$total}}</span>元</span></li>
                                                <li><h3 class="summary-title summary-product-total">訂單總計<span class="total-pricing"><span>$ {{$total}}</span>元</span></h3></li>   
                                            </ul>
                                        </div>
                                        <div class="checkout-submit">
                                          <?php $t_ids = collect($prd) ?>
                                         <form action="{{ route('checkout.index') }}" name="pay_product" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                                            <input name="p_ids" type="hidden" value="{{$t_ids}}">
                                            @csrf      
                                         <button class="btn primary btn-lg btn-block">立即付費</button>
                                            <a class="btn btn-outline-primary btn-lg btn-block" href="javascript:void(0)">繼續購物</a>
                                        </form>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>  
                </div>  
           </div>
       </div>
 @endforeach
 @else
    <div class="alert alert-primary" role="alert">
        <h4 class="alert-heading">購物車目前沒有任何二手書商品喔！！</h4>
    </div>
 @endif
@endguest


@endsection

@section('script')
    <script type="text/javascript">
        $(".remove-from-cart").click(function (e) {
            e.preventDefault();
            var ele = $(this);
            
            swal.fire({
                    title: '確定要將商品從購物車移除嗎?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: '確定!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ url('/remove-from-cart') }}',
                            method: "DELETE",
                            data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id")},
                            success: function (response) {
                                swal.fire(
                                    {
                                    title: '成功移除',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                setTimeout(() => {
                                    location.reload();
                                }, 2000);
                            }
                    });   
                  }
                });
        });
    </script>
@endsection



