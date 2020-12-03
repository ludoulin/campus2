@extends('layouts.basic')
@section('title', isset($department) ? $department->name : '錯誤')
@section('basic')
<link href="{{ asset('css/department/index.css') }}" rel="stylesheet">
@endsection
@section('content')
<div data-aos="flip-left" class="jumbotron jumbotron-fluid title">
        <div class="container">
            <h1 class="display-4">{{$department->name}}</h1>
            <p class="lead">This is a modified jumbotron that occupies the entire horizontal space of its parent.</p>
        </div>
</div>
<nav data-aos="fade-right" aria-label="breadcrumb">
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="{{ url('/') }}">首頁</a></li>
           <li class="breadcrumb-item active" aria-current="page">{{$department->name}}</li>
        </ol>
    </nav>
<div class="container my-3">
        <div class="row row-eq-height">
         @foreach ($products as $product)
          <div data-aos="zoom-in" class="col-12 col-md-6 col-lg-4 col-xl-3 mb-5">
            <div class="product-card h-100 mb-0">
              <a class="product-card__content" href="{{route('products.show', $product->product->id)}}">
                <span class="product-card__img" style="background-image:url({{asset($product->product->images[0]->path)}})"></span>
                  <span class="product-card__title">
                    {{$product->product->name}}
                  </span>
                  <span class="product-card__price">
                    ${{$product->product->price}}
                  </span>
                  <span class="product-card__title">
                    賣家:{{$product->product->user->name}}
                 </span>
              </a>
              <div class="product-card__actions">
                <a class="product-card__btn mr-3" href="#">
                  <i class="fas fa-plus mr-2"></i>
                    加入購物車
                </a>
                <a class="product-card__icon-btn" href="#">
                  <i class="fas fa-heart"></i>
                </a>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
@endsection

@section('script')
<script>
AOS.init();
</script>
@endsection