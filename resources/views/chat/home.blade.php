@extends('layouts.basic')
@section('title', '聊天室')
@section('basic')
<link href="{{ asset('css/page/test.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid" id="chat">
	 <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">聊天室</h4>
            </div>
        </div>
    </div>
  	<chat-app :user="{{ auth()->user() }}"></chat-app>
</div>  
@endsection
