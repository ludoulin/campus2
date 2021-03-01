@extends('layouts.basic')

@section('basic')
<link href="{{ asset('css/user/edit.css') }}" rel="stylesheet">
@endsection

@section('content')

<?php $profile_action = route('users.update', $user->id) ?>

<user-profile :user="{{ $user }}" :payment_types="{{$payment_types}}" :options="{{$user->payment_types}}"></user-profile>
{{-- <div class="container">
  <div class="row">
  <div class="col-lg-12 col-md-12">
   <div class="user-card">
     <div class="user-card-body p-0">
        <div class="user-edit-list">
          <ul class="user-edit-profile d-flex nav nav-pills">
            <li class="col-md-3 p-0">
              <a class="nav-link" data-toggle="pill" href="javascript::void(0)">使用者基本資料</a>
            </li> 
            <li class="col-md-3 p-0">
               <a class="nav-link" data-toggle="pill" href="javascript::void(0)">修改密碼</a>
            </li> 
            <li class="col-md-3 p-0">
                <a class="nav-link" data-toggle="pill" href="javascript::void(0)">合併帳號</a>
             </li>   
            <li class="col-md-3 p-0">
               <a class="nav-link" data-toggle="pill" href="javascript::void(0)">設定可接受的付費方式</a>
            </li>   
          </ul>  
        </div>
     </div>
   </div>
  </div>

  <div class="col-lg-12 col-md-12">
    <div class="card">
      <div class="card-header">
        <h4>
          <i class="glyphicon glyphicon-edit"></i> 編輯個人資料
        </h4>
      </div>

      <div class="card-body">
        
        <form action="{{ route('users.update', $user->id) }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
          <input type="hidden" name="_method" value="PATCH">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">

            @include('shared.error')

          <div class="form-group">
            <label for="name-field">使用者名稱</label>
            <input class="form-control" type="text" name="name" id="name-field" value="{{ old('name', $user->name) }}" />
          </div>
          <div class="form-group">
            <label for="email-field">信箱</label>
            <input class="form-control" type="text" name="email" id="email-field" value="{{ old('email', $user->email) }}" />
          </div>
          <div class="form-group">
            <label for="introduction-field">個人賣場簡介</label>
            <textarea name="introduction" id="introduction-field" class="form-control" rows="3">{{ old('introduction', $user->introduction) }}</textarea>
          </div>
          <div class="form-group mb-4">
            <label for="" class="avatar-label">大頭貼</label>
            <input type="file" name="avatar" class="form-control-file">
             @if($user->avatar)
             <br>
            <img class="thumbnail img-responsive" src="{{ $user->avatar }}" width="200" />
             @endif
            </div>
          <div class="well well-sm">
            <button type="submit" class="btn btn-primary">儲存</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  </div>
</div> --}}

@endsection


