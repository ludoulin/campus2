@php
    use Carbon\Carbon;
@endphp
@extends('layouts.control_panel')
@section('title', '活動管理')

@section('sass_backend')
<link href="{{ asset('css/backend/activity/index.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
        <div class="col-sm-12">
                <div class="activity-manage-card">
                        <div class="activity-manage-header d-flex justify-content-between">
                                <div class="order-manage-header-title"> 
                                    <h4 class="card-title">後台活動管理</h4>
                                </div>
                                <div class="admin-users-header-toolbar d-flex align-items-center">
                                        <a href="{{ route('admin.activity.create') }}" class="btn btn-primary text-white"><i class="fas fa-plus pr-2"></i>新增活動</a>
                                    </div>
                        </div>
                        <div class="card-body activity-manage-body">
                                <div id="activity">
                                    <div class="activity-table-container">
                                        <table class="table table-bordered table-hover">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col">年度</th>
                                                    <th scope="col">活動名稱</th>
                                                    <th scope="col">狀態</th>
                                                    <th scope="col">活動結束日期</th>
                                                    <th scope="col">發布</th>
                                                    <th scope="col">功能</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($activities as $activity)
                                                    <tr>
                                                        <td class="align-middle" style="white-space: nowrap">
                                                            {{ $activity->year }}
                                                        </td>
                                                        <td class="align-middle">
                                                            {{ $activity->name }}
                                                        </td>
                                                        <td class="align-middle" style="white-space: nowrap">
                                                            @if ($activity->publish)
                                                                已發布
                                                            @else
                                                                未發布
                                                            @endif
                                                        </td>
                                                        <td class="align-middle" style="white-space: nowrap">
                                                            {{ $activity->end_date->toDateString() }}
                                                        </td>
                                                        <td class="align-middle">
                                                                <a  class="btn @if($activity->publish)
                                                                                btn-danger
                                                                                @else
                                                                                btn-success
                                                                                @endif"
                                                                    href="javascript:void(0)"
                                                                    onclick="Publish(this)"
                                                                    data-activity="{{$activity->id}}"
                                                                    data-status="{{ $activity->publish ? '取消發布' : '發布'}}"
                                                                    data-publish="{{ $activity->publish ? 0 : 1}}"
                                                                    >
                                                                    {{ $activity->publish ? '取消發布': '發布活動'}}
                                                                </a>
                                                        </td>
                                                        <td class="align-middle" style="font-size: 18px">
                                                            <a  class="mr-2" 
                                                                href="{{ route('admin.activity.edit', $activity->id) }}"
                                                                data-toggle="tooltip"
                                                                data-placement="bottom"
                                                                title="編輯">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <a  class="mr-2 text-danger"
                                                                href="javascript:void(0)"
                                                                data-toggle="tooltip"
                                                                data-placement="bottom"
                                                                onclick="DeleteActivity(this)"
                                                                data-activity="{{$activity->id}}"
                                                                title="刪除">
                                                                <i  class="far fa-trash-alt trash-btn">
                                                                </i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                @if ($activities->isEmpty())
                                                    <tr>
                                                        <td colspan="999" class="text-center">目前尚無活動</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                        <div class="page-links mt-4 d-flex justify-content-center">
                                            {{ $activities->links() }}
                                        </div>
                                    </div>
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

})

function DeleteActivity(el){

    swal.fire({
                icon:  'warning',
                width:  '50rem',
                title: `確定要刪除這個活動嗎?`,
                html: ` <p class="text-danger"><b>提醒:若是刪除此活動,此筆活動將會失效</b></p>
                        <form id="DeleteActivity" name="DeleteActivity" method="POST">
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

                    let url = '{{route("admin.activity.destroy",":id")}}';

                    url = url.replace(':id',$(el).data().activity);

                    document.getElementById("DeleteActivity").action = url;

                }
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById("DeleteActivity").submit();
                    }
                })

    return
}

function Publish(el){
    swal.fire({
                icon:  'warning',
                width:  '50rem',
                title: `確定要${$(el).data().status}這個活動嗎?`,
                html: ` <form id="PublishActivity" name="PublishActivity" method="POST">
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

                    let url = '{{route("admin.activity.publish" ,":id")}}';

                    url = url.replace(':id',$(el).data().activity);

                    document.getElementById("PublishActivity").action = url;

                }
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById("PublishActivity").submit();
                    }
                })
        return
    }
</script>    
@endsection