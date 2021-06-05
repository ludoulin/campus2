@extends('layouts.basic')

@section('basic')
<link href="{{ asset('css/checkout/index.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
             @if (Session::has('error'))
                <p class="alert alert-danger">{{ Session::get('error') }}</p>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">付款頁面</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">購物車</a></li>
                        <li class="breadcrumb-item active">付款頁面</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-8">
            <div class="custom-info">
                <form id="PayForm" action="{{ route('order.create') }}" method="POST" role="form" accept-charset="UTF-8" enctype="multipart/form-data">
                    <input type="hidden" name="p_id" value="{{$t_prd}}">
                    @csrf
                    <div class="card">
                        <a href="#checkout-billinginfo-collapse" class="text-dark collapsed" data-toggle="collapse" aria-expanded="true">
                            <div class="p-4">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <i class="fas fa-receipt text-primary h2"></i>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h5 class="font-size-16 mb-1">訂單明細</h5>
                                        <p class="text-muted text-truncate mb-0">請填寫下方資料</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <i class="mdi fas fa-chevron-up font-size-24"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div id="checkout-billinginfo-collapse" class="collapse show">
                            <div class="p-4 border-top">
                                <div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="billing-first-name">姓氏 :</label>
                                                <input type="text" class="form-control necessary" id="billing-first-name" name="first_name" autocomplete="off" placeholder="請填寫姓氏">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="billing-name">名字 :</label>
                                                <input type="text" class="form-control necessary" id="billing-name" name="last_name" autocomplete="off" placeholder="請填寫名字">
                                                </div>
                                            </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="billing-email-address">聯絡信箱 :</label>
                                                <input type="email" class="form-control necessary" id="billing-email-address"  name="email" value="{{ auth()->user()->email }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="billing-phone">電話 :</label>
                                                <input type="text" class="form-control necessary" id="billing-phone" name="phone_number" autocomplete="off" placeholder="請填寫電話號碼,不用數入'-'號做區隔">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="billing-face-time">希望面交時間 :</label>
                                                <input type="date" class="form-control necessary" id="billing-face-time" name="face_time">
                                            </div>    
                                        </div>    
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label" for="billing-note">訂單備註 :</label>
                                            <textarea class="form-control" id="billing-note" name="notes" rows="6" placeholder="請輸入訂單備註"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <a href="#checkout-paymentinfo-collapse" class="text-dark collapsed" data-toggle="collapse" aria-expanded="true">
                            <div class="p-4">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <i class="fas fa-money-check-alt text-primary h2"></i>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h5 class="font-size-16 mb-1">付款資訊</h5>
                                        <p class="text-muted text-truncate mb-0">請選擇付款方式</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <i class="mdi fas fa-chevron-up font-size-24"></i>
                                    </div>
                                </div>   
                            </div>
                        </a>
                        <div id="checkout-paymentinfo-collapse" class="collapse show payment-info">
                             <div class="p-4 border-top">
                                <div class="type-block p-2">
                                    <h5 class="font-size-14 mb-3">付款方式 :</h5>
                                    <div class="row">
                                        @foreach($p_type as $type)
                                        <div class="col-lg-3 col-sm-6">
                                            <div data-toggle="collapse">
                                                <label class="card-radio-label">
                                                    <input type="radio" name="payment" id="pay-option{{$type["id"]}}" class="card-radio-input necessaryRadio" value="{{$type["id"]}}">
                                                    <span class="card-radio text-center text-truncate">
                                                        @if($type->id===1)
                                                        <i class="fas fa-hand-holding-usd d-block h2 mb-3"></i>
                                                        @elseif($type->id===2)
                                                        <i class="fab fa-line d-block h2 mb-3"></i>
                                                        @elseif($type->id===3)
                                                        <i class="fab fa-alipay d-block h2 mb-3"></i>
                                                        @endif
                                                        {{$type->name}}
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form> 
            </div>
            <div class="row my-4 confirm">
                <div class="col">
                    <a href="{{url()->previous()}}" class="btn btn-link text-muted">
                        <i class="fas fa-arrow-left me-1"></i> 
                            返回
                    </a>
                </div> <!-- end col -->
                <div class="col">
                    <div class="text-end mt-2 mt-sm-0">
                        <a href="javscript:void(0)" class="btn btn-confirm"  onclick="Pay()">
                            <i class="fas fa-check me-1"></i>
                                確認完成
                        </a>
                    </div>
                 </div> <!-- end col -->
            </div> <!-- end row-->
        </div>
        <div class="col-xl-4">
            <div class="card checkout-order-summary">
                <div class="card-body">
                    <div class="p-3 bg-light mb-4">
                        <h5 class="font-size-16 mb-0">訂單總計</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-centered mb-0 table-nowrap">
                            <thead>
                                <tr class="text-center">
                                    <th class="border-top-0"  scope="col">序號</th>
                                    <th class="border-top-0"  scope="col">商品</th>
                                    <th class="border-top-0"  scope="col">商品名稱</th>
                                    <th class="border-top-0" scope="col">價格</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $id => $product)
                                <tr class="text-center">
                                <th scope="row">{{$id+1}}</th>
                                    <td><img src="{{asset($product->images[0]->path)}}" alt="product-img" title="product-img" class="avatar"></td>
                                    <td>
                                        <h5 class="font-size-14 text-truncate"><a href="javscript:void(0)" class="text-dark">{{$product["name"]}}</a></h5>
                                        <p class="text-muted mb-0">{{$product["price"]}} x 1</p>
                                    </td>
                                    <td>$ {{$product["price"]}}</td>
                                </tr>
                                @endforeach                          
                                <tr class="bg-light mt-2">
                                    <td colspan="3">
                                        <h5 class="m-2 font-size-20">合計 :</h5>
                                    </td>
                                    <td class="text-danger text-center">
                                        $ {{$total}} 元
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>    
    </div>      
</div>            
@endsection

@section('sFrontEnd_Script')
@include('JS_Views.checkout.index')
@endsection    