@extends('layouts.basic')
@section('title', '搜尋')

@section('basic')
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
<link href="{{ asset('css/search/index.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="container my-3">
    <h2><i class="fas fa-meteor mr-2"></i>您收尋了有關"{{$search}}"的二手書結果</h2>
            <div class="row">
                 @forelse ($products as $product)
                  <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-5">
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
                  @empty
                  <h1><i class="far fa-frown pr-2"></i>抱歉任何查詢的結果</h1>
                  @endforelse
                </div>
              </div>
    <div class="container my-3">
            <h2><i class="fas fa-meteor mr-2"></i>您收尋了有關"{{$search}}"的使用者結果</h2>
                 <div class="row my-3">
                     @forelse ($users as $user)
                         <div class="col-6 col-md-3 col-lg-3 col-xl-3">
                                <div class="card" style="width: 18rem;">
                                        @if($user->avatar)
                                        <img class="card-img-top" src="{{ $user->avatar }}" alt="{{ $user->name }}">
                                        @else
                                        <img class="card-img-top" src="https://www.kindpng.com/picc/m/269-2697881_computer-icons-user-clip-art-transparent-png-icon.png" alt="{{ $user->name }}">
                                        @endif
                                        <div class="card-body">
                                        <h5 class="card-title">{{$user->name}}</h5>
                                          <p class="card-text">
                                          <a href="{{route('users.show', $user->id)}}" class="btn btn-primary"><i class="fas fa-info-circle pr-2"></i>詳細資訊</a>
                                        </div>
                                      </div>
                              </div>
                            @empty
                            <h1><i class="far fa-frown pr-2"></i>抱歉任何查詢的結果</h1>
                         @endforelse
                     </div>
                </div>
                <div class="container my-3">
                        <h2><i class="fas fa-meteor mr-2"></i>您收尋了有關"{{$search}}"的系所結果</h2>
                            <div class="row mt-3">
                                 @forelse ($departments as $department)
                                 <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-6 department">
                                    <div class="inner-department" style="background-image: url('{{ asset('images/ntut.png')}}')" onclick="location.href='{{ route('department.show', $department->id) }}'"><p><b>{{$department->name}}</b></p></div>
                                     </div>
                                     @empty
                            <h1 style="text-align:center"><i class="far fa-frown pr-2"></i>抱歉任何查詢的結果</h1> 
                                  @endforelse
                         </div>
                    </div>
</div>
@endsection
@section('FrontEnd_Script')
<script>
   $(document).ready(function(){
    $('.autoplay').slick({
  arrows: true,
  slidesToShow: 4,
  slidesToScroll: 4,
  autoplay: true,
  autoplaySpeed: 7000,
  responsive: [
        {
          breakpoint: 1200,
          settings: {
            slidesToShow: 4,
            slidesToScroll: 4,
            infinite: true
          }
        },
        {
          breakpoint: 992,
          settings: {
            slidesToShow: 4,
            slidesToScroll: 4,
            infinite: true
          }
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            infinite: true
          }
        },
        {
          breakpoint: 576,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: true
          }
        },
      ]
      });
    });
</script>
<script src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
@endsection