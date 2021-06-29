@php
    use Carbon\Carbon;
@endphp
@extends('layouts.control_panel')
@section('title', '使用者管理')

@section('sass_backend')
<link href="{{ asset('css/backend/user/index.css') }}" rel="stylesheet">
@endsection

@section('content')
            <div class="row">
                <div class="col-sm-12">
                    <div class="admin-users-card">
                        <div class="admin-users-header d-flex justify-content-between">
                            <div class="admin-users-header-title"> 
                                <h4 class="card-title">使用者管理</h4>
                            </div>
                            {{-- <div class="admin-users-header-toolbar d-flex align-items-center">
                                <a href="" class="btn btn-primary text-white"><i class="fas fa-plus pr-2"></i>新增使用者</a>
                            </div> --}}
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
                                                        <div class="d-flex justify-content-center">
                                                        @if(Auth::id()!==$user->id)
                                                        <a class="btn bg-salmon"
                                                            href="javascript:void(0)"
                                                            onclick="AdminPublish(this)"  
                                                            data-admin="1"
                                                            data-user="{{ $user->id }}">
                                                            解除管理員
                                                         </a>
                                                         @else
                                                         <h3><span class="badge bg-primary">管理員</span></h3>
                                                         @endif  
                                                        </div>
                                                        @elseif($user->is_banned)
                                                           <a class="btn bg-primary"
                                                              href="javascript:void(0)"   
                                                              onclick="BannedPublish(this)" 
                                                              data-publish="1"
                                                              data-user="{{ $user->id }}">
                                                           <i class="fa fa-unlock-alt"></i>
                                                          </a> 
                                                         @else
                                                         <div class="flex align-items-center list-user-action">
                                                         <a class="btn bg-primary" data-toggle="tooltip" data-placement="top" title="編輯" href="{{ route('admin.users.edit', $user->id) }}">
                                                            <i class="fas fa-user-edit"></i>
                                                         </a>
                                                         <a class="btn bg-salmon"
                                                            href="javascript:void(0)"
                                                            onclick="BannedPublish(this)"
                                                            data-publish="0"  
                                                            data-user="{{ $user->id }}">
                                                            停用
                                                         </a>
                                                         <a class="btn btn-success"
                                                            href="javascript:void(0)"
                                                            onclick="AdminPublish(this)"  
                                                            data-admin="0"
                                                            data-user="{{ $user->id }}">
                                                            指派為管理員
                                                         </a>  
                                                         </div>
                                                        @endif
                                                    </td>
                                                  <td>{{ $user->name }}</td>
                                                  <td>{{ $user->email }}</td>
                                                  <td>
                                                     @if ($user->isAdmin())
                                                     <h3><span class="badge rounded-pill bg-primary text-white">管理員權限</span></h3>
                                                     @elseif($user->is_banned)
                                                     <h3><span class="badge rounded-pill bg-salmon text-white">停用</span></h3>
                                                     @else 
                                                     <h3><span class="badge rounded-pill bg-success text-white">一般使用者</span></h3>
                                                     @endif
                                                    </td>
                                                  <td>{{ $user->created_at && $user->created_at->ne(new Carbon('0000-00-00')) ? 
                                                        $user->created_at->format('Y-m-d H:i') : null }}</td>
                                                  <td>{{ $user->updated_at && $user->updated_at->ne(new Carbon('0000-00-00')) ? 
                                                      $user->updated_at->format('Y-m-d H:i') : null }}</td>      
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
 
    $("#admin_users_table").DataTable({
        responsive:false,
        "sDom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"+"<'clear'>",
        "bSort": true,
        "aaSorting": [],
        "oLanguage": {
            "sProcessing": "處理中...",
            "sLengthMenu": "顯示 _MENU_ 項結果",
            "sZeroRecords": "沒有符合的資料",
            "sInfo": "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
            "sInfoEmpty": "顯示第 0 至 0 項結果，共 0 項",
            "sInfoFiltered": "(從 _MAX_ 項結果過濾)",
            "sSearch": "搜尋:",
            "oPaginate": {
                "sFirst": "首頁",
                "sPrevious": "上頁",
                "sNext": "下頁",
                "sLast": "尾頁"
                        }
                    }
                })

})
function BannedPublish(el){

   let text = $(el).data().publish ? "取消停用" : "停用" 
    swal.fire({
                icon:  'warning',
                width:  '50rem',
                title: `確定要${text}這個這個使用者嗎?`,
                html: ` <form id="BannedPublishUser" name="BannedPublishUser" method="POST">
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

                    let url = '{{route("admin.users.block" ,":id")}}';

                    url = url.replace(':id',$(el).data().user);

                    document.getElementById("BannedPublishUser").action = url;

                }
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById("BannedPublishUser").submit();
                    }
                })
        return
    }
function AdminPublish(el){

let text = !$(el).data().admin ? "確定要指派這個使用者為管理員嗎" : "確定要解除這個管理員嗎" 

 swal.fire({
             icon:  'warning',
             width:  '50rem',
             title: `${text}?`,
             html: ` <form id="AdminPublishUser" name="AdminPublishUser" method="POST">
                     <input type="hidden" name="publish" value="${$(el).data().admin}">
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

                 let url = '{{route("admin.users.assign" ,":id")}}';

                 url = url.replace(':id',$(el).data().user);

                 document.getElementById("AdminPublishUser").action = url;

             }
             }).then((result) => {
                 if (result.isConfirmed) {
                     document.getElementById("AdminPublishUser").submit();
                 }
             })
     return
 }                                                           
</script>    
@endsection