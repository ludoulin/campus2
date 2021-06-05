@php
    use App\Models\Product;
@endphp

@extends('layouts.basic')

@section('basic')
<link href="{{ asset('css/user/products.css') }}" rel="stylesheet">
@endsection

@section('title', $user->name . '的商品管理')

@section('content')
<div class="container-fluid mt-3">
    <div class="row">
        <div class="col-sm-12">
            <div class="user-products-card">
                <div class="user-products-header d-flex justify-content-between">
                    <div class="user-products-header-title"> 
                        <h4 class="card-title">個人二手書管理</h4>
                    </div>
                    <div class="user-products-header-toolbar d-flex align-items-center">
                        <a href="{{route('products.create')}}" class="btn btn-primary text-white"><i class="fas fa-plus pr-2"></i>新增拍賣二手書</a>
                    </div>
                </div>
                <div class="card-body user-products-body">
                    <div class="table-responsive">
                        <table id="user_products_table" class="table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width: 5%">編號</th>
                                    <th style="width: 6%">二手書圖片</th>
                                    <th style="width: 10%">二手書書名</th>
                                    <th style="width: 10%">作者</th>
                                    <th style="width: 7%">價錢</th>
                                    <th style="width: 12%">使用狀況</th>
                                    <th style="width: 10%">適用科系</th>
                                    <th style="width: 10%">建立時間</th>
                                    <th style="width: 10%">更新時間</th>
                                    <th style="width: 8%">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->products as $product)   
                                <tr role="row">
                                    <td>{{$product->id}}</td>
                                    <td><img src="{{asset($product->images[0]->path)}}" alt style="width:100px; height:120px"></td>
                                    <td>{{$product->name}}</td>
                                    <td>{{$product->author}}</td>
                                    <td style="color:#FA8072"><strong>${{$product->price}}</strong></td>
                                    <td>{{$product->content}}</td>
                                    <td>@foreach ($product->tags as $tag){{$tag->name}},@endforeach</td>
                                    <td>{{$product->created_at}}</td>
                                    <td>{{$product->updated_at}}</td>
                                    <td>
                                        <div class="flex align-items-center list-product-action">
                                            @if($product->status!== 2 && $product->status!== 3)
                                            <a class="btn bg-primary" data-toggle="tooltip" data-placement="top" title="編輯" href="{{ route('products.edit', $product->id) }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a class="btn bg-salmon" data-toggle="tooltip" data-placement="top" title="刪除" href="javascript:void(0)"  data-product="{{$product->id}}" onclick="DeleteProduct(this)">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                            <a  class="btn 
                                                    @if($product->status===0)
                                                    btn-danger
                                                    @elseif($product->status===1)
                                                    btn-success
                                                    @endif"
                                                    href="javascript:void(0)"
                                                    onclick="Publish(this)"
                                                    data-product="{{$product->id}}"
                                                    data-status="@if($product->status===0)恢復上架@elseif($product->status===1)下架@endif"  
                                                    data-publish="@if($product->status===0) 1 @elseif($product->status===1) 0 @endif">
                                                    @if($product->status===0)
                                                    <i class="fas fa-arrow-up pr-1"></i>上架
                                                    @elseif($product->status===1)
                                                    <i class="fas fa-arrow-down pr-1"></i>下架
                                                    @endif
                                            </a>
                                            @else
                                            <h3><span class="badge
                                            @if($product->status===2)
                                                badge-success
                                            @elseif($product->status===3)
                                                badge-danger
                                            @endif ">
                                            {{Product::PRODUCT_STATUS[$product->status]}}
                                            </span></h3>  
                                            @endif    
                                        </div>
                                    </td>
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
    $("#user_products_table").DataTable({
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
function DeleteProduct(el){
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
function Publish(el){
    swal.fire({
                icon:  'warning',
                width:  '50rem',
                title: `確定要${$(el).data().status}這個商品嗎?`,
                html: ` <form id="PublishProduct" name="PublishProduct" method="POST">
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

                    let url = '{{route("products.publish" ,":id")}}';

                    url = url.replace(':id',$(el).data().product);

                    document.getElementById("PublishProduct").action = url;

                }
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById("PublishProduct").submit();
                    }
                })
        return
    }            
</script>    
@endsection