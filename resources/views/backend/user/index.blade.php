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
{{-- <div class="row">
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
    </div> <!-- ENd of row --> --}}


            <div class="row">
                <div class="col-sm-12">
                    <div class="admin-users-card">
                        <div class="admin-users-header d-flex justify-content-between">
                            <div class="admin-users-header-title"> 
                                <h4 class="card-title">使用者管理</h4>
                            </div>
                            <div class="admin-users-header-toolbar d-flex align-items-center">
                                <a href="" class="btn btn-primary text-white">新增使用者</a>
                            </div>
                        </div>
                        <div class="card-body admin-users-body">
                            <div class="table-responsive">
                                    <table id="admin_users_table" class="table table-bordered nowrap" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%;">#</th> 
                                                    <th style="width: 5%">使用者ID</th>
                                                    <th style="width: 8%"><li class="fa fa-gear pr-2"></li>操作</th>
                                                    <th style="width: 10%">使用者名稱</th>
                                                    <th style="width: 10%">Email</th>
                                                    <th style="width: 7%">權限設置</th>
                                                    <th style="width: 10%">建立時間</th>
                                                    <th style="width: 10%">更新時間</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    @foreach ($users as $user)
                                                    @if($user->is_banned)
                                                    <tr class="text-center tbody-color" role="row"> 
                                                    @else  
                                                    <tr class="text-center" role="row">
                                                    @endif   
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $user->id}}</td>
                                                    <td>
                                                        @if ($user->is_admin)
                                                           最高管理員
                                                        @elseif($user->is_banned)
                                                           <a class="btn bg-primary"
                                                              href="javascript:void(0)"   
                                                              data-toggle="modal" 
                                                              data-target="#btn-delete-modal-{{ $user->id }}">
                                                           <i class="fa fa-unlock-alt"></i>
                                                          </a> 
                                                         @else
                                                         <div class="flex align-items-center list-user-action">
                                                         <a class="btn bg-primary" href="{{ route('admin.users.edit', $user->id) }}">
                                                            <i class="fa fa-pencil"></i>    
                                                         </a>
                                                         <a class="btn bg-salmon"
                                                            href="javascript:void(0)"  
                                                            data-toggle="modal" 
                                                            data-target="#btn-delete-modal-{{ $user->id }}">
                                                            停用
                                                         </a> 
                                                         </div>
                                                        @endif
                            
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
                                                  <td>{{ $user->name }}</td>
                                                  <td>{{ $user->email }}</td>
                                                  <td>
                                                     @if ($user->isAdmin())
                                                        管理員權限
                                                     @elseif($user->is_banned)
                                                        停用權限   
                                                     @else 
                                                        一般使用者
                                                     @endif
                                                    </td>
                                                  <td>{{ $user->created_at && $user->created_at->ne(new Carbon('0000-00-00')) ? 
                                                        $user->created_at->format('Y-m-d H:i') : null }}</td>
                                                  <td>{{ $user->created_at && $user->created_at->ne(new Carbon('0000-00-00')) ? 
                                                      $user->created_at->format('Y-m-d H:i') : null }}</td>      
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
 
    $("#admin_users_table").DataTable({
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