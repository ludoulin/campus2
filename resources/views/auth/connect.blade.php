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
                    <a href="https://access.line.me/dialog/bot/accountLink?linkToken={{$linkToken}}&nonce={{$nonce}}" class="mb-5 d-block campus-logo text-muted">
                            請點擊此連結完成綁定動作
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>       
@endsection