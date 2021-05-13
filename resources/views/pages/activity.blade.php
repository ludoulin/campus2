@extends('layouts.basic')

@section('title', $activity->name)

@section('basic')

@endsection

@section('content')
<div class="container">
    <div class="card mb-3">
        <img class="card-img-top" src="{{asset($activity->avatar)}}">
         <div class="card-body">
            <h5 class="card-title">活動標題: {{$activity->name}}</h5>
            <hr>
            <h5 class="card-title">活動內容:</h5>
            <div id="activity-container">
                {!! $activity->content !!}
             </div>    
        </div>
    </div>
</div>

@endsection