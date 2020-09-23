@extends('layouts.control_panel')

@section('title', '使用者管理編輯')

@section('content')
<div class="container">
    <div class="col-md-8 offset-md-2">
  
      <div class="card">
        <div class="card-header">
          <h4>
            <i class="glyphicon glyphicon-edit"></i> 編輯個人資料
          </h4>
        </div>
  
        <div class="card-body">
  
          <form action="{{ route('admin.users.update', $user->id) }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
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
@stop