@extends('layouts.control_panel')
@section('title', '後台管理')

@section('sass_backend')
<link href="{{ asset('css/backend/home.css') }}" rel="stylesheet">
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
                          <h3 class="mb-0 text-center"><span class="counter">{{$counter["users"]}}</span></h3>
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
                              <h3 class="mb-0 text-center"><span class="counter">{{$counter["products"]}}</span></h3>
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
                              <h3 class="mb-0 text-center"><span class="counter">{{$counter["sales"]}}</span></h3>
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
                              <h3 class="mb-0 text-center"><span class="counter">{{$counter["orders"]}}</span></h3>
                              <h6>平台訂單總數量</h6>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
    </div> 
</div> 
<div class="content">
    <div id="control-panel-landing-page">
        <div class="box text-center">
            <h1>二手書交易推播平台</h1>
            <h3 class="mt-3">後台管理系統</h3>
        </div>
    </div>
</div>
@stop