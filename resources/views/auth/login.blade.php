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
                        <img src="https://slc.ntut.edu.tw/var/file/45/1045/img/taipeitechsllogo.png" height="22" class="logo logo-dark pr-2">北科大二手書交易平台
                    </a>
                </div>
                @include('shared.messages')
            </div>
        </div>
        <div class="row align-items-center justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card">
                    <div class="card-body p-4"> 
                        <div class="text-center mt-2">
                            <h5 class="text-primary">歡迎回來！</h5>
                            <p class="text-muted">快點登入北科二手書交易平台吧</p>
                        </div>
                        <div class="p-2 mt-4">
                            <form method="POST" action="{{ route('login') }}" accept-charset="UTF-8" enctype="multipart/form-data" onsubmit="return LoginValid()">
                                @csrf
                                @if(isset($encrypted))
                                <input type="hidden" id="lineToken" name="lineToken" value="{{$encrypted}}">
                                @endif
                                <div class="mb-3">
                                    <label class="form-label" for="email">{{ __('E-Mail Address') }}</label>
                                    <input type="text" class="form-control necessary {{ !$errors->has('email') ? '' : 'is-invalid' }}" name="email" value="{{ old('email') }}" id="email" placeholder="請輸入使用者信箱">
                                    @if ($errors->has('email'))
                                    <div class="text-danger">
                                        <span><strong>{{ $errors->first('email') }}</strong></span>
                                    </div>
                                    @endif
                                </div>
        
                                <div class="mb-3">
                                    <div class="float-end">
                                        @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="text-muted">{{ __('Forgot Your Password?') }}</a>
                                        @endif
                                    </div>
                                    <label class="form-label" for="password">{{ __('Password') }}</label>
                                    <input type="password" id="password" type="password" class="form-control necessary {{ !$errors->has('password') ? '' : 'is-invalid' }}" name="password" placeholder="請輸入使用者密碼" autocomplete="current-password">
                                    @if($errors->has('password'))
                                    <div class="text-danger">
                                        <span><strong>{{ $errors->first('password') }}</strong></span>
                                    </div>
                                    @endif
                                </div>
        
                                {{-- <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="auth-remember-check">
                                    <label class="form-check-label" for="auth-remember-check">Remember me</label>
                                </div> --}}
                                
                                <div class="mt-3 text-end">
                                    <button class="btn btn-primary w-sm waves-effect waves-light" type="submit">登入</button>
                                </div>
    
                                

                                <div class="mt-4 text-center">
                                    <div class="signin-other-title">
                                        <h5 class="font-size-14 mb-3 title">其他方式登入</h5>
                                    </div>
                                    
    
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <a href="{{ route('social.redirect', ['provider' => 'google']) }}" class="btn social-list-item">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg" class="mr-2" alt="google" width="20">使用 Google 登入
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="mt-4 text-center">
                                    <p class="mb-0">還沒有帳號嗎 ? <a href="{{ route('register') }}" class="fw-medium text-primary"> 馬上註冊</a> </p>
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


@section('script')
<script>
    function LoginValid(){
        return ValidateForm() && EmailVaild() && PasswordValid()
    }
    function EmailVaild(){

        let EmailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

        let email = document.getElementById("email").value;

        if(!EmailRegex.test(email)){

        MessageObject.VaildSubmitMessage("驗證錯誤","請輸入正確的email格式");

        return false

        }

        return true
    }
    function PasswordValid(){

        let PasswordRegex = /^(?=.*[a-z])(?=.*\d)[a-z\d]{8,12}$/;

        let password = document.getElementById("password").value;

        if(!PasswordRegex.test(password)){

            MessageObject.VaildSubmitMessage('驗證錯誤','密碼欄位不能在不符合規則下按下送出');

           return false
        }

        return true
    }

</script>
@endsection

