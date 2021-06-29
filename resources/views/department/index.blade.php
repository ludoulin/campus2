@extends('layouts.basic')
@section('title', isset($department) ? $department->name : '錯誤')
@section('basic')
<link href="{{ asset('css/department/index.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="jumbotron jumbotron-fluid title">
        <div class="container">
            <h1 class="display-4">{{$department->name}}</h1>
            <p class="lead">找找看有沒有需要的二手書吧</p>
        </div>
</div>
<nav aria-label="breadcrumb">
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="{{ url('/') }}">首頁</a></li>
           <li class="breadcrumb-item active" aria-current="page">{{$department->name}}</li>
        </ol>
    </nav>
  <product-item :login="{{ Auth::check() ? 1 : 0 }}" :user_id="{{Auth::check() ? Auth::id() : 0 }}" :department={{ $department->id }}></product-item>    
@endsection

@section('FrontEnd_Script')
<script>
AOS.init();

</script>
@endsection