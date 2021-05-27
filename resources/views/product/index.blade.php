@extends('layouts.basic')

@section('basic')
<link href="{{ asset('css/product/index.css') }}" rel="stylesheet">
@endsection


@section('content')
    <all-product :login="{{ Auth::check() ? 1 : 0 }}"></all-product>
@endsection

@section('script')
<script>
    AOS.init();
</script>
@endsection


