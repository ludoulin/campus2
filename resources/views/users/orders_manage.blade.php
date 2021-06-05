@php
    use App\Models\Order;
@endphp

@extends('layouts.basic')

@section('basic')
<link href="{{ asset('css/order/manage.css') }}" rel="stylesheet">
@endsection

@section('title', $user->name . '的訂單管理')

@section('content')

<div class="container-fluid mt-3">
        <div class="row">
            <div class="col-sm-12">
                <div class="order-manage-card">
                    <div class="order-manage-header d-flex justify-content-between">
                        <div class="order-manage-header-title"> 
                            <h4 class="card-title">訂單管理</h4>
                        </div>
                    </div>
                    <div class="card-body order-manage-body">
                        <div class="table-responsive">
                                <table id="user_orders_table" class="table table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th style="width: 15%">訂單編號</th>
                                                <th style="width: 12%">訂單項目查看</th>
                                                <th style="width: 6%">訂單人</th>
                                                <th style="width: 6%">訂單總額</th>
                                                <th style="width: 6%">訂單項目數</th>
                                                <th style="width: 12%">訂單狀態</th>
                                                <th style="width: 12%">付款狀態</th>
                                                <th style="width: 8%">面交地點</th>
                                                <th style="width: 10%">預計面交時間</th>
                                                <th style="width: 10%">建立時間</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           @foreach($manages as $order)   
                                            <tr role="row">
                                                <td>{{ $order->order_number }}</td>
                                                <td>
                                                    <div class="flex align-items-center list-product-action">
                                                    <a class="btn bg-primary" data-toggle="tooltip" data-placement="top" title="查看訂單項目" data-number="{{$order->order_number}}" data-detail="{{$order->items}}" onclick="OrderDetail(this)" href="javascript:void(0)">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    @if($order->cancel_reason && $order->status === 4)
                                                        <a class="btn btn-success" data-toggle="tooltip" data-placement="top" title="查看買家取消理由" data-reason="{{$order->cancel_reason}}" onclick="ReasonDetail(this)" href="javascript:void(0)">
                                                            <i class="far fa-bookmark"></i>
                                                        </a>
                                                    @endif
                                                    @if($order->status < 3)    
                                                    <a class="btn bg-salmon" data-toggle="tooltip" data-placement="top" data-order="{{$order->id}}" data-status="{{$order->status}}" data-type="{{$types}}" title="變更訂單狀態" onclick="ChangeStatus(this)" href="javascript:void(0)">
                                                            <i class="fas fa-cog" data-toggle="modal"></i>
                                                        </a>    
                                                    @elseif($order->status === 4)
                                                        <a class="btn btn-outline-danger" data-toggle="tooltip" data-placement="top" data-order="{{$order->id}}" title="是否同意取消訂單" onclick="CancelStatus(this)" href="javascript:void(0)">
                                                            <i class="fas fa-reply"></i>
                                                        </a>  
                                                    @endif
                                                    </div>
                                                </td>
                                                <td>{{ $order->first_name }}{{ $order->last_name }}</td>
                                                <td><h3><span class="badge badge-salmon">${{$order->price_total}}</span></h3></td>
                                                <td>{{ $order->item_count }}</td>
                                                <td><h3><span class="badge  
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
                                                                @endif ">
                                                            {{ Order::Status[$order->status] }}
                                                        </span></h3>
                                                </td>
                                                <td> 
                                                    <h3>
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
                                                    </h3>           
                                                </td>
                                                <td>學校</td>
                                                <td>{{$order->face_time}}</td>
                                                <td>{{$order->created_at}}</td>
                                            </tr>
                                            @endforeach
                                    </tbody>
                             </table>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
</div>

@endsection

@section('FrontEnd_Script')
<script>
$(function(){
    $('[data-toggle="tooltip"]').tooltip();

    $("#user_orders_table").DataTable({
        "sDom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"+"<'clear'>",
        "bSort": true,
        "aaSorting": [],
        "oLanguage": {
            "sProcessing": "處理中...",
            "sLengthMenu": "顯示 _MENU_ 項結果",
            "sZeroRecords": "沒有匹配記錄",
            "sInfo": "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
            "sInfoEmpty": "顯示第 0 至 0 項結果，共 0 項",
            "sInfoFiltered": "(從 _MAX_ 項結果過濾)",
            "sSearch": "搜索:",
            "oPaginate": {
                "sFirst": "首頁",
                "sPrevious": "上頁",
                "sNext": "下頁",
                "sLast": "尾頁"
                        }
                    }
                })

 })
function ChangeStatus(el){

    let value = $(el).data().status;
   
    swal.fire({
                icon:  'info',
                width:  '70rem',
                title: `更改訂單狀態`,
                html: ` <form id="ChangeOrderForm" name="ChangeOrder" action="{{route('order.status')}}" method="POST">
                            @csrf
                            <input type="hidden" id="ord_change_hash" name="ord_hash" value="">
                                <div class="d-flex change-status" style="font-size:30px;"> 
                                     
                                </div>     
                                 
                        </form>`,
                confirmButtonText: '確定',
                cancelButtonText: '取消',
                showCancelButton: true,
                focusConfirm: false,
                allowOutsideClick: false,  
                didOpen:() => {

                    $.each($(el).data().type, function(key, value){

                        let style = SetStyle(key);

                        if(key<4){
                         $('.change-status').append(`<div class="custom-control custom-radio flex-fill"><input type="radio" class="custom-control-input necessaryRadio" id="status-${key}" name="status" value="${key}" required><label class="custom-control-label" for="status-${key}"><span class="badge ${style}">${value}<span></label></div>`);
                        }
                    });

                    document.querySelector(`#status-${value}`).checked = true;

                    document.querySelector('#ord_change_hash').value = $(el).data().order;

                },  
                preConfirm: () => {
                    const order = swal.getPopup().querySelector('#ord_change_hash').value

                    if(!radioValidation()){

                       return swal.showValidationMessage(`請一定要勾選`)

                    }

                    if (!order||order!=$(el).data().order) {

                        return swal.showValidationMessage(`不要惡意操作`)
                    }

                    return { order:order }
                }
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById("ChangeOrderForm").submit();
                    }
                })

    return

}
function ReasonDetail(el){

    swal.fire($(el).data().reason);

    return
}
function CancelStatus(el){

    swal.fire({
                icon:  'warning',
                title: '是否同意取消訂單',
                html: ` <p class="text-danger"><b>提醒:若是取消此筆訂單,此筆訂單將會失效</b></p>
                        <form id="CancelForm" method="POST" action="{{route("order.cancel_status")}}">
                        @csrf
                        <input type="hidden" id="hash" class="swal2-input" name="ord_hash" value="${$(el).data().order}">
                        </form>`,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: '同意',
                cancelButtonText: '取消',
                showCancelButton: true,
                focusConfirm: false,
                allowOutsideClick: false,  
                preConfirm: () => {
                    const order = swal.getPopup().querySelector('#hash').value
                    if (!order||order!=$(el).data().order) {
                        swal.showValidationMessage(`不要惡意操作`)
                    }
                    return { order:order }
                }
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById("CancelForm").submit();
                    }
                })

    return

}            

function OrderDetail(el){
    swal.fire({
        icon:'info',
        width:'80rem',
        title: '訂單詳細',
        html:`<p style="font-size:26px">訂單編號 : ${$(el).data().number}</p>
                <div class="table-responsive">
                    <table class="table table-striped" style="width:100%">
                            <thead class="thead-dark" style="text-align: center;">
                              <tr>
                                <th scope="col">項目</th>
                                <th scope="col">二手書圖片</th>
                                <th scope="col">二手書名稱</th>
                                <th scope="col">價錢</th>
                                <th scope="col">下單日期</th>
                              </tr>
                            </thead>
                            <tbody class="item-detail" style="font-size:26px">
                            </tbody>
                     </div>       
                    </table>`,
        confirmButtonText: '確認',

        didOpen:() => {

            $.each($(el).data().detail, function(key, value){
 
            $('.item-detail').append('<tr role="row"><td>' + `${key+1}` + '</td><td>'+ `<img class="item-img" src="http://localhost/campus2/public/${value.product.images[0].path}" style="width:100px; height:120px">` + '</td><td>'+ value.product.name + '</td><td>'+ value.price +'</td><td>'+ value.created_at +'</td></tr>');
 
            });

        },
        didClose:() => {

            $('.item-detail').empty();

        }
    })    

    return
}     

function SetStyle(index){

    let style = "";

    switch (index) {
    case 0:
         style = "badge-secondary";
        break;
    case 1:
         style = "badge-primary";
        break;
    case 2:
        style = "badge-success";
        break;
    case 3:
        style = "badge-danger";
        break;    
    default:
        style = "";
    }

    return style;

     // $(`#status-${index} span`).addClass("badge-success");
      // $(`#status-${index} span`).addClass("badge-danger");

}

function radioValidation(){

const radio = document.getElementsByClassName("necessaryRadio");

let Valid = false;

for(var i = 0; i < radio.length; i++){
    if(radio[i].checked == true){
        Valid = true;    
    }
}

return Valid

}

</script>    

@endsection


{{-- 舊的改變訂單狀態 --}}

{{-- function ChangeStatus(el){

     $('#btn-ChangeStatus-modal').modal('show');
    
    if($('input[name=status]:checked').length!=0){

        document.querySelector('input[name="status"]:checked').checked = false;
     }


     let value = $(el).data().status;
   
     document.querySelector('#ord_hash').value = $(el).data().order;
    

     if(value==0){

         document.querySelector('#status0').checked = true;

     }else if(value==1){

        document.querySelector('#status1').checked = true;

     }else if(value==2){

         document.querySelector('#status2').checked = true;

     }else if(value==3){

        document.querySelector('#status3').checked = true;

     }

} --}}



{{-- $('input[name="cancel_status"]').on("change",function(){

    let value = $(this).val();


    if(value==="5"){

       $('#btn-CancelStatus-modal .modal-body').append('<div class="form-group reason"><label class="text-danger" for="cancelReason">請填寫拒絕理由</label><textarea class="form-control" id="cancelReason" name="reason" rows="3" required></textarea>');
       
    }else{

       $(".reason").remove();
    }

    return

})  --}}