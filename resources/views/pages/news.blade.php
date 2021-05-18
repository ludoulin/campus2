@extends('layouts.basic')

@section('title', $news->name)

@section('basic')
<link href="{{ asset('css/backend/news/index.css') }}" rel="stylesheet">
@endsection

@section('content')

@include('pages.banner',['activities' => $activities])

<div class="container mt-3">
    <div class="row">
        <div class="col-sm-12">
            <div class="news-manage-card">
                <div class="news-manage-header d-flex justify-content-between">
                    <div class="news-manage-header-title"> 
                        <h4 class="card-title">消息標題 : {{$news->name}}</h4>
                    </div>
                    <div class="admin-users-header-toolbar d-flex align-items-center">
                            <h4 class="card-title">發布日期 : {{ $news->publish_date->toDateString() }}</h4>
                    </div>
                </div>
                <div class="card-body news-manage-body">
                        <h4 class="card-title">內容 :</h4>
                    <br>
                        {!! $news->content !!}
                </div>
            </div>    
        </div>
    </div>    
</div>

@endsection