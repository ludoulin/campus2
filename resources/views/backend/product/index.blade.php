@php
    use Carbon\Carbon;
    use App\Models\Product;
@endphp
@extends('layouts.control_panel')
@section('title', '二手書商品管理')

@section('sass_backend')
<link href="{{ asset('css/backend/product/index.css') }}" rel="stylesheet">
@endsection

@section('content')
<!-- Listing table -->
    <div class="row">
        <div class="col-sm-12">
            <div class="admin-products-card">
                <div class="admin-products-header d-flex justify-content-between">
                    <div class="admin-products-header-title"> 
                        <h4 class="card-title">二手書管理</h4>
                    </div>
                </div>
                <div class="card-body admin-products-body">
                    <div class="table-responsive">
                        <table id="admin_products_table" class="table table-bordered nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">#</th> 
                                    <th style="width: 5%">二手書ID</th>
                                    <th style="width: 8%"><li class="fa fa-gear pr-2"></li>操作</th>
                                    <th style="width: 7%">賣家</th>
                                    <th style="width: 10%">書名</th>
                                    <th style="width: 7%">價錢</th>
                                    <th style="width: 7%">狀態</th>
                                    <th style="width: 10%">建立時間</th>
                                    <th style="width: 10%">更新時間</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    @if($product->status===0)
                                    <tr class="text-center tbody-danger" role="row">
                                    @elseif($product->status===2)
                                    <tr class="text-center tbody-success" role="row">     
                                    @else  
                                    <tr class="text-center" role="row">
                                    @endif  
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $product->id }}</td>
                                        <td>
                                            <div class="flex align-items-center list-product-action">
                                                <a class="btn bg-primary" data-toggle="tooltip" data-placement="top" title="編輯" href="{{ route('products.show', $product->id) }}">
                                                    <i class="far fa-eye"></i>
                                                </a>
                                                @if($product->status!==2 || $product->status!==3)
                                                <a  class="btn 
                                                    @if($product->status===0)
                                                        btn-danger
                                                    @elseif($product->status===1)
                                                        btn-success
                                                    @endif"
                                                    href="javascript:void(0)"
                                                    onclick="AdminPublish(this)"
                                                    data-product="{{$product->id}}"
                                                    data-status="@if($product->status===0)恢復上架@elseif($product->status===1)下架@endif"  
                                                    data-publish="@if($product->status===0) 1 @elseif($product->status===1) 0 @endif">
                                                    @if($product->status===0)
                                                    <i class="fas fa-arrow-up pr-1"></i>上架
                                                    @elseif($product->status===1)
                                                    <i class="fas fa-arrow-down pr-1"></i>下架
                                                    @endif
                                                </a>
                                                @endif        
                                            </div>
                                        </td>
                                        <td>{{ $product->user->name }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>${{ $product->price }}</td>
                                        <td>
                                            <h3>
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
                                            </h3>
                                        </td>
                                        <td>{{ $product->created_at && $product->created_at->ne(new Carbon('0000-00-00')) ? $product->created_at->format('Y-m-d H:i') : null }}</td>
                                        <td>{{ $product->updated_at && $product->updated_at->ne(new Carbon('0000-00-00')) ? $product->updated_at->format('Y-m-d H:i') : null }}</td>  
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>    
                </div>
            </div>
        </div>
    </div>     
@endsection

@section('script2')
<script>
$(function(){
    $('[data-toggle="tooltip"]').tooltip();
    $("#admin_products_table").DataTable({
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
function AdminPublish(el){
    swal.fire({
                icon:  'warning',
                width:  '50rem',
                title: `確定要${$(el).data().status}這個商品嗎?`,
                html: ` <form id="AdminPublishProduct" name="AdminPublishProduct" method="POST">
                        <input type="hidden" name="publish" value="${$(el).data().publish}">
                        @method('PATCH')
                        @csrf
                        </form>`,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: '確定',
                cancelButtonText: '取消',
                showCancelButton: true,
                focusConfirm: false,
                allowOutsideClick: false,  
                didOpen:() => {

                    let url = '{{route("admin.products.publish" ,":id")}}';

                    url = url.replace(':id',$(el).data().product);

                    document.getElementById("AdminPublishProduct").action = url;

                }
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById("AdminPublishProduct").submit();
                    }
                })
        return
    }                        
</script>    
@endsection
