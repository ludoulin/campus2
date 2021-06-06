@extends('layouts.app')


@section('sass')
<link href="{{ asset('css/auth/login_and_register.css') }}" rel="stylesheet">
@endsection

@section('view')
<div class="account-pages my-5 pt-sm-5" id="app">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center">
                    <a href="{{url('/')}}" class="mb-5 d-block campus-logo text-muted">
                        <img src="https://slc.ntut.edu.tw/var/file/45/1045/img/taipeitechsllogo.png" alt="" height="22" class="logo logo-dark pr-2">北科大二手書交易平台
                    </a>
                </div>
            </div>
        </div>
        <div class="row align-items-center justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card">
                    <div class="card-body p-4"> 
                        <div class="text-center mt-2">
                            <h5 class="text-primary">{{ __('Reset Password') }}</h5>
                        </div>
                        <div class="p-2 mt-4">
                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="mb-3">
                                    <label class="form-label" for="email">{{ __('E-Mail Address') }}</label>
                                    <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        </div> 
                                    @enderror       
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="password">{{ __('Password') }}</label>
                                    <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="請重新設定確認密碼">
                                    @error('password')
                                        <div class="invalid-feedback">
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        </div>
                                    @enderror        
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="password-confirm">{{ __('Confirm Password') }}</label>
                                    <input type="password"  id="password-confirm"  class="form-control @error('password') is-invalid @enderror" name="password_confirmation" autocomplete="new-password" placeholder="請再一次確認密碼">        
                                </div>                                       
                                <div class="mt-3 text-end">
                                    <button class="btn btn-primary w-sm waves-effect waves-light" type="submit"> {{ __('Reset Password') }}</button>
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
@endsection
