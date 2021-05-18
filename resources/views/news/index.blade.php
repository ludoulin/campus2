@php
   use App\Models\News;
@endphp

@extends('layouts.basic')

@section('basic')
<link href="{{ asset('css/news/index.css') }}" rel="stylesheet">
@endsection

@section('content')

@include('pages.banner',['activities' => $activities])

<div class="container mt-3">
        <h2><i class="fas fa-bullhorn pr-2"></i>全部消息</h2>
        <table class="table news-list-container mt-3">
          <thead>
              <tr>
                  <th scope="col">發布日期</th>
                  <th scope="col">標題</th>
              </tr>
          </thead>
          <tbody>
              @foreach ($newsCollection as $news)
                <tr>
                    <th class="year-th align-middle">
                          {{ $news->publish_date->toDateString() }}
                    </th>
                    <td class="align-middle">
                      <div class="d-flex nowrap">
                        @if ($news->sticky_flag)
                            <span class="badge badge-salmon text-white p-2 mr-1">置頂</span>
                        @endif

                        @if ($news->type)
                            <span class="badge badge-info text-white p-2 mr-1">{{News::NEWS_TYPES[$news->type]}}</span>
                        @endif
                        
                        <a href="{{route("news.show",$news->id)}}" class="text-primary">
                            <b>[{{ $news->name }}]</b>
                        </a>
                      </div>
                    </td>
                </tr>
              @endforeach
              @if($newsCollection->isEmpty())
                <tr>
                    <td colspan="999">尚無任何消息</td>
                </tr>
              @endif
        </tbody>
    </table>
    <div class="page-links mt-4 d-flex justify-content-center">
                {{ $newsCollection->links() }}
    </div>
</div> 

@endsection