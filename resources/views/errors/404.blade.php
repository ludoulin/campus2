@extends('layouts.app')

@section('sass')

<link href="{{ asset('css/errors/404.css') }}" rel="stylesheet">


@endsection


@section('view')

<div class = "container">
        <div class= "error_block">
           <div class= "error_title">
               <strong> 404 </strong>
            </div>
           <div class= "error_content">
                <div><i class="far fa-sad-tear pr-2"></i><b>... Page Not Found</b></div>
           </div> 
        <a class="btn btn-lg btn-block btn-success" href="{{ url('/') }}">回首頁</a>
        </div>
     </div>

@endsection