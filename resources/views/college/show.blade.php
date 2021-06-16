@extends('layouts.basic')

@section('title', $college->name)

@section('basic')
<link href="{{ asset('css/college/show.css') }}" rel="stylesheet">
@endsection


@section('content')
<div class="container-fluid" id="college">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0">{{$college->name}}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        @foreach($college->departments as $index => $department)
        <div class="col-xl-4 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="flex-shrink-0 me-4">
                            <div class="avatar-sm">
                                <span class="avatar-title bg-soft-primary text-primary font-size-16 rounded-circle">
                                        {{$index + 1}}
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1 align-self-center">
                            <div class="border-bottom pb-1">
                                <h5 class="text-truncate font-size-16 mb-1"><a href="{{ route('department.show', $department->id) }}" class="text-dark">{{$department->name}}</a></h5>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="mt-3 text-center">
                                        <p class="text-muted mb-2">商品總數</p>
                                        <h5 class="font-size-16 mb-0">{{$department->products->count()}}</h5>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mt-3 text-center">
                                        <p class="text-muted mb-2 text-center">目前售出</p>
                                        <h5 class="font-size-16 mb-0">{{$department->products->where('status', '=' , 3 )->count()}} 件</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>    
</div>
@endsection