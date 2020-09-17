@php
    use Carbon\Carbon;
@endphp
@extends('layouts.control_panel')
@section('title', '使用者管理')

@section('sass_backend')
<link href="{{ asset('css/backend/user/index.css') }}" rel="stylesheet">
@endsection

@section('content')
<!-- Listing table -->
<div class="row">
        <div class="col-sm-12">
            <div class="cust-table-cont">
            <div class="table-responsive">
              <table border="0" class="table cust-table"> 
                <thead>
                    <tr style="" class="text-center">
                      <th style="width:80px;">#</th> 
                      <th style="width:150px;" ><li class="fa fa-gear"></li>功能</th>  
                      <th style="width:150px;">顯示名稱</th> 
                      <th style="width:250px;">Email</th> 
                      <th style="width:120px;">權限設置</th>  
                      <th style="width:200px;">更新時間</th>                      
                    </tr>
                  </thead>
                  <tbody>
                        @foreach ($users as $user)
                    <tr class="text-center"> 
                      <td scope="row" style="width:80px;">{{ $loop->iteration }}</th>
                      <td style="width:150px;" class="text-center">
                            @if ($user->is_admin)
                            最高管理員
                            @else 
                        <button class="btn btn-outline-danger del-icon"><span class="fa fa-trash-o"></span></button> <button class="btn btn-outline-success"><span class="fa fa-pencil"></span></button></td>
                        @endif
                      <td style="width:150px;">{{ $user->name }}</td>
                      <td style="width:250px;">{{ $user->email }}</td>
                      <td style="width:120px;">
                         @if ($user->isAdmin())
                            管理員權限
                         @else 
                            一般使用者
                         @endif
                        </td>
                      <td style="width:200px;">{{ $user->updated_at && $user->updated_at->ne(new Carbon('0000-00-00')) ? 
                            $user->updated_at->format('Y-m-d H:i') : null }}</td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
            </div> <!-- End of cust-table-cont block -->
        </div>
    </div> <!-- ENd of row -->
    

    {{-- <div id="control-panel-landing-page">
            <div class="box text-center">
                <h1>二手書交易推播平台</h1>
                <h3 class="mt-3">使用者管理系統</h3>
            </div>
        </div> --}}
@stop