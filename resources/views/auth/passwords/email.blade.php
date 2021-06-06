@extends('layouts.app')


@section('sass')
<link href="{{ asset('css/auth/login_and_register.css') }}" rel="stylesheet">
@endsection


@section('view')
<div class="account-pages my-5  pt-sm-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div>  
                    <a href="{{url('/')}}" class="mb-5 d-block campus-logo text-muted text-center">
                        <img src="https://slc.ntut.edu.tw/var/file/45/1045/img/taipeitechsllogo.png" height="22" class="logo logo-dark pr-2">北科大二手書交易平台
                    </a>
                    <div class="card">
                        <div class="card-body p-4"> 
                            <div class="text-center mt-2">
                                <h5 class="text-primary">{{ __('Reset Password') }}</h5>
                            </div>
                            <div class="p-2 mt-4">
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label" for="useremail">{{ __('E-Mail Address') }}</label>
                                        <input type="email" id="usermail" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus required placeholder="請輸入使用者信箱">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="mt-3 text-end">
                                        <button class="btn btn-primary w-sm waves-effect waves-light" type="submit"> {{ __('Send Password Reset Link') }}</button>
                                    </div>
                                    <div class="mt-4 text-center">
                                        <p class="mb-0">還記得密碼嗎 ? <a href="{{route('login')}}" class="fw-medium text-primary"> 登入 </a></p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <p>© 2021 北科大二手書交易平台 <i class="fas fa-heart text-danger"></i> by 北科大團隊</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
