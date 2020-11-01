@php
    use Carbon\Carbon;
@endphp
@extends('layouts.control_panel')
@section('title', '使用者管理')

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
                      <th style="width:80px;">#</th> 
                      <th style="width:150px;" ><li class="fa fa-gear"></li>功能</th>  
                      <th style="width:150px;">顯示名稱</th> 
                      <th style="width:250px;">Email</th> 
                      <th style="width:120px;">權限設置</th>  
                      <th style="width:200px;">更新時間</th>
                      <th style="width:150px;">創建時間</th>                        
                    </tr>
                  </thead>
                  <tbody>
                        @foreach ($users as $user)
                        @if($user->is_banned)
                        <tr class="text-center tbody-color"> 
                        @else  
                        <tr class="text-center">
                        @endif   
                        <td scope="row" style="width:80px;">{{ $loop->iteration }}</td>
                        <td style="width:150px;" class="text-center">
                            @if ($user->is_admin)
                              最高管理員
                            @elseif($user->is_banned)
                               <button type="button" class="btn btn-outline-info del-icon"  
                               data-toggle="modal" 
                               data-target="#btn-delete-modal-{{ $user->id }}">
                               <span class="fas fa-unlock-alt"></span>
                                </button> 
                             @else
                             <button class="btn btn-outline-success" 
                             onclick="location.href='{{ route('admin.users.edit', $user->id) }}'">
                             <span class="fa fa-pencil"></span></button>
                              <button type="button" class="btn btn-outline-danger del-icon"  
                                data-toggle="modal" 
                                data-target="#btn-delete-modal-{{ $user->id }}">
                                <span class="fas fa-user-lock"></span>
                              </button> 
                              @endif
                                  <!-- -- -->

                                  <!-- 停用/解除確認 Modal -->
                            <div class="modal fade" id="btn-delete-modal-{{ $user->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title font-weight-bold">
                                            @if ($user->is_banned)
                                               <i class="fas fa-unlock-alt"></i><span> 取消停用</span>
                                            @else  
                                            <i class="fas fa-ban"></i><span> 停用使用者</span>
                                            @endif
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            @if ($user->is_banned)
                                            <span>確定取消停用<span class="font-weight-bold">【{{ $user->name }}】</span>這個使用者嗎？</span>
                                            @else  
                                            <span>確定停用<span class="font-weight-bold">【{{ $user->name }}】</span>這個使用者嗎？</span>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">返回</button>
                                            <form action="{{ route('admin.users.publish',$user->id) }}" method="POST">
                                                @method('PATCH')
                                                @csrf
                                                <input type="hidden" name="publish" value={{ $user->is_banned ? '0' : '1'}}>
                                                <button type="submit" class="btn btn-danger">確認</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>        
                        </td>
                      <td style="width:150px;">{{ $user->name }}</td>
                      <td style="width:250px;">{{ $user->email }}</td>
                      <td style="width:120px;">
                         @if ($user->isAdmin())
                            管理員權限
                         @elseif($user->is_banned)
                            停用權限   
                         @else 
                            一般使用者
                         @endif
                        </td>
                      <td style="width:200px;">{{ $user->created_at && $user->created_at->ne(new Carbon('0000-00-00')) ? 
                            $user->created_at->format('Y-m-d H:i') : null }}</td>
                      <td style="width:150px;">{{ $user->created_at && $user->created_at->ne(new Carbon('0000-00-00')) ? 
                          $user->created_at->format('Y-m-d H:i') : null }}</td>      
                    </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
            </div> <!-- End of cust-table-cont block -->
        </div>
    </div> <!-- ENd of row -->
    

    {{-- <div id="control-panel-landing-page">
            <div class="box text-center">
                <h1>二手書交易推播平台</h1>
                <h3 class="mt-3">使用者管理系統</h3>
            </div>
        </div> --}}
@stop