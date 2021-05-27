@php
    use App\Models\Problem;
@endphp
@extends('layouts.control_panel')
@section('title', '後台消息管理')
@section('sass_backend')
<link href="{{ asset('css/backend/problem/index.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="problem-manage-card">
            <div class="problem-manage-header d-flex justify-content-between">
                <div class="problem-manage-header-title"> 
                    <h4 class="card-title">後台問題管理</h4>
                </div>
            </div>
            <div class="card-body problem-manage-body">
                <div id="problem">
                    <div class="problem-table-container">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-dark">
                                <tr class="text-center">
                                    <th scope="col">編號</th>
                                    <th scope="col">使用者信箱</th>
                                    <th scope="col">發問標題</th>
                                    <th scope="col">訂單標號</th>
                                    <th scope="col">發問類型</th>
                                    <th scope="col">功能</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($problemsList as $problem)
                                    <tr class="text-center">
                                        <td class="align-middle" style="white-space: nowrap">
                                                {{ $loop->iteration }}
                                        </td>
                                        <td class="align-middle" style="white-space: nowrap">
                                            {{ $problem->user_email }}
                                        </td>
                                        <td class="align-middle" style="white-space: nowrap">
                                            {{ $problem->title }}
                                        </td>
                                        <td class="align-middle" style="white-space: nowrap">
                                            @if($problem->order_number)
                                            {{ $problem->order_number }}
                                            @else
                                            無關訂單之問題
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <span class="badge badge-info text-white p-2 mr-1">{{Problem::PROBLEM_TYPES[$problem->type]}}</span>
                                        </td>
                                        <td class="align-middle" style="font-size: 18px">
                                            <a  class="btn btn-primary mr-2" 
                                                href="{{ route('admin.problem.show', $problem->id) }}"
                                                data-toggle="tooltip"
                                                data-placement="bottom"
                                                title="查看">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a  class="btn bg-salmon mr-2"
                                                href="javascript:void(0)"
                                                data-toggle="tooltip"
                                                data-placement="bottom"
                                                onclick="DeleteProblem(this)"
                                                data-news="{{$problem->id}}"
                                                title="刪除">
                                                <i class="far fa-trash-alt trash-btn"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                @if ($problemsList->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center">目前尚無消息</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="page-links mt-4 d-flex justify-content-center">
                                {{ $problemsList->links() }}
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

function DeleteProblem(el){

        swal.fire({
            icon:  'warning',
            width:  '50rem',
            title: `確定要刪除這個問題嗎?`,
            html: ` <p class="text-danger"><b>提醒:若是刪除此問題,此筆問題將會失效</b></p>
                    <form id="DeleteProblem" name="DeleteProblem" method="POST">
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

                let url = '{{route("admin.problem.destroy",":id")}}';

                url = url.replace(':id',$(el).data().problem);

                document.getElementById("DeleteProblem").action = url;

            }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("DeleteProblem").submit();
                }
            })
    return
}
</script>
@endsection