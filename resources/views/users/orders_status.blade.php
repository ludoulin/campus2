@php
    use App\Models\Order;
@endphp

@extends('layouts.basic')

@section('basic')
<link href="{{ asset('css/user/status.css') }}" rel="stylesheet">
@endsection

@section('title', $user->name . '的商品訂單狀態查詢')

@section('content')

@if(!$orders->isEmpty())
@foreach($orders as $order)
<div class="check-content container-fluid">
        <div class="row">
           <div class="col-sm-12"> 
              <div class="status-card">
                 <div class="status-card-header d-flex justify-content-between card-border-bottom mb-0">
                    <div class="status-card-header-title">
                        <h4 class="card-title">訂單編號:{{$order->order_number}}</h4>
                    </div>
                    <div class="status-header-toolbar d-flex flex-column justify-content-center">
                            <h5>
                                <div class="alert alert-warning" role="alert">
                                    @if($order->payment_type_id===1)
                                    請注意若使用面交時付款，只有在訂單狀態為『 待賣家確認 』才能自動取消訂單
                                    @elseif($order->payment_type_id===2)
                                    請注意使用LinePay付費，在『 已付費 』的狀態若想取消訂單需要向賣家申請
                                    @endif
                                </div>
                            </h5>
                    </div>
                 </div>
                    <div class="card-body status-card-body">
                        <div class="row">
                            <div class="col-sm-7">
                                 <ul class="list-inline p-0 m-0">  
                                    @foreach ($order->items as $item)
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
                                                <li><h4 class="summary-title summary-product-total">訂單總計:<span class="total-pricing"><span class="badge bg-salmon">$ {{$order->price_total}}元</span></span></h4></li>
                                                <li><h4 class="summary-title order-status">付費方式:<span class="p-status"><span class="badge badge-primary">{{$order->payment_type->name}}</span></span></h4></li>
                                                <li><h4 class="summary-title payment-status">
                                                        目前付款狀態:
                                                        <span class="p-status">
                                                            <span class="badge 
                                                                        @if($order->payment_status==0)
                                                                        badge-secondary
                                                                        @elseif($order->payment_status==1)
                                                                        badge-primary
                                                                        @elseif($order->payment_status==2)
                                                                        badge-danger
                                                                        @endif">
                                                            {{Order::PaymentStatus[$order->payment_status]}}
                                                            </span>                                                                      
                                                        </span>
                                                    </h4>
                                                </li> 
                                                <li>
                                                    <h4 class="summary-title order-status">目前訂單狀態:
                                                        <span class="o-status">
                                                            <span class="badge 
                                                                        @if($order->status===0)
                                                                        badge-secondary
                                                                        @elseif($order->status===1)
                                                                        badge-primary
                                                                        @elseif($order->status===2)
                                                                        badge-success
                                                                        @elseif($order->status===3||$order->status===6)
                                                                        badge-danger
                                                                        @elseif($order->status===4)
                                                                        badge-info text-white
                                                                        @elseif($order->status===5)
                                                                        badge-secondary text-white
                                                                        @endif">
                                                                {{ Order::Status[$order->status] }}
                                                            </span>
                                                        </span>
                                                    </h4>
                                                </li>
                                                <li><h4 class="summary-title order-status">預計面交日期:<span class="o-status"><span class="badge badge-dark">{{$order->face_time}}</span></span></h4></li>       
                                            </ul>
                                        </div>
                                        <hr/>
                                        <div class="checkout-submit">

                                            @if($order->payment_type_id === 1)

                                                @if($order->status === 0)
                                                    <a href="javascript:void(0)" onclick="Order(this)" data-order="{{$order}}" class="btn btn-lg bg-red text-white float-right">
                                                         <i class="far fa-trash-alt pr-2"></i>
                                                                取消訂單
                                                    </a>
                                                @elseif($order->status === 1)
                                                    <a href="javascript:void(0)" onclick="Apply(this)" data-order="{{$order->id}}" class="btn btn-lg btn-outline-danger float-right">
                                                            <i class="fas fa-trash-restore pr-2"></i>
                                                              申請取消訂單
                                                    </a> 
                                                @elseif($order->status === 5)
                                                    <div class="alert alert-secondary text-center" role="alert">因賣家長時間沒確認定狀態,系統已自動取消此筆訂單</div>  
                                                @else     
                                                <div class="alert alert-primary text-center" role="alert">目前的狀態沒有任何操作可以使用</div>
                                                 
                                                @endif

                                            @elseif($order->payment_type_id === 2)

                                                @if(!$order->line_pay_record->is_comfirm)
                                                  <!--付款-->
                                                    <a href="javascript:void(0)" onclick="Payment(this)" data-order="{{Crypt::encrypt($order->id)}}" class="btn btn-lg btn-success text-white float-right">
                                                        <i class="fas fa-check-circle pr-2"></i>
                                                            LinePay付款
                                                    </a>
                                                @elseif(!$order->line_pay_record->is_refund && $order->line_pay_record->is_confirm && $order->status === 3 )
                                                  <!--退款-->
                                                    <a href="javascript:void(0)" onclick="Refund(this)" data-order="{{Crypt::encrypt($order->id)}}" class="btn btn-lg btn-danger text-white float-right">
                                                        <i class="far fa-trash-alt pr-2"></i>
                                                            退款
                                                    </a>
                                                @endif
                                                  <!--取消訂單-->
                                                @if($order->status === 0 && !$order->line_pay_record->is_confirm)
                                                    <a href="javascript:void(0)" onclick="Order(this)" data-order="{{$order}}" class="btn btn-lg bg-red text-white float-right">
                                                        <i class="far fa-trash-alt pr-2"></i>
                                                                     取消訂單
                                                    </a>
                                                @elseif($order->line_pay_record->is_confirm && !$order->status > 2)
                                                    <a href="javascript:void(0)" onclick="Apply(this)" data-order="{{$order}}" class="btn btn-lg btn-outline-danger float-right">
                                                            <i class="fas fa-trash-restore pr-2"></i>
                                                                    申請取消訂單
                                                    </a>
                                                @elseif($order->status === 5)
                                                    <div class="alert alert-secondary text-center" role="alert">因賣家長時間沒確認定狀態系統已自動取消此筆訂單</div>  
                                                @else     
                                                <div class="alert alert-primary text-center" role="alert">目前的狀態沒有任何操作可以使用</div>    
                                                @endif

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

 {{-- @include('orders.DeleteOrderModel') --}}

@else 

<div class="alert alert-primary" role="alert">
        <h4 class="alert-heading">目前沒有任何訂單喔！！</h4>
    </div>

@endif
      
@endsection

@section('FrontEnd_Script')  


<script>

$(function(){

    swal.fire({
        title: '提醒',
        icon: 'info',
        text:"請確認各訂單狀態,以免漏掉各訂單的最新動態",
        confirmButtonColor: '#38c172',
        confirmButtonText: '知道了',
        showConfirmButton: true
        });

});

function Order(el){

    swal.fire({
                icon:  'warning',
                width:  '50rem',
                title: `確定要取消${$(el).data().order.order_number}這筆訂單嗎?`,
                html: ` <p class="text-danger"><b>提醒:若是取消此筆訂單,此筆訂單將會失效</b></p>
                        <form id="DeleteOrder" name="DeleteOrder" method="POST">
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

                    let url = '{{route("order.destroy",":id")}}';

                    url = url.replace(':id',$(el).data().order.id);

                    document.getElementById("DeleteOrder").action = url;

                }
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById("DeleteOrder").submit();
                    }
                })

    return


}

function RefuseDetail(el){

swal.fire($(el).data().reason);

return
}

function Apply(el){
    swal.fire({
                title: '申請取消訂單',
                html: `<form id="swalForm" method="POST" action="{{route('order.apply')}}">
                        @csrf
                        <input type="hidden" id="ord" class="swal2-input" name="ord_hash" value="${$(el).data().order}">
                        <textarea id="textarea" class="swal2-textarea" name="order_cancel" placeholder="請填寫取消理由"></textarea>
                        </form>`,
                confirmButtonText: '確認',
                cancelButtonText: '取消',
                showCancelButton: true,
                focusConfirm: false,
                allowOutsideClick: false,  
                preConfirm: () => {
                    const order = swal.getPopup().querySelector('#ord').value
                    const textarea = swal.getPopup().querySelector('#textarea').value
                    
                    if (!order||!textarea) {

                        return swal.showValidationMessage(`請一定要填寫欄位`)

                    }
                    if (order!=$(el).data().order) {

                       return swal.showValidationMessage(`請不要惡意操作`)

                    }else if(textarea.trim()>100){

                        return swal.showValidationMessage(`取消理由不能超過一百字`)

                    }

                    return { textarea:textarea, order:order }
                }
                }).then((result) => {
                    if (result.isConfirmed) {
                    document.getElementById("swalForm").submit();
                    }
                })

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


{{-- $('#btn-OrderDelete-modal').modal('show');
    
    let form = document.getElementById("DeleteOrder");

    let url = '{{route("order.destroy",":id")}}';

    $(".delete-body .order-number").text($(el).data().order.order_number);

    url = url.replace(':id',$(el).data().order.id);

    form.action = url; --}}