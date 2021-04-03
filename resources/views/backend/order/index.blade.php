@php
   use App\Models\User;
@endphp

@extends('layouts.control_panel')

@section('title', '後台訂單管理')

@section('sass_backend')
<link href="{{ asset('css/order/manage.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="order-manage-card">
            <div class="order-manage-header d-flex justify-content-between">
                <div class="order-manage-header-title"> 
                    <h4 class="card-title">後台訂單管理</h4>
                </div>
            </div>
            <div class="card-body order-manage-body">
                <div class="table-responsive">
                        <table id="backend_orders_table" class="table table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="width: 15%">訂單編號</th>
                                        <th style="width: 8%">訂單項目查看</th>
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
                                   @foreach($orders as $order)   
                                    <tr role="row">
                                        <td>{{ $order->order_number }}</td>
                                        <td>
                                            <div class="flex align-items-center list-product-action">
                                                <a class="btn bg-primary" data-toggle="tooltip" data-placement="top" title="查看訂單項目" data-detail="{{$order->items}}" onclick="OrderDetail(this)" href="javascript:void(0)">
                                                    <i class="fas fa-eye"></i>
                                                </a>   
                                            </div>
                                        </td>
                                        <td>{{ $order->first_name }}{{ $order->last_name }}</td>
                                        <td><h3><span class="badge badge-salmon">${{$order->price_total}}</span></h3></td>
                                        <td>{{ $order->item_count }}</td>
                                        <td><h3><span class="badge  
                                                        @if($order->status==="待賣家確認")
                                                        badge-secondary
                                                        @elseif($order->status==="賣家已確認")
                                                        badge-primary
                                                        @elseif($order->status==="訂單已完成")
                                                        badge-success
                                                        @elseif($order->status==="拒絕")
                                                        badge-danger 
                                                        @endif ">
                                                    {{ strtoupper($order->status) }}
                                                </span></h3>
                                        </td>
                                        <td> 
                                            @if($order->payment_status)
                                            <h3><span class="badge badge-success">已付款</span></h3>
                                            @else 
                                            <h3><span class="badge badge-secondary">尚未付款</span></h3>
                                            @endif
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


<div class="modal fade" id="btn-OrderDetail-modal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">訂單詳細</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body detail-body">
                <table class="table table-striped">
                        <thead>
                          <tr>
                            <th scope="col">項目</th>
                            <th scope="col">賣家</th>
                            <th scope="col">二手書名稱</th>
                            <th scope="col">價錢</th>
                            <th scope="col">下單日期</th>
                          </tr>
                        </thead>
                        <tbody class="item-detail">
                        </tbody>
                      </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">離開</button>
        </div>
      </div>
    </div>
  </div>


@endsection


@section('script2')
<script>
$(function(){

    $('[data-toggle="tooltip"]').tooltip();

    $("#backend_orders_table").DataTable({
        responsive:true,
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

function OrderDetail(el){

$('#btn-OrderDetail-modal').modal('show');

$('.detail-body .item-detail').empty();

$.each($(el).data().detail, function(key, value){

     $('.detail-body .item-detail').append('<tr><th scope="row">' + `${key+1}` + '</th><td>' + value.product.user.name + '</td><td>' + value.product.name + '</td><td>'+ value.price + '</td><td>'+ value.created_at +'</td></tr>');

    });

return
}          
</script>    
@endsection