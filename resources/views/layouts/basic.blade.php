@extends('layouts.app')


@section('view')

<div id="app" class="main">

  @include('layouts.header')

    <div id ="content" class="container">

     @include('shared.messages')
    
      @yield('content')
    
    </div>
    
      @include('layouts.footer')
    
</div>
@endsection