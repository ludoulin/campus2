@extends('layouts.basic')

@section('basic')
<link href="{{ asset('css/user/favorite.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container mt-3">
<h2 class="mb-3"><i class="fas fa-heart pr-2"></i>我的收藏 ({{$myfavorites->count()}})</h2>
{{$myfavorites}}
		<div class="row">
            @forelse ($myfavorites as $myfavorite)    
			<div class="col-md-6 col-lg-4 g-mb-30">
			  <article class="u-shadow-v18 g-bg-white text-center rounded g-px-20 g-py-40 g-mb-5">
				<img class="img mb-4" src="{{asset($myfavorite->images[0]->path)}}" alt="Image Description">
				<h3 class="h5 g-color-black g-font-weight-600 g-mb-10">{{ $myfavorite->name }}</h3>
                <span class="d-block g-color-primary g-font-size-16 g-mb-5">${{ $myfavorite->price }}</span>
                <hr>
                <div class="feature">
                  <div class="row">
                    <div class="col-lg-4 col-md-4">   
                     <a href="{{route('products.show', $myfavorite->id)}}" class="btn btn-outline-primary"><i class="fas fa-info-circle pr-2"></i>商品資訊</a>
                    </div>
                    <div class="col-lg-3 col-md-3">  
                     <a href="" class="btn btn-outline-success"><i class="far fa-handshake pr-2"></i>購買</a>
                    </div>
                    <div class="col-lg-5 col-md-5">  
                    <my-favorite :product={{ $myfavorite->id }}></my-favorite>
                    </div>
                  </div>
                </div>
                {{-- <a href="" class="btn btn-secondary">移除收藏</a> --}}
              </article>
            </div>
            @empty
            <p>您沒有收藏商品</p>
            @endforelse
        </div>
</div>            
{{-- <div class="container">
            <div class="card">
                <h5 class="card-header">我的收藏商品</h5>
                <div class="card-body">
                    <div class="row">
                    @forelse ($myfavorites as $myfavorite)    
                    <div class="card col-md-4">
                        <img src="{{asset($myfavorite->images[0]->path)}}" alt="Card image cap" style="height:250px;width:200px">
                        <div class="card-body">
                          <h5 class="card-title">{{ $myfavorite->name }}</h5>
                          <p class="card-text"> {{ $myfavorite->content }}</p>
                          <a href="{{route('products.show', $myfavorite->id)}}" class="btn btn-primary">詳細資訊</a>
                        </div>
                      </div>
                      @empty
                      <p>您沒有收藏商品</p>
                  @endforelse
                </div>
              </div> --}}
            {{-- @forelse ($myfavorites as $myfavorite)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ $myfavorite->name }}
                    </div>

                    <div class="panel-body">
                        {{ $myfavorite->content }}
                    </div>
                </div>
            @empty
                <p>You have no favorite posts.</p>
            @endforelse --}}
{{-- </div> --}}
@endsection