@extends('layouts.basic')

@section('basic')
<link href="{{ asset('css/user/status.css') }}" rel="stylesheet">
@endsection

@section('title', $user->name . '的商品訂單狀態查詢')

@section('content')


@foreach($user->orders as $order)
<?php $total = 0 ?>
<div class="check-content container-fluid">
        <div class="row">
           <div class="col-sm-12"> 
              <div class="status-card">
                 <div class="status-card-header d-flex justify-content-between card-border-bottom mb-0">
                    <div class="status-card-header-title">
                        <h4 class="card-title">訂單編號:{{$order->order_number}}</h4>
                    </div>
                    @if($order->status==="待賣家確認")
                    <div class="status-header-toolbar d-flex flex-column justify-content-center">
                            <h5 class="mt-2">＊請注意只有在訂單狀態為『待賣家確認』才能取消訂單</h5>
                            <a href="javascript:void(0)" onclick="Order(this)" data-order="{{$order}}" class="btn bg-red text-white"><i class="far fa-trash-alt pr-2"></i>取消訂單</a>
                    </div>
                    @endif
                 </div>
                    <div class="card-body status-card-body">
                        <div class="row">
                            <div class="col-sm-7">
                                 <ul class="list-inline p-0 m-0">  
                                    @foreach ($order->items as $item)
                                    <?php $total += $item->price ?>
                                    <li class="checkout-product">
                                        <div class="row align-items-center">
                                            <div class="col-sm-3 col-lg-2">
                                                <div class="row align-items-center"> 
                                                    <div class="col-sm-12">
                                                        <span class="checkout-product-img">
                                                            <a href="{{route('products.show', $item->product->id)}}">
                                                                <img src="{{asset($item->product->images[0]->path)}}" alt class="img-fluid rounded">
                                                            </a>   
                                                        </span>
                                                    </div>     
                                                </div>
                                            </div>
                                            <div class="col-sm-3 col-lg-4 mt-3">
                                                <div class="checkout-product-details">
                                                <h3>書名: {{ $item->product->name }}</h3>
                                                    <div class="price mt-3">
                                                        <h5>單價: ${{ $item->price }}元</h5>
                                                    </div> 
                                                </div>  
                                            </div>
                                            <div class="col-sm-6 col-lg-6">
                                                <div class="single-price">
                                                    <span class="badge badge-price-title">賣家: <span>{{ $item->product->user->name }}</span></span>
                                                </div>    
                                            </div>   
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                                <div class="col-sm-5 order">
                                    <div class="order-summary">
                                        <div class="status-summary">
                                            <ul class="list-unstyled">
                                                <li><h4 class="summary-title summary-product-total">訂單總計:<span class="total-pricing"><span class="badge bg-salmon">$ {{$total}}元</span></span></h4></li>
                                                <li><h4 class="summary-title order-status">付費方式:<span class="p-status"><span class="badge badge-primary">{{$order->payment_type->name}}</span></span></h4></li>
                                                <li><h4 class="summary-title payment-status">目前付款狀態:
                                                        <span class="p-status">
                                                            @if($order->payment_status)
                                                            <span class="badge badge-success">已付款</span>
                                                            @else 
                                                            <span class="badge badge-secondary">尚未付款</span>
                                                            @endif
                                                        </span>
                                                    </h4>
                                                </li> 
                                                <li><h4 class="summary-title order-status">目前訂單狀態:<span class="o-status"><span class="badge badge-success">{{ strtoupper($order->status) }}</span></span></h4></li>
                                                <li><h4 class="summary-title order-status">預計面交日期:<span class="o-status"><span class="badge badge-dark">{{$order->face_time}}</span></span></h4></li>       
                                            </ul>
                                        </div>
                                        {{-- <div class="checkout-submit d-flex align-items-end">
                                                <p class="mt-2">＊請注意只有在訂單狀態為『待賣家確認』才能取消訂單</p>
                                                <a href="javascript:void(0)" onclick="Order(this)" data-order="{{$order}}" class="btn bg-red text-white"><i class="far fa-trash-alt pr-2"></i>取消訂單</a>
                                        </div> --}}
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>  
                </div>  
           </div>
       </div>
 @endforeach  

 <div class="modal fade" id="btn-OrderDelete-modal" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
           <form class="modal-content" id="DeleteOrder" name="DeleteOrder" method="POST">
             @method('DELETE')
             @csrf  
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="far fa-trash-alt order-number pr-3">取消訂單</i></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body delete-body">
                <span>確定要取消<span class="font-weight-bold order-number"></span>這筆訂單嗎？</span>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn bg-red">確定</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">離開</button>
            </div>
        </form>
        </div>
      </div>
      
@endsection

@section('script')  


<script>

function Order(el){

    $('#btn-OrderDelete-modal').modal('show');
    
    let form = document.getElementById("DeleteOrder");

    let url = '{{route("order.destroy",":id")}}';

    $(".delete-body .order-number").text($(el).data().order.order_number);

    url = url.replace(':id',$(el).data().order.id);

    form.action = url;

    return

}            
   
</script>    
@endsection