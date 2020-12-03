@extends('layouts.basic')
@section('title', '首頁')

@section('basic')
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
<link href="{{ asset('css/page/root.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container department-list my-3 ">
   <h2><i class="fas fa-university mr-2"></i>哪個是你的學院呢</h2>
     <div class="row">  
      @foreach ($colleges as $key => $college)
         @if($key==0)
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 college" data-toggle="modal" data-target="#{{$college->id}}"><div class="inner-college" style="background-image: url('{{ asset('images/ccme.png')}}')"></div></div>
        @elseif($key==1)
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 college" data-toggle="modal" data-target="#{{$college->id}}"><div class="inner-college" style="background-image: url('{{ asset('images/eng.png')}}')"></div></div>
        @elseif($key==2)
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 college" data-toggle="modal" data-target="#{{$college->id}}"><div class="inner-college" style="background-image: url('{{ asset('images/mange.png')}}')"></div></div>
        @elseif($key==3)
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 college" data-toggle="modal" data-target="#{{$college->id}}"><div class="inner-college" style="background-image: url('{{ asset('images/design.png')}}')"></div></div>
        @elseif($key==4)
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 college" data-toggle="modal" data-target="#{{$college->id}}"><div class="inner-college" style="background-image: url('{{ asset('images/hm.png')}}')"></div></div>
        @elseif($key==5)
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 college" data-toggle="modal" data-target="#{{$college->id}}"><div class="inner-college" style="background-image: url('{{ asset('images/eecs.png')}}')"></div></div>
        @endif
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
    <div class="autoplay row">
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
      <div class="container my-3">
            <h2>最近瀏覽</h2>
        <div class="autoplay row">
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