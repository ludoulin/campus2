@php
    use App\Models\Problem;
@endphp
@extends('layouts.control_panel')
@section('title', '後台消息頁面')

@section('sass_backend')
<link href="{{ asset('css/backend/problem/index.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="problem-manage-card">
            <div class="problem-manage-header d-flex justify-content-between">
                <div class="problem-manage-header-title"> 
                    <h4 class="card-title">問題標題: {{$problem->title}}</h4>
                </div>
            </div>
            <div class="card-body problem-manage-body">
                <div class="row">
                        <div class="col-md-6">
                            <label for="problem-type">問題種類</label>
                            <div class="input-group">
                                <select class="form-control necessarySelect" name="type" id="problem-type" disabled>
                                    @foreach ($problem_types as $id => $problem_type)
                                        <option value="{{ $id }}" {{$problem->type === $id ?'selected':'' }}>{{ $problem_type }}</option>
                                    @endforeach
                                </select>
                            </div>    
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="problem-content">描述</label>
                            <textarea id="problem-content" class="form-control"
                                name="content" style="height:300px" disabled>{{ old('content', $problem->content) }}</textarea>
                        </div>
                        @if($problem->file)
                        <div class="col-md-12 mt-2">
                            <label for="problem-content">附件</label>
                            <br>
                            <img class="img-fluid rounded" width="1024" height="380" src="{{asset($problem->file)}}">
                      </div>
                      @endif
                      <div class="col-md-12 mt-2 text-right">
                            <a class="btn btn-secondary" href="{{ route('admin.problem.index') }}">返回</a>
                     </div>
                </div>
            </div>
        </div> 
    </div>
</div>
@endsection           