@extends('layouts.basic')

@section('basic')

@endsection

@section('content')
<section class="section-content bg padding-y">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                @if (Session::has('error'))
                    <p class="alert alert-danger">{{ Session::get('error') }}</p>
                @endif
            </div>
        </div>
        <form action="{{ route('order.create') }}" method="POST" role="form" accept-charset="UTF-8" enctype="multipart/form-data">
            <input type="hidden" name="p_id" value="{{$product->id}}">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <header class="card-header">
                            <h4 class="card-title mt-2">訂單明細</h4>
                        </header>
                        <article class="card-body">
                            <div class="form-row">
                                <div class="col form-group">
                                    <label>姓:</label>
                                    <input type="text" class="form-control" name="first_name" required>
                                </div>
                                <div class="col form-group">
                                    <label>名字:</label>
                                    <input type="text" class="form-control" name="last_name" required>
                                </div>
                            </div>
                            
                            <div class="form-row">
                               
                                <div class="form-group  col-md-6">
                                    <label>電話號碼:</label>
                                    <input type="text" class="form-control" name="phone_number">
                                </div>

                                <div class="form-group  col-md-6">
                                    <label>希望面交時間:</label>
                                    <input type="date" class="form-control" name="face_time" required>
                                </div>

                            </div>

                            <div class="form-group">
                                <label class="d-block" >付款方式:</label>
                                @foreach($product->user->payment_types as $type)
                                    <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="payment{{$type->id}}" name="payment" class="custom-control-input" value="{{$type->id}}">
                                        <label class="custom-control-label" for="payment{{$type->id}}">{{$type->name}}</label>
                                    </div>
                                @endforeach    
                            </div>

                            <div class="form-group">
                                <label>信箱:</label>
                                <input type="email" class="form-control" name="email" value="{{ auth()->user()->email }}" disabled>
                                <small class="form-text text-muted">我們不會洩漏您的個資.</small>
                            </div>
                            <div class="form-group">
                                <label>訂單備註:</label>
                                <textarea class="form-control" name="notes" rows="6"></textarea>
                            </div>
                        </article>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <header class="card-header">
                                    <h4 class="card-title mt-2">訂單確認</h4>
                                </header>
                                <article class="card-body">
                                    <dl class="dlist-align">
                                    <dt>總共花費: {{$product->price}}</dt>
                                    </dl>
                                </article>
                            </div>
                        </div>
                        <div class="col-md-12 mt-4">
                            <button type="submit" class="subscribe btn btn-success btn-lg btn-block">確認送出</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

@endsection