@php
    use Carbon\Carbon;
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
                                                        @if(!$product->is_stock)
                                                        <tr class="text-center tbody-color" role="row"> 
                                                        @else  
                                                        <tr class="text-center" role="row">
                                                        @endif  
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $product->id }}</td>
                                                        <td>
                                                            @if(!$product->is_stock)
                                                            <a class="btn bg-primary"
                                                                href="javascript:void(0)"   
                                                                data-toggle="modal" 
                                                                data-target="#btn-delete-modal-{{ $product->id }}">
                                                               恢復上架
                                                            </a>
                                                            @else 
                                                            <div class="flex align-items-center list-product-action">
                                                            <a class="btn bg-primary" 
                                                               href="{{ route('products.show', $product->id) }}">
                                                               <i class="far fa-eye"></i>
                                                            </a>
                                                            <a class="btn bg-salmon"  
                                                                href="javascript:void(0)"
                                                                data-toggle="modal" 
                                                                data-target="#btn-delete-modal-{{ $product->id }}">
                                                                下架
                                                            </a>
                                                            </div>
                                                            @endif 
                                                                <!-- -- -->

                                                                <!-- 下架確認 Modal -->
                                                            <div class="modal fade" id="btn-delete-modal-{{ $product->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title font-weight-bold">
                                                                            @if (!$product->is_stock)
                                                                            <i class="fas fa-unlock-alt"></i><span> 恢復上架</span>
                                                                            @else  
                                                                            <i class="fas fa-trash-alt"></i><span> 下架商品</span>
                                                                            @endif
                                                                            </h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            @if (!$product->is_stock)
                                                                            <span>確定恢復上架<span class="font-weight-bold"></span>這個商品嗎？</span>
                                                                            @else  
                                                                            <span>確定下架<span class="font-weight-bold"></span>此商品嗎？</span>
                                                                            @endif
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">返回</button>
                                                                            <form action="{{ route('admin.products.publish',$product->id) }}" method="POST">
                                                                                    @method('PATCH')
                                                                                    @csrf
                                                                                    <input type="hidden" name="publish" value={{ $product->is_stock ? '0' : '1'}}>
                                                                                    <button type="submit" class="btn btn-danger">確認</button>
                                                                                </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>        
                                                        </td>
                                                    <td>{{ $product->user->name }}</td>
                                                    <td>{{ $product->name }}</td>
                                                    <td>${{ $product->price}}</td>
                                                    <td>@if ($product->is_stock)
                                                        <h4><span class="badge rounded-pill badge-success">上架中</span></h4>
                                                     @else 
                                                        <h4><span class="badge rounded-pill badge-danger">已下架</span></h4>
                                                     @endif
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
    </script>    
@endsection

{{-- <form action="{{ route('admin.products.destroy',$product->id) }}" method="POST">
        @method('DELETE')
        @csrf
        <button type="submit" class="btn btn-danger">確認</button>
    </form> --}}