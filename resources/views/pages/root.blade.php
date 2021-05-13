@extends('layouts.basic')
@section('title', '首頁')

@section('basic')
<link href="{{ asset('css/page/root.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container my-3">
<div class="row">
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            @foreach ($activities as $index => $activity)
            <li data-target="#carouselExampleControls" data-slide-to="{{$index}}" class="@if($index===0) active @endif"></li>
            @endforeach
          </ol>
        <div class="carousel-inner">
            @foreach ($activities as $index => $activity)
              <div class="carousel-item @if($index===0) active @endif">
                <a href="{{route("activity.show",$activity->id)}}">
                  <img class="d-block w-100" src="{{asset($activity->avatar)}}" alt="{{$activity->name}}">
                </a>
              </div>
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 p-3 rounded news">
  <div class="inner-news shadow-sm">
  <h6 class="border-bottom border-gray pb-2 mb-0">拍賣置頂公告</h6>
  <div class="media text-muted pt-3">
    <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
      <strong class="d-block text-gray-dark">@username</strong>
      
    </p>
  </div>
  <div class="media text-muted pt-3">
    <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
      <strong class="d-block text-gray-dark">@username</strong>
     
    </p>
  </div>
  <div class="media text-muted pt-3">
    <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
      <strong class="d-block text-gray-dark">@username</strong>
    </p>
  </div>
  <div class="media text-muted pt-3">
      <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
        <strong class="d-block text-gray-dark">@username</strong>
      </p>
    </div>
    <div class="media text-muted pt-3">
        <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
          <strong class="d-block text-gray-dark">@username</strong>
        </p>
      </div>
  <small class="d-block text-right mt-3">
    <a href="#">All updates</a>
  </small>
  </div>
</div>

<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 p-3 rounded news">
  <div class="inner-news shadow-sm">
    <h6 class="border-bottom border-gray pb-2 mb-0">最近成交動態</h6>
    
    <div class="media text-muted pt-3">
      <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
        <strong class="d-block text-gray-dark">@username</strong>
        
      </p>
    </div>
    <div class="media text-muted pt-3">
      <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
        <strong class="d-block text-gray-dark">@username</strong>
       
      </p>
    </div>
    <div class="media text-muted pt-3">
      <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
        <strong class="d-block text-gray-dark">@username</strong>
      </p>
    </div>
    <div class="media text-muted pt-3">
        <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
          <strong class="d-block text-gray-dark">@username</strong>
        </p>
      </div>
      <div class="media text-muted pt-3">
          <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
            <strong class="d-block text-gray-dark">@username</strong>
          </p>
        </div>  
    <small class="d-block text-right mt-3">
      <a href="#">All updates</a>
    </small>
  </div>
  </div>

  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 p-3 rounded news">
    <div class="inner-news shadow-sm">
      <h6 class="border-bottom border-gray pb-2 mb-0">願望清單</h6>
      <div class="media text-muted pt-3">
        <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
          <strong class="d-block text-gray-dark">@username</strong>
          
        </p>
      </div>
      <div class="media text-muted pt-3">
        <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
          <strong class="d-block text-gray-dark">@username</strong>
         
        </p>
      </div>
      <div class="media text-muted pt-3">
        <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
          <strong class="d-block text-gray-dark">@username</strong>
        </p>
      </div>
      <div class="media text-muted pt-3">
          <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
            <strong class="d-block text-gray-dark">@username</strong>
          </p>
        </div>
        <div class="media text-muted pt-3">
            <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
              <strong class="d-block text-gray-dark">@username</strong>
            </p>
          </div> 
      <small class="d-block text-right mt-3">
        <a href="#">All updates</a>
      </small>
    </div>
    </div>

</div>
</div>

<div class="container department-list my-3 ">
   <h2><i class="fas fa-university mr-2"></i>哪個是你的學院呢</h2>
     <div class="row">  
      @foreach ($colleges as $key => $college)
        @php
          if ($key === 0)
            $img = asset('images/ccme.png');
          else if($key === 1)
            $img = asset('images/eng.png');
          else if($key === 2)
            $img = asset('images/mange.png');
          else if($key === 3)
            $img = asset('images/design.png');
          else if($key === 4)
            $img = asset('images/hm.png');
          else if($key === 5)
             $img = asset('images/eecs.png')
        @endphp
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 college" data-toggle="modal" data-target="#{{$college->id}}"><div class="inner-college" style="background-image: url('{{$img}}')"></div></div>
        
        <div class="modal fade" id="{{$college->id}}" role="dialog">
            <div class="modal-dialog inner-dialog">
        
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header inner-header">
                        <h4 class="modal-title inner-title"><i class="far fa-hand-pointer mr-2"></i>請選擇系所</h4>
                    </div>
                    <div class="modal-body inner-body">
                            <div class="container">
                            <div class="row">
                                @foreach($college->departments as $department)
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 department">
                                <div class="inner-department" style="background-image: url('{{ asset('images/ntut.png')}}')" onclick="location.href='{{ route('department.show', $department->id) }}'"><p><b>{{$department->name}}</b></p></div>
                                </div>
                                @endforeach
                            </div>   
                            </div>    

                        {{-- <p style="font-size: 14px;color: #4a4747;font-family: roboto;line-height: 23px;margin-bottom: 0px;padding: 0px 15px 0px;height: 200px;overflow-y: scroll;text-align: justify;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                        <div class="text-center">
                        </div> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fas fa-door-open mr-2"></i>離開</button>
                    </div>
               </div>
             </div>
          </div>
        @endforeach     
    </div>
</div>
<div class="container my-3">
        <h2><i class="fas fa-meteor mr-2"></i>最新二手書</h2>
    <div class="rank_autoplay row">
         @foreach ($products as $product)
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
                 <cart-item
                  :product={{ $product->id }}
                  :carted={{ !$product->carted->isEmpty() ? 'true' : 'false' }}></cart-item>
                <favorite-circle
                  :login="{{ Auth::check() ? 1 : 0 }}"
                  :product={{ $product->id }}
                  :favorited={{ !$product->favorited->isEmpty() ? 'true' : 'false' }}
                ></favorite-circle>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      <div class="container my-3">
            <h2>熱門瀏覽</h2>
        <div class="rank_autoplay row">
             @foreach ($most_views as $product)
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
                     {{-- <img src="{{asset($product->images[0]->path)}}"> --}}
                  </a>
                  <div class="product-card__actions">
                     <cart-item
                      :product={{ $product->id }}
                      :carted={{ !$product->carted->isEmpty() ? 'true' : 'false' }}></cart-item>
                    <favorite-circle
                    :login="{{ Auth::check() ? 1 : 0 }}"
                    :product={{ $product->id }}
                    :favorited={{ !$product->favorited->isEmpty() ? 'true' : 'false' }}
                    ></favorite-circle>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
@endsection
@section('script')
<script>
   $(document).ready(function(){
    $('#carouselExampleIndicators').carousel({
        interval: false
      })


      $('.rank_autoplay').slick({
        arrows: true,
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 5000,
        responsive: [
        {
          breakpoint: 1200,
          settings: {
            slidesToShow: 4,
            slidesToScroll: 1,
            infinite: true
          }
        },
        {
          breakpoint: 992,
          settings: {
            slidesToShow: 4,
            slidesToScroll: 1,
            infinite: true
          }
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 1,
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
@endsection
