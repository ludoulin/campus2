@php
   use App\Models\News;
@endphp
@extends('layouts.basic')
@section('title', '首頁')

@section('basic')
<link href="{{ asset('css/page/root.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="container">
  <div class="row">
    <div class="col-md-6 col-lg-3">
        <div class="card card-block card-stretch card-height">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle card-icon bg-primary"><i class="fas fa-user"></i></div>
                    <div class="text-left ml-3">                                 
                    <h2 class="mb-0"><span class="counter">{{$counter["users"]}}</span></h2>
                        <h5>平台使用者</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card card-block card-stretch card-height">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle card-icon bg-primary"><i class="fas fa-book"></i></div>
                    <div class="text-left ml-3">                                 
                        <h2 class="mb-0"><span class="counter">{{$counter["products"]}}</span></h2>
                        <h5>平台商品數量</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card card-block card-stretch card-height">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle card-icon bg-primary"><i class="fas fa-shopping-cart"></i></div>
                    <div class="text-left ml-3">                                 
                        <h2 class="mb-0"><span class="counter">{{$counter["sales"]}}</span></h2>
                        <h5>平台售出數量</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card card-block card-stretch card-height">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle card-icon bg-primary"><i class="fas fa-receipt"></i></div>
                    <div class="text-left ml-3">                                 
                        <h2 class="mb-0"><span class="counter">{{$counter["orders"]}}</span></h2>
                        <h5>平台訂單總數量</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div> 
</div> 

@include('pages.banner',['activities' => $activities] )

<div class="container mt-3">
  <div class="row">
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
        <div class="container mt-3">
            <h2><i class="fas fa-bullhorn pr-2"></i>消息公告</h2>
            <table class="table news-list-container mt-3">
              <thead>
                  <tr>
                      <th scope="col">發布日期</th>
                      <th scope="col">標題</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach ($newsCollection as $news)
                    <tr>
                        <th class="year-th align-middle">
                              {{ $news->publish_date->toDateString() }}
                        </th>
                        <td class="align-middle">
                          <div class="d-flex nowrap">
                            @if ($news->sticky_flag)
                                <span class="badge badge-salmon text-white p-2 mr-1">置頂</span>
                            @endif

                            @if ($news->type)
                                <span class="badge badge-info text-white p-2 mr-1">{{News::NEWS_TYPES[$news->type]}}</span>
                            @endif
                            
                            <a href="{{route("news.show",$news->id)}}" class="text-primary">
                                <b>[{{ $news->name }}]</b>
                            </a>
                          </div>
                        </td>
                    </tr>
                  @endforeach
                  @if($newsCollection->isEmpty())
                    <tr>
                        <td colspan="999">尚無最新消息</td>
                    </tr>
                  @endif
            </tbody>
        </table>
        <div class="text-right mr-2">
        <a href="{{route('news.index')}}">查看所有消息</a>
        </div> 
    </div> 


<div class="container department-list mt-3">
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

function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>
@endsection
