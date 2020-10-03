@extends('layouts.control_panel')

@section('title', '使用者管理編輯')

@section('sass_backend')
<link href="{{ asset('css/backend/user/edit.css') }}" rel="stylesheet">
@endsection

{{-- @section('content')
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
                <a class="btn btn-secondary" href="{{ route('admin.users') }}">離開</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@stop --}}

@section('content')
<div id="user-create-edit">
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
        @method('PATCH')
        @csrf
            <div class="row">
                <div class="col">
        <table class="table table-borderless">
            <tbody>
                    <tr>
                            <td>
                                <label class="font-weight-bold avatar-label">大頭貼</label>
                            </td>
                            <td>
                                    <div class="avatar-wrapper">
                                            <img class="profile-pic" src="{{ $user->avatar }}" />
                                            <div class="upload-button">
                                                <i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
                                            </div>
                                            <input class="file-upload form-control-file" type="file" name="avatar" accept="image/*"/>
                                        </div>
        
                            </td>
                        </tr>
                {{-- <tr>
                    <td>
                        <label class="font-weight-bold">使用者名稱</label>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="text" class="form-control {{ !$errors->has('name') ? : 'is-invalid' }}" name="name" 
                                value="{{ old('name', $user->name) }}" required>
                            <div class="invalid-feedback">
                                @if ($errors->has('name'))
                                    <span>{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                    </td>
                </tr> --}}

                <tr>
                    <td>
                        <label class="font-weight-bold">Email</label>
                    </td>
                    <td>
                        <div class="form-group">
                            <input class="form-control" type="text" name="email" id="email-field" value="{{ old('email', $user->email) }}" disabled />
                        </div>
                    </td>
                </tr>
                {{-- <tr>
                    <td>
                        <label for="" class="avatar-label">大頭貼</label>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="file" name="avatar" class="form-control-file">
                            @if($user->avatar)
                            <br>
                           <img class="thumbnail img-responsive" src="{{ $user->avatar }}" width="200" />
                            @endif
                        </div>
                    </td>
                </tr> --}}
                {{-- <tr>
                    <td>
                        <label class="font-weight-bold">密碼</label>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="password" class="form-control {{ !$errors->has('password') ? : 'is-invalid' }}" minlength="8" 
                                name="password" {{ $isEditMode ? '' : 'required' }}>
                            <div class="invalid-feedback">
                                @if ($errors->has('password'))
                                    <span>{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label class="font-weight-bold">確認密碼</label>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="password" class="form-control {{ !$errors->has('confirm_password') ? : 'is-invalid' }}" 
                                name="confirm_password" {{ $isEditMode ? '' : 'required' }}>
                            <div class="invalid-feedback">
                                @if ($errors->has('confirm_password'))
                                    <span>{{ $errors->first('confirm_password') }}</span>
                                @endif
                            </div>
                        </div>
                    </td>
                </tr> --}}
            </tbody>
        </table>
                </div>
                <div class="col">
     <table class="table table-borderless">
            <tbody>
                    <tr>
                            <td>
                                <label class="font-weight-bold">使用者名稱</label>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="text" class="form-control {{ !$errors->has('name') ? : 'is-invalid' }}" name="name" 
                                        value="{{ old('name', $user->name) }}" required>
                                    <div class="invalid-feedback">
                                        @if ($errors->has('name'))
                                            <span>{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <tr>
                            <td>
                                <label for="font-weight-bold">個人賣場簡介</label>
                            </td>
                            <td>
                                <div class="form-group">
                                    <textarea name="introduction" id="introduction-field" class="form-control" rows="3">{{ old('introduction', $user->introduction) }}</textarea>
                                </div>
                            </td>
                        </tr>
                 <tr>
                    <td>
                        <label class="font-weight-bold">修改密碼</label>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="password" class="form-control {{ !$errors->has('password') ? : 'is-invalid' }}" minlength="8" 
                                name="password">
                            <div class="invalid-feedback">
                                @if ($errors->has('password'))
                                    <span>{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <label class="font-weight-bold">確認密碼</label>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="password" class="form-control {{ !$errors->has('confirm_password') ? : 'is-invalid' }}" 
                                name="confirm_password">
                            <div class="invalid-feedback">
                                @if ($errors->has('confirm_password'))
                                    <span>{{ $errors->first('confirm_password') }}</span>
                                @endif
                            </div>
                        </div>
                    </td>
                </tr> 
            </tbody>
        </table>
        <p class="alert alert-warning">不變更密碼，密碼欄請留白。</p>

        <div class="btns text-center">
            <button type="submit" class="btn btn-primary">儲存</button>
            <a class="btn btn-secondary" href="{{ route('admin.users') }}">離開</a>
        </div>
        {{-- <div class="avatar-wrapper">
                <img class="profile-pic" src="{{ $user->avatar }}" />
                <div class="upload-button">
                    <i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
                </div>
                <input class="file-upload form-control-file" type="file" name="avatar" accept="image/*"/>
            </div> --}}
        
                </div>
            </div>
    </form>
</div>  
@endsection
@section('script2')
<script>
  $(document).ready(function() {
	
    var readURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.profile-pic').attr('src', e.target.result);
            }
    
            reader.readAsDataURL(input.files[0]);
        }
    }
   
    $(".file-upload").on('change', function(){
        readURL(this);
    });
    
    $(".upload-button").on('click', function() {
       $(".file-upload").click();
    });
}); 
</script>
@endsection 