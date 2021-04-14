@extends('layouts.basic')

@section('basic')
<link href="{{ asset('css/user/status.css') }}" rel="stylesheet">
@endsection

@section('title', $user->name . '的商品訂單狀態查詢')

@section('content')

@if(!$user->orders->isEmpty())
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
                    @if($order->status==="待賣家確認" && $order->payment_type_id===1)
                    <div class="status-header-toolbar d-flex flex-column justify-content-center">
                            <h5 class="mt-2">＊請注意若使用面交時付款，只有在訂單狀態為『待賣家確認』才能取消訂單</h5>
                            <a href="javascript:void(0)" onclick="Order(this)" data-order="{{$order}}" class="btn bg-red text-white"><i class="far fa-trash-alt pr-2"></i>取消訂單</a>
                    </div>
                    @elseif(($order->status==="待賣家確認" || $order->status==="賣家已確認" && $order->payment_type_id===2)&& $order->line_pay_record->is_confirm)
                    <div class="status-header-toolbar d-flex flex-column justify-content-center">
                         <h5 class="mt-2">＊請注意若使用LinePay付費，一旦和『賣家交書』後就不能退款和取消訂單</h5>
                         <a href="javascript:void(0)" onclick="Refund(this)" data-order="{{Crypt::encrypt($order->id)}}" class="btn btn-danger text-white"><i class="far fa-trash-alt pr-2"></i>退款並取消訂單</a>
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
                                        <hr/>
                                        <div class="checkout-submit">
                                            @if(!$order->line_pay_record->is_payment_reply && !$order->line_pay_record->is_confirm)
                                            <a href="javascript:void(0)" onclick="Payment(this)" data-order="{{Crypt::encrypt($order->id)}}" class="btn btn-success text-white float-right"><i class="fas fa-check-circle pr-2"></i>LinePay付款</a>
                                            @endif
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
@else 

<div class="alert alert-primary" role="alert">
        <h4 class="alert-heading">目前沒有任何訂單喔！！</h4>
    </div>

@endif
      
@endsection

@section('script')  


<script>

$(function(){


 let redirect_url = new URL(window.location);

 if(redirect_url.searchParams.has("transactionId")){

    swal.fire({
        title: '提醒',
        icon: 'info',
        html:'<p>請再次確認你剛才付款的訂單<br><div>並按下<a href="javascript:void(0)" class="btn btn-success text-white ml-2 mr-2"><i class="fas fa-check-circle pr-2"></i>付款狀態確認</a>的按鈕</div><br>確認付款完全成功</p>',
        confirmButtonColor: '#38c172',
        confirmButtonText: '知道了',
        showConfirmButton: true
        });
 }else{

    swal.fire({
        title: '提醒',
        icon: 'info',
        text:"請確認各訂單狀態,以免漏掉各訂單的最新動態",
        confirmButtonColor: '#38c172',
        confirmButtonText: '知道了',
        showConfirmButton: true
        });

 }

});

function Order(el){

    $('#btn-OrderDelete-modal').modal('show');
    
    let form = document.getElementById("DeleteOrder");

    let url = '{{route("order.destroy",":id")}}';

    $(".delete-body .order-number").text($(el).data().order.order_number);

    url = url.replace(':id',$(el).data().order.id);

    form.action = url;

    return

}

function Payment(el){

    
    MessageObject.Waiting("確認中,請稍後");

    $.ajax({
        type: "POST",
        url: '{{route('linepay.payment')}}',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            package:$(el).data().order,
        }, 
        success: function(response){

           console.log(response);
           
           swal.close();

           if(response.returnCode==="0000"){

            swal.fire({
                        icon:'success',
                        title: '確認成功',
                        text:'準備前往付款頁面',
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: () => {
                                         swal.showLoading();
                                        },
                        willClose: () => {
                                         window.location = response.info.paymentUrl.web
                                         }
                    });
            
            }

            return true

            },
            error: function (error) {

            MessageObject.VaildSubmitMessage("發生錯誤","付款失敗");

            return false

            }       
      });

}

function Refund(el){

    
MessageObject.Waiting("退款中,請稍後");

$.ajax({
    type: "POST",
    url: '{{route('linepay.refund')}}',
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data: {
        package:$(el).data().order,
    }, 
    success: function(response){

       console.log(response);
       
       swal.close();

       if(response.returnCode==="0000"){

        swal.fire({
                icon: 'success',
                title: '退款已成功！',
                confirmButtonText: '確認',
                allowOutsideClick: false,      
            }).then((result) => {
            if (result.isConfirmed) {
                location.reload();
            }
        });
        
        }

        return true

        },
        error: function (error) {

        MessageObject.VaildSubmitMessage("發生錯誤","退款失敗");

        return false

        }       
  });

}
</script>    
@endsection