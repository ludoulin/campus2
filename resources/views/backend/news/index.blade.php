@php
    use App\Models\News;
@endphp
@extends('layouts.control_panel')
@section('title', '後台消息管理')

@section('sass_backend')
<link href="{{ asset('css/backend/news/index.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="news-manage-card">
            <div class="news-manage-header d-flex justify-content-between">
                <div class="news-manage-header-title"> 
                    <h4 class="card-title">後台消息管理</h4>
                </div>
                <div class="admin-news-header-toolbar d-flex align-items-center">
                    <a href="{{ route('admin.news.create') }}" class="btn btn-primary text-white"><i class="fas fa-plus pr-2"></i>新增消息</a>
                </div>
            </div>
            <div class="card-body news-manage-body">
                <div id="news">
                    <div class="news-table-container">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">發布時間</th>
                                    <th scope="col">顯示日期</th>
                                    <th scope="col">消息名稱</th>
                                    <th scope="col">功能</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($newsList as $news)
                                    <tr>
                                        <td class="align-middle" style="white-space: nowrap">
                                            {{ $news->publish_date->toDateString() }}
                                        </td>
                                        <td class="align-middle" style="white-space: nowrap">
                                            {{ $news->start_date->toDateString() }} ~ {{ $news->end_date->toDateString() }}
                                        </td>
                                        <td class="align-middle">
                                            @if ($news->sticky_flag)
                                            <span class="badge text-white p-2 mr-1" style="background: #cd5a3c">置頂</span>
                                            @endif
                                            @if ($news->type)
                                            <span class="badge badge-info text-white p-2 mr-1">{{News::NEWS_TYPES[$news->type]}}</span>
                                            @endif
                                            <span>
                                                <a href="javascript:void(0)" class="text-dark">{{ $news->name }}</a>
                                            </span>
                                        </td>
                                        <td class="align-middle" style="font-size: 18px">
                                            <a  class="btn btn-primary mr-2" 
                                                href="{{ route('admin.news.edit', $news->id) }}"
                                                data-toggle="tooltip"
                                                data-placement="bottom"
                                                title="編輯">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a  class="btn bg-salmon mr-2"
                                                href="javascript:void(0)"
                                                data-toggle="tooltip"
                                                data-placement="bottom"
                                                onclick="DeleteNews(this)"
                                                data-news="{{$news->id}}"
                                                title="刪除">
                                                <i class="far fa-trash-alt trash-btn"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                @if ($newsList->isEmpty())
                                    <tr>
                                        <td colspan="4" class="text-center">目前尚無消息</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="page-links mt-4 d-flex justify-content-center">
                                {{ $newsList->links() }}
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
function DeleteNews(el){

swal.fire({
            icon:  'warning',
            width:  '50rem',
            title: `確定要刪除這個消息嗎?`,
            html: ` <p class="text-danger"><b>提醒:若是刪除此消息,此筆消息將會失效</b></p>
                    <form id="DeleteNews" name="DeleteNews" method="POST">
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

                let url = '{{route("admin.news.destroy",":id")}}';

                url = url.replace(':id',$(el).data().news);

                document.getElementById("DeleteNews").action = url;

            }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("DeleteNews").submit();
                }
            })
    return
}
</script>
@endsection