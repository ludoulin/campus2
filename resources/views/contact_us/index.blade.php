
@php
use App\Models\Problem;
@endphp
@extends('layouts.basic')
@section('title', '聯絡我們')

@section('basic')
<link href="{{ asset('css/contact_us/index.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="jumbotron jumbotron-fluid" style="background:#1e7fe4;">
        <div class="container">
            <h1 class="display-4 text-center text-white">Hi,您需要幫忙嗎?</h1>
            <p class="text-center text-white mt-2">歡迎在下方的表單填寫你遇到的問題</p>
        </div>
</div>
<nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/')}}">回首頁</a></li>
            <li class="breadcrumb-item active" aria-current="page">聯絡我們</li>
        </ol>
</nav>
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="problem-card">
                <div class="problem-card-header d-flex justify-content-between">
                    <div class="problem-card-header-title"> 
                        <h4 class="card-title">問題表單</h4>
                    </div>
                </div>
                <div class="card-body problem-card-body">
                        <div class="jumbotron jumbotron-fluid" style="background:#1e7fe4;">
                                <div class="container">
                                    <h1 class="display-4 text-center text-white">聯絡服務團隊</h1>
                                    <p class="text-center text-white mt-2">我們會盡快回復您</p>
                                </div>
                        </div>
                        <div id="problem-create-panel">
                            <form action="{{ route('problem.store') }}" method="POST" id="create_problem" name="ceate_problem" method="POST" accept-charset="UTF-8" enctype="multipart/form-data" onsubmit="return ProblemValid()">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="user_email"><b class="text-danger">*</b>信箱</label>
                                        <input type="text" class="form-control necessary {{ !$errors->has('user_email') ? : 'is-invalid' }}" 
                                                id="user_email" placeholder="輸入標題" name="user_email" value="{{ old('email') }}" autocomplete="off">
                                        <div class="invalid-feedback">
                                            @if ($errors->has('user_email'))
                                            <span class="text-danger">{{ $errors->first('user_email') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="problem-title"><b class="text-danger">*</b>標題</label>
                                        <input type="text" class="form-control necessary {{ !$errors->has('title') ? : 'is-invalid' }}" 
                                            id="problem-title" placeholder="輸入標題" name="title" value="{{ old('title') }}" autocomplete="off">
                                        <div class="invalid-feedback">
                                            @if ($errors->has('title'))
                                            <span  class="text-danger">{{ $errors->first('title') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="problem-type"><b class="text-danger">*</b>問題種類</label>
                                        <div class="input-group">
                                            <select class="form-control necessarySelect" name="type" id="problem-type">
                                                <option value="">--問題種類--</option>
                                                @foreach ($problem_types as $id => $problem_type)
                                                <option value="{{ $id }}">{{ $problem_type }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="invalid-feedback">
                                            @if ($errors->has('type'))
                                            <span class="text-danger">{{ $errors->first('type') }}</span>
                                            @endif
                                        </div>    
                                    </div>
                                    <div class="form-group col-md-12 content-block">
                                        <label for="problem-content"><b class="text-danger">*</b>描述</label>
                                        <textarea id="problem-content" class="form-control necessaryTextArea {{ !$errors->has('content') ? : 'is-invalid' }}"
                                            name="content">{{ old('content') }}</textarea>
                                        <div class="invalid-feedback">
                                            @if ($errors->has('content'))
                                            <span class="text-danger">{{ $errors->first('content') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="file">附件<a class="text-muted">(選填)</a></label>
                                        <input type="file" id="problem-file" class="form-control-file" name="file" accept="image/*"/>
                                        <p class="text-danger mt-2">備註:只能為一張小於2MB的jpg、gif、png圖檔</p>
                                        @if($errors->has('avatar'))
                                         <span class="text-danger">{{ $errors->first('avatar') }}</span>
                                        @endif
                                    </div> 
                                </div>
                                <div class="form-group mt-5 text-center">
                                    <button type="submit" class="btn btn-lg btn-primary">
                                        提交
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>                
    </div>
@endsection


@section('FrontEnd_Script')
<script>
$(document).ready(function() {
    $('select[name="type"]').on("change",function(){
        let value = $(this).val();
        console.log(value);
        SetInputOption(value);
        return
    })  
})

function SetInputOption(value){

    switch (value) {
        case "4":
                if(document.getElementsByClassName("order-block").length===0){
                    $(".content-block").after('<div class="form-group col-md-6 order-block"><label for="order-number"><b class="text-danger">*</b>訂單編號</label><input id="order-number"" class="form-control necessary" type="text" name="order_number" placeholder="請輸入訂單編號" value="{{ old('order_number') }}" autocomplete="off"></div>');
                }
            break;
        default :
                if(document.getElementsByClassName("order-block").length!==0){
                    $(".order-block").remove();
                }   
            break;
        }
    return
}

function ProblemValid(){


    return ValidateForm() && EmailVaild() && TitleValid() && ContentValid() && FileValid()
}

function EmailVaild(){

    $("#user_email").removeClass("is-invalid");

    let EmailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

    let email = document.getElementById("user_email").value;

    if(!EmailRegex.test(email)){

    MessageObject.VaildSubmitMessage("驗證錯誤","請輸入正確的email格式");

    $("#user_email").addClass("is-invalid");

    return false

    }
    return true
}

function TitleValid(){

    $("#problem-title").removeClass("is-invalid");

    let title = document.getElementById("problem-title").value;

    if(title.length>30){

        MessageObject.VaildSubmitMessage("驗證錯誤","標題不可超過30字");

        $("#problem-title").addClass("is-invalid");

        return false
    }

    return true
}

function ContentValid(){

    $("#problem-content").removeClass("is-invalid");

    let content = document.getElementById("problem-content").value;

    if(content.length>300){

        MessageObject.VaildSubmitMessage("驗證錯誤","標題不可超過300字");

        $("#problem-content").addClass("is-invalid");

        return false
    }
    return true
}

function FileValid(){

  const file = document.getElementById('problem-file');

    if(file.files.length > 0) {
            const file_size = Math.round((file.files["0"].size / 1024));
            console.log(file_size);
            if(file_size > 2048){
                MessageObject.VaildSubmitMessage("檔案驗證錯誤",`您目前的檔案大小為${file_size}KB,已超過上限`);
                return false
            }
    }
      return true
}
</script>
@endsection