@extends('layouts.basic')
@section('title', '聊天室')
@section('content')
<div class="container">
    <chat-component :user="{{ auth()->user() }}"></chat-component>
</div>
@endsection 