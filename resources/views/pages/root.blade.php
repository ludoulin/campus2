@extends('layouts.basic')
@section('title', '首頁')
@section('content')
 <div class="row">
         @foreach ($products as $product)
                <div class="col-3">
                        <div class="card" onclick="location.href='{{route('products.show', $product->id)}}';" style="width: 18rem;">
                          <img src="{{$product->image}}" class="card-img-top" alt="{{$product->name}}">
                          <div class="card-body">
                           <h5 class="card-title">{{$product->name}}</h5>
                            <br>
                               <div style="float:left">{{$product->created_at}}</div>
                               <div style="float:right">${{$product->product_price}}</div>
                              </div>
                                   </div>
                </div>
      @endforeach
            </div>
@endsection