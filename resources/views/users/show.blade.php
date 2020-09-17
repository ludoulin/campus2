@extends('layouts.basic')

@section('title', $user->name . '的個人中心')

@section('content')

<div class="row">

  <div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
    <div class="card ">
      <img class="card-img-top" src="{{ $user->avatar }}" alt="{{ $user->name }}">
      <div class="card-body">
            <h5><strong>個人賣場簡介</strong></h5>
            <p>{{ $user->introduction }}</p>
            <hr>
            <h5><strong>註冊於</strong></h5>
            <p>{{ $user->created_at->diffForHumans() }}</p>
      </div>
    </div>
  </div>
  <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
    <div class="card ">
      <div class="card-body">
          <h1 class="mb-0" style="font-size:22px;">{{ $user->name }} <small>{{ $user->email }}</small></h1>
      </div>
    </div>
    <hr>

    {{-- 使用者發布內容 --}}
    <div class="card ">
      <div class="card-body">
        暫無數據
      </div>
    </div>

  </div>
</div>
@stop