@php
    use App\Models\Product;
@endphp

@extends('layouts.basic')

@section('title', $user->name . '的個人頁面')
<link href="{{ asset('css/user/show.css') }}" rel="stylesheet">
@section('content')
<div class="container">
    <div class="row">
    <!-- start page title -->
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">個人頁面</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">首頁</a></li>
                        <li class="breadcrumb-item active"> {{$user->name}} 的個人頁面</li>
                    </ol>
                </div>
            </div>
        </div>
    <!-- end page title --> 
    </div>
    <div class="row mb-4">
        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="text-center">
                        <div>
                            <img src="{{$user->avatar}}" alt="{{$user->name}}" class="avatar-lg rounded-circle img-thumbnail">
                        </div>
                        <h5 class="mt-3 mb-1">{{$user->name}}</h5>
                        <p class="text-muted">最後登入時間 : {{ $user->last_actived_at->diffForHumans() }}</p>
                        <div class="mt-4">
                            <button type="button" class="btn btn-light btn-lg"><i class="far fa-envelope pr-2"></i>發訊息</button>
                        </div>
                    </div>
                    <hr class="my-4">
                        <div class="text-muted">
                            <h5 class="font-size-16">關於 :</h5>
                            <p>
                                @if($user->introduction)
                                {{ $user->introduction }}
                                @else
                                尚未輸入
                                @endif
                            </p>
                            <div class="table-responsive mt-4">
                                <div>
                                    <p class="mb-1">使用者名稱 :</p>
                                    <h5 class="font-size-16">{{$user->name}}</h5>
                                </div>
                                <div class="mt-4">
                                    <p class="mb-1">手機 :</p>
                                    <h5 class="font-size-16">012-234-5678</h5>
                                </div>
                                <div class="mt-4">
                                    <p class="mb-1">E-mail :</p>
                                    <h5 class="font-size-16">{{$user->email}}</h5>
                                </div>
                                <div class="mt-4">
                                    <p class="mb-1">註冊時間:</p>
                                    <h5 class="font-size-16">{{ $user->created_at->diffForHumans() }}</h5>
                                </div>
                            </div>
                        </div>
                  </div>
            </div>
        </div>
        <div class="col-xl-8 shop">
            <div class="card mb-0">
                <!-- Nav tabs -->
                  <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                      <li class="nav-item mt-2">
                          <a class="nav-link active" data-toggle="tab" href="#sell" role="tab">
                              <i class="fas fa-store-alt font-size-20 pb-2"></i>
                              <span class="d-none d-sm-block">上架中</span> 
                          </a>
                      </li>
                      <li class="nav-item mt-2">
                          <a class="nav-link" data-toggle="tab" href="#deal" role="tab">
                              <i class="far fa-handshake font-size-20 pb-2"></i>
                              <span class="d-none d-sm-block pb-2">已成交</span> 
                          </a>
                      </li>
                      <li class="nav-item mt-2">
                          <a class="nav-link" data-toggle="tab" href="#comments" role="tab">
                              <i class="far fa-comment font-size-20 pb-2"></i>
                              <span class="d-none d-sm-block">評論</span>   
                          </a>
                      </li>
                  </ul>
                <!-- Tab content -->
                  <div class="tab-content p-4">
                      <div class="tab-pane active" id="sell" role="tabpanel">
                          <div class="container">
                              @if(count($products["selling"])!==0)
                              <div class="row">
                                @foreach($products["selling"] as $product)
                                  <div class="col-xl-4 col-md-6">
                                      <div class="prooduct-details-box">
                                          <div class="media">
                                              <img class="align-self-center img-fluid img-60 ml-1" src="{{asset($product->images[0]->path)}}" alt="#">
                                              <div class="media-body ms-3">
                                                  <div class="product-name">
                                                      <h6><a href="#">{{$product->name}}</a></h6>
                                                  </div>
                                                  <div class="price d-flex">
                                                      <div class="text-muted me-2">Price :</div>
                                                          ${{$product->price}}
                                                  </div>
                                                  <div class="avaiabilty">
                                                      <div class="text-success"> {{Product::PRODUCT_STATUS[$product->status]}}</div>
                                                  </div>
                                                  <a class="btn btn-primary btn-xs" href="{{route('products.show',$product->id)}}">前往商品頁</a>
                                              </div>
                                          </div>
                                      </div>
                                 </div>
                                @endforeach
                              </div>
                              <div class="row">
                                  <div class="col-lg-12">
                                      {{ $products["selling"]->links() }}
                                  </div>  
                              </div>
                              @else
                              <div class="alert alert-primary text-center" role="alert">
                                    尚未有上架的商品
                              </div>
                              @endif  
                          </div>
                      </div>
                      <div class="tab-pane" id="deal" role="tabpanel">
                          <div class="container">
                                @if(count($products["dealing"])!==0)
                                <div class="row">
                                    @foreach($products["dealing"] as $product)
                                      <div class="col-xl-4 col-md-6">
                                          <div class="prooduct-details-box">
                                              <div class="media">
                                                  <img class="align-self-center img-fluid img-60 ml-1" src="{{asset($product->images[0]->path)}}" alt="#">
                                                  <div class="media-body ms-3">
                                                      <div class="product-name">
                                                          <h6><a href="#">{{$product->name}}</a></h6>
                                                      </div>
                                                      <div class="price d-flex">
                                                          <div class="text-muted me-2">Price :</div>
                                                            {{$product->price}}
                                                      </div>
                                                      <div class="avaiabilty">
                                                          <div class="text-success"> {{Product::PRODUCT_STATUS[$product->status]}}</div>
                                                      </div>
                                                      <a class="btn btn-primary btn-xs" href="{{route('products.show',$product->id)}}">前往商品頁</a>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                    @endforeach
                                </div>
                                <div class="row">
                                  <div class="col-lg-12">
                                      {{ $products["dealing"]->links() }}
                                  </div>  
                                </div>  
                                @else
                                <div class="alert alert-primary text-center" role="alert">
                                      尚未有售出的商品
                                </div>
                                @endif
                          </div>
                        </div>
                        <div class="tab-pane" id="comments" role="tabpanel">
                            <div class="container">
                                <div class="alert alert-primary text-center" role="alert">
                                    尚未有任何評論
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      </div>    
</div> 
@endsection

{{-- <img class="card-img-top" src="https://www.kindpng.com/picc/m/269-2697881_computer-icons-user-clip-art-transparent-png-icon.png" alt="{{ $user->name }}"> --}}