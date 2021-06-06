@extends('layouts.basic')

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
                            <h5 class="text-primary">註冊帳號</h5>
                            <p class="text-muted">快點來註冊帳號吧</p>
                        </div>
                        <div class="p-2 mt-4">
                            <form method="POST" action="{{ route('register') }}" accept-charset="UTF-8" enctype="multipart/form-data" onsubmit="return RegisterValid()" >
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label" for="email">{{ __('E-Mail Address') }}</label>
                                    <input type="email" id="email" class="form-control necessary {{ !$errors->has('email') ? '' : 'is-invalid' }}" name="email" value="{{ old('email') }}"  autocomplete="email" placeholder="請輸入使用者信箱">
                                    @if($errors->has('email'))
                                    <div class="invalid-feedback">
                                        <span class="text-danger"><strong>{{ $errors->first('email') }}</strong></span>
                                    </div>
                                    @endif        
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="username">使用者名稱</label>
                                    <input type="text" id="username" class="form-control necessary {{ !$errors->has('name') ? '' : 'is-invalid' }}" name="name" value="{{ old('name') }}" autocomplete="name" placeholder="請輸入使用者名稱">
                                    @if ($errors->has('name'))
                                    <div class="invalid-feedback">
                                        <span class="text-danger"><strong>{{ $errors->first('name') }}</strong></span>
                                    </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="userpassword">{{ __('Password') }}</label>
                                    <input type="password"  id="userpassword"  class="form-control necessary {{ !$errors->has('password') ? '' : 'is-invalid' }}" name="password" autocomplete="new-password" placeholder="請輸入密碼">
                                    @if($errors->has('password'))
                                    <div class="invalid-feedback">
                                        <span class="text-danger"><strong>{{ $errors->first('password') }}</strong></span>
                                    </div>
                                    @endif        
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="password-confirm">{{ __('Confirm Password') }}</label>
                                    <input type="password"  id="password-confirm"  class="form-control necessary {{ !$errors->has('password') ? '' : 'is-invalid' }}" name="password_confirmation" autocomplete="new-password" placeholder="請再一次確認密碼">        
                                </div>
                                <div class="form-check check-block">
                                    <input type="checkbox" class="form-check-input necessaryCheckBox" id="auth-terms-condition-check">
                                    <label class="form-check-label" for="auth-terms-condition-check">同意<a href="javascript:void(0);" class="text-dark">使用條款和條件</a></label>
                                </div>                                       
                                <div class="mt-3 text-end">
                                    <button class="btn btn-primary w-sm waves-effect waves-light" type="submit">註冊</button>
                                </div>
                                <div class="mt-4 text-center">
                                    <div class="signin-other-title">
                                        <h5 class="font-size-14 mb-3 title">其它方式註冊</h5>
                                    </div>
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <a href="{{ route('social.redirect', ['provider' => 'google']) }}" class="btn social-list-item">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg" class="mr-2" alt="google" width="20">使用 Google 註冊
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="mt-4 text-center">
                                    <p class="text-muted mb-0">已經有帳號了嗎 ? <a href="{{route('login')}}" class="fw-medium text-primary"> 登入</a></p>
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
    function RegisterValid(){
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

        let password = document.getElementById("userpassword").value;

        let confirm_password = document.getElementById("password-confirm").value;

        if(!PasswordRegex.test(password)){

            MessageObject.VaildSubmitMessage('驗證錯誤','密碼欄位不能在不符合規則下按下送出');

           return false
        }

        else if (password !== confirm_password){

            MessageObject.VaildSubmitMessage('驗證錯誤','密碼和確認密碼不相同');

           return false
        }

        return true
    }
</script>
@endsection
