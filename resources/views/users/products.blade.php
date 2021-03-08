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
                            <a href="" class="btn btn-primary text-white">新增拍賣二手書</a>
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
                                                <td></td>
                                                <td style="color:#FA8072"><strong>${{$product->price}}</strong></td>
                                                <td>{{$product->content}}</td>
                                                <td>@foreach ($product->tags as $tag){{$tag->department->name}},@endforeach</td>
                                                <td>{{$product->created_at}}</td>
                                                <td>{{$product->updated_at}}</td>
                                                <td>
                                                    <div class="flex align-items-center list-product-action">
                                                       <a class="btn bg-primary" data-toggle="tooltip" data-placement="top" title data-original-title="編輯" href="{{ route('products.edit', $product->id) }}">
                                                            <i class="fas fa-edit"></i>
                                                       </a>
                                                       <a class="btn bg-salmon" data-toggle="tooltip" data-placement="top" title data-original-title="刪除" href="＃">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </a>    
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
        {{-- {{$user->products}}    --}}
</div>    

@endsection
@section('script')
<script>
$(function(){
 
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
    </script>    
@endsection