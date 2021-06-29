@php
   use App\Models\News;
   use App\Models\Product;
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
                        <h6>平台使用者</h6>
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
                        <h6>平台商品數量</h6>
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
                        <h6>平台售出數量</h6>
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
                        <h6>平台訂單總數量</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div> 

@include('pages.banner',['activities' => $activities] )
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
    <div class="col-md-12">
        <div class="product-card product-card-block product-card-stretch product-card-height">
           <div class="product-card-header d-flex justify-content-between align-items-center position-relative mb-0 last-detail">
              <div class="product-header-title">
                 <h4 class="card-title mb-0">最新商品</h4>
              </div>
              <div class="product-card-header-toolbar d-flex align-items-center">
              <a href="{{route('products.index')}}" class="btn btn-sm btn-primary view-more">查看更多</a>
              </div>
           </div>                         
           <div class="product-card-body last-contens">
              <ul class="last-slider list-inline p-0 mb-0 row">
                @foreach ($products as $product)
                 <li class="col-md-3 new-item ml-1 mr-1">
                    <a href="{{{ route('products.show', $product->id) }}}">
                    <img src="{{asset($product->images[0]->path)}}" alt="{{$product->name}}" class="d-block mx-auto my-4" height="150">
                    </a>
                    <p class="title-text overflow-ellipsis">書名:{{$product->name}}</p>
                    <p class="title-text">賣家:{{$product->user->name}}</p>
                    <div class="row my-4">
                        <div class="col">
                          <h4><span class="badge badge-primary mb-2">{{Product::PRODUCT_TYPES[$product->type]}}</span></h4>
                          <h4><span class="badge badge-primary mb-2">{{Product::PRODUCT_STATUS[$product->status]}}</span></h4>  
                        </div>
                        <div class="col-auto">
                          <h5 class="text-muted mt-0">${{$product->price}}</h5>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center my-4">
                        <favorite-circle :login="{{ Auth::check() ? 1 : 0 }}" :product={{ $product->id }} :favorited={{ !$product->favorited->isEmpty() ? 'true' : 'false' }}></favorite-circle>
                        <cart-item :product={{ $product->id }} :carted={{ !$product->carted->isEmpty() ? 'true' : 'false' }}></cart-item>
                    </div>
                 </li>
                 @endforeach
              </ul>
           </div>
        </div>
     </div>
     <div class="col-md-12">
        <div class="product-card product-card-block product-card-stretch product-card-height">
           <div class="product-card-header d-flex justify-content-between align-items-center position-relative mb-0 last-detail">
              <div class="product-header-title">
                 <h4 class="card-title mb-0">熱門瀏覽</h4>
              </div>
              <div class="product-card-header-toolbar d-flex align-items-center">
              <a href="{{route('products.index')}}" class="btn btn-sm btn-primary view-more">查看更多</a>
              </div>
           </div>                         
           <div class="product-card-body">
              <ul class="last-slider list-inline p-0 mb-0 row">
                @foreach ($most_views as $product)
                 <li class="col-md-3 new-item ml-1 mr-1">
                    <a href="{{{ route('products.show', $product->id) }}}">
                    <img src="{{asset($product->images[0]->path)}}" alt="{{$product->name}}" class="d-block mx-auto my-4" height="150">
                    </a>
                    <p class="title-text overflow-ellipsis">書名:{{$product->name}}</p>
                    <p class="title-text">賣家:{{$product->user->name}}</p>
                    <div class="row my-4">
                        <div class="col">
                          <h4><span class="badge badge-primary mb-2">{{Product::PRODUCT_TYPES[$product->type]}}</span></h4>
                          <h4><span class="badge badge-primary mb-2">{{Product::PRODUCT_STATUS[$product->status]}}</span></h4>  
                        </div>
                        <div class="col-auto">
                          <h5 class="text-muted mt-0">${{$product->price}}</h5>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center my-4">
                        <favorite-circle :login="{{ Auth::check() ? 1 : 0 }}" :product={{ $product->id }} :favorited={{ !$product->favorited->isEmpty() ? 'true' : 'false' }}></favorite-circle>
                        <cart-item :product={{ $product->id }} :carted={{ !$product->carted->isEmpty() ? 'true' : 'false' }}></cart-item>
                    </div>
                 </li>
                 @endforeach
              </ul>
           </div>
        </div>
     </div>
</div>
@endsection
@section('FrontEnd_Script')
<script>
   $(document).ready(function(){

      $('.last-slider').slick({
          dots: false,
          arrows: false,
          infinite: true,
          speed: 300,
          centerMode: false,
          autoplay: true,
          slidesToShow: 4,
          slidesToScroll: 1,
          responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 1,
                infinite: true,
              }
            },
            {
              breakpoint: 768,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 1
              }
            },
            {
              breakpoint: 576,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1
              }
            }
          ]
        });
    });
</script>
@endsection
{{-- <div class="container my-3">
      <div class="new-slider row">
        @foreach ($products as $product)
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <img src="{{asset($product->images[0]->path)}}" alt="{{$product->name}}" class="d-block mx-auto my-4" height="150">
                    <div class="row my-4">
                        <div class="col">
                            <h4><span class="badge badge-light mb-2">Life Style</span></h4>
                            <p class="title-text d-block">書名: {{$product->name}}</p>
                        </div>
                        <div class="col-auto">
                            <h4 class="text-dark mt-0">${{$product->price}}</h4>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <favorite-circle :login="{{ Auth::check() ? 1 : 0 }}" :product={{ $product->id }} :favorited={{ !$product->favorited->isEmpty() ? 'true' : 'false' }}></favorite-circle>
                        <cart-item :product={{ $product->id }} :carted={{ !$product->carted->isEmpty() ? 'true' : 'false' }}></cart-item>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
      </div>
   </div> --}}