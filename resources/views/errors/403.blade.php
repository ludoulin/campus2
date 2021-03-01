@extends('layouts.app')

@section('sass')

<link href="{{ asset('css/errors/404.css') }}" rel="stylesheet">


@endsection


@section('view')

<div class = "container">
        <div class= "error_block">
           <div class= "error_title">
               <strong> 403 錯誤</strong>
            </div>
           <div class= "error_content">
                <div><i class="far fa-angry pr-2"></i><b>你沒有權限操作此頁</b></div>
                <div><b>請不要惡意操作</b></div>
           </div> 
        <a class="btn btn-lg btn-block btn-danger" href="{{ url('/') }}">回首頁</a>
        </div>
     </div>

@endsection