@php
    use Carbon\Carbon;
@endphp
@extends('layouts.control_panel')
@section('title', '二手書商品管理')

@section('sass_backend')
<link href="{{ asset('css/backend/user/index.css') }}" rel="stylesheet">
@endsection

@section('content')
<!-- Listing table -->
<div class="row">
        <div class="col-sm-12">
            <div class="cust-table-cont">
            <div class="table-responsive">
              <table border="0" class="table cust-table"> 
                <thead>
                    <tr style="" class="text-center">
                      <th style="width:80px;">商品編號</th> 
                      <th style="width:150px;" ><li class="fa fa-gear"></li>操作</th>  
                      <th style="width:150px;">賣家</th> 
                      <th style="width:250px;">商品名稱</th> 
                      <th style="width:120px;">價格</th>  
                      <th style="width:200px;">創建時間</th>                        
                    </tr>
                  </thead>
                  <tbody>
                        @foreach ($products as $product)
                        <tr class="text-center">
                        <td scope="row" style="width:80px;">{{ $loop->iteration }}</td>
                        <td style="width:150px;" class="text-center">
                             <button class="btn btn-outline-success" 
                             onclick="location.href='{{ route('admin.products.edit', $product->id) }}'">
                             <span class="fa fa-pencil"></span></button>
                              <button type="button" class="btn btn-outline-danger del-icon"  
                                data-toggle="modal" 
                                data-target="#btn-delete-modal-{{ $product->id }}">
                                <span class="fas fa-trash-alt"></span>
                              </button> 
                                  <!-- -- -->

                                  <!-- 下架確認 Modal -->
                            <div class="modal fade" id="btn-delete-modal-{{ $product->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title font-weight-bold">
                                            {{-- @if ($user->is_banned)
                                               <i class="fas fa-unlock-alt"></i><span> 取消停用</span>
                                            @else   --}}
                                            <i class="fas fa-trash-alt"></i><span> 下架商品</span>
                                            {{-- @endif --}}
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            {{-- @if ($user->is_banned)
                                            <span>確定取消停用<span class="font-weight-bold">【{{ $user->name }}】</span>這個使用者嗎？</span>
                                            @else   --}}
                                            <span>確定下架<span class="font-weight-bold"></span>此商品嗎？</span>
                                            {{-- @endif --}}
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">返回</button>
                                            <form action="{{ route('admin.products.destory',$product->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-danger">確認</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>        
                        </td>
                      <td style="width:150px;">{{ $product->user->name }}</td>
                      <td style="width:250px;">{{ $product->name }}</td>
                      <td style="width:120px;">${{ $product->price}}</td>
                      <td style="width:200px;">{{ $product->created_at && $product->created_at->ne(new Carbon('0000-00-00')) ? 
                            $product->created_at->format('Y-m-d H:i') : null }}</td>  
                    </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
            </div> <!-- End of cust-table-cont block -->
        </div>
    </div> <!-- ENd of row -->
@stop