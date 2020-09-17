@extends('layouts.app')


@section('view')

<div id="app" class="{{ route_class() }}-page">

  @include('layouts.header')

    <div class="container">

     @include('shared.messages')
    
      @yield('content')
    
    </div>
    
      @include('layouts.footer')
    
</div>
@endsection