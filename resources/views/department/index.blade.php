@extends('layouts.basic')
@section('title', isset($department) ? $department->name : '錯誤')
@section('basic')
<link href="{{ asset('css/department/index.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="jumbotron jumbotron-fluid title">
        <div class="container">
            <h1 class="display-4">{{$department->name}}</h1>
            <p class="lead">This is a modified jumbotron that occupies the entire horizontal space of its parent.</p>
        </div>
</div>
<nav aria-label="breadcrumb">
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="{{ url('/') }}">首頁</a></li>
           <li class="breadcrumb-item active" aria-current="page">{{$department->name}}</li>
        </ol>
    </nav>
<div class="container my-3">
  <div class="mb-3">
    <form action="{{ route('department.show',$department->id) }}" class="search-form">
        <div class="form-row">
          <div class="col-md-9">
            <div class="form-row">
              <div class="col-auto"><input type="text" class="form-control form-control-sm" name="search" placeholder="搜尋"></div>
              <div class="col-auto"><button class="btn btn-primary btn-sm">搜尋</button></div>
              {{-- <div class="col-auto"><button class="btn btn-primary btn-sm" href="{{ route('department.show',$department->id) }}">重新整理</button></div> --}}
            </div>
          </div>
          <div class="col-md-3">
            <select name="order" class="form-control form-control-sm float-right">
              <option value="">排序方式</option>
              <option value="price_asc">價格低到高</option>
              <option value="price_desc">價格高到低</option>
              <option value="created_at_desc">刊登時間新到舊</option>
              <option value="created_at_asc">刊登時間舊到新</option>
            </select>
          </div>
        </div>
      </form>
  </div>
        <div class="row row-eq-height">
         @foreach ($products as $product)
          {{-- @if($product->product->is_stock==true) --}}
          <div data-aos="zoom-in" class="col-12 col-md-6 col-lg-4 col-xl-3 mb-5">
            <div class="product-card h-100 mb-0">
              <a class="product-card__content" href="{{route('products.show', $product->id)}}">
                <span class="product-card__img" style="background-image:url({{asset($product->images[0]->path)}})"></span>
                  <span class="product-card__title">
                    {{$product->name}}
                  </span>
                  <span class="product-card__price">
                    ${{$product->price}}
                  </span>
                  <span class="product-card__title">
                    賣家:{{$product->user->name}}
                 </span>
              </a>
              <div class="product-card__actions">
                <a class="product-card__btn mr-3" href="#">
                  <i class="fas fa-plus mr-2"></i>
                    加入購物車
                </a>
                <favorite-circle
                :login="{{ Auth::check() ? 1 : 0 }}"
                :product={{ $product->id }}
                :favorited={{ !$product->favorited->isEmpty() ? 'true' : 'false' }}
                ></favorite-circle>
              </div>
            </div>
          </div>
          {{-- @endif --}}
          @endforeach
        </div>
      </div>
@endsection

@section('script')
<script>
AOS.init();
var filters = {!! json_encode($filters) !!};
    $(document).ready(function () {
      $('.search-form input[name=search]').val(filters.search);
      $('.search-form select[name=order]').val(filters.order);
      $('.search-form select[name=order]').on('change', function() {
        $('.search-form').submit();
      });
    })

</script>
@endsection