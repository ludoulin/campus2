@extends('layouts.app')

@section('sass')

@yield('basic')

@endsection

@section('view')

<div id="app" class="main">

  @include('layouts.header')

    <div id ="content">

     @include('shared.messages')
    
      @yield('content')
    
    </div>
    
      @include('layouts.footer')
    
</div>
@endsection