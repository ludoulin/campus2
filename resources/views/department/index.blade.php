@extends('layouts.basic')
@section('title', isset($department) ? $department->name : '錯誤')
@section('content')
<div class="container">
 <div class="row">
    <h3>{{$department->name}}</h3>
         @foreach ($products as $product)
           {{-- --{{$product->product->images}}-- --}}
                <div class="col-3">
                        <div class="card" onclick="location.href='{{route('products.show', $product->product->id)}}';" style="width: 18rem;">
                          <img src="{{$product->product->images[0]->path}}" class="card-img-top" alt="{{$product->product->name}}">
                          <div class="card-body">
                           <h5 class="card-title">{{$product->product->name}}</h5>
                           {{ $product->product->user->name }}
                            <br>
                               <div style="float:left">{{$product->product->created_at}}</div>
                               <div style="float:right">${{$product->product->price}}</div>
                              </div>
                        </div>
                </div>
      @endforeach
            </div>
</div>
@endsection