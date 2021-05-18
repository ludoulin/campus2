@php
    $isEditMode = isset($news);
@endphp

@extends('layouts.control_panel')

@if (!$isEditMode)
    @section('title', '新增消息')
@else
    @section('title', '編輯消息')
@endif

@section('sass_backend')
<link href="{{ asset('css/backend/news/index.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="news-manage-card">
            <div class="news-manage-header d-flex justify-content-between">
                <div class="news-manage-header-title"> 
                    <h4 class="card-title"> {{ !$isEditMode ? '新增消息' : '編輯消息'}}</h4>
                </div>
            </div>
            <div class="card-body news-manage-body">
                <div id="news-create-panel">
                    @if (!$isEditMode)
                    <form action="{{ route('admin.news.store') }}" method="POST" id="create_news" name="ceate_news" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                    @else
                    <form action="{{ route('admin.news.update', $news->id) }}" method="POST" id="edit_news" name="edit_news" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                    @method('PATCH')
                    @endif
                    @csrf
                        <div class="form-group">
                            @php
                                $value = $errors->any() ? 
                                        old('name') : 
                                        ($isEditMode ? $news->name : '')
                            @endphp
                                <label for="news-title">標題</label>
                                <input type="text" class="form-control {{ !$errors->has('name') ? : 'is-invalid' }}" 
                                        id="news-title" placeholder="輸入標題" name="name" value="{{ $value }}" autocomplete="off" required>
                                <div class="invalid-feedback">
                                    @if ($errors->has('name'))
                                    <span>{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                        </div>
                        <div class="form-group">
                            <div class="d-flex">
                                <div class="mr-3 w-100">
                                    @php
                                        $value = $errors->any() ? 
                                                old('news_type') : 
                                                ($isEditMode ? $news->type : '')
                                    @endphp
                                    <label for="news-classify">消息種類</label>
                                    <div class="input-group">
                                        <select class="form-control" name="type" id="news-classify" required>
                                            <option value="">--消息種類--</option>
                                            @foreach ($news_types as $id => $news_type)
                                            <option value="{{ $id }}" {{$value === $id ?'selected':'' }}>{{ $news_type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="invalid-feedback">
                                        @if ($errors->has('type'))
                                        <span>{{ $errors->first('type') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="w-100">
                                    <label for="news-publish-time">發布時間</label>
                                    <div class="input-group date">
                                        @php
                                            $value = $errors->any() ? 
                                                    old('publish_date') : 
                                                    ($isEditMode ? $news->publish_date : '')
                                        @endphp
                                        <input class="form-control datetimepicker-input datetime {{ !$errors->has('publish_date') ? : 'is-invalid' }}" 
                                                id="news-publish-time" data-toggle="datetimepicker" data-target="#news-publish-time" 
                                                type="text" name="publish_date" value="{{ $value }}" autocomplete="off" required>
                                        <div class="invalid-feedback">
                                            @if ($errors->has('publish_date'))
                                            <span>{{ $errors->first('publish_date') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>顯示時間</label>
                            <div class="d-flex align-items-start">
                                <div class="input-group mr-3">
                                    @php
                                        $value = $errors->any() ? 
                                                old('start_date') : 
                                                ($isEditMode ? $news->start_date : '')
                                    @endphp
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">開始</span>
                                    </div>
                                    <input class="form-control datetimepicker-input date-start {{ !$errors->has('start_date') ? : 'is-invalid' }}" 
                                            id="start-date" data-toggle="datetimepicker" data-target="#start-date" 
                                            type="text" name="start_date" value="{{ $value }}" autocomplete="off" required>
                                    <div class="invalid-feedback">
                                        @if ($errors->has('start_date'))
                                        <span>{{ $errors->first('start_date') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="input-group">
                                    @php
                                        $value = $errors->any() ? 
                                                old('end_date') : 
                                                ($isEditMode ? $news->end_date : '')
                                    @endphp
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">結束</span>
                                    </div>
                                     <input class="form-control datetimepicker-input date-end {{ !$errors->has('end_date') ? : 'is-invalid' }}"
                                            id="end-date" data-toggle="datetimepicker" data-target="#end-date" 
                                            type="text" name="end_date" value="{{ $value }}" autocomplete="off" required>
                                    <div class="invalid-feedback">
                                        @if ($errors->has('end_date'))
                                        <span>{{ $errors->first('end_date') }}</span> required
                                         @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-check custom-control custom-checkbox">
                            @php
                                $isSticky = $errors->any() ? 
                                            !!old('sticky_flag') : 
                                            ($isEditMode ? $news->sticky_flag : false)
                            @endphp
                            <input type="checkbox" class="custom-control-input" id="news-sticky"
                                    name="sticky_flag" value="1" {{ !$isSticky ? '': 'checked' }}>
                            <label class="custom-control-label" for="news-sticky">設為置頂</label>
                        </div>
                        <div class="form-group">
                            @php
                                $value = $errors->any() ? 
                                        old('content') : 
                                        ($isEditMode ? $news->content : '')
                            @endphp
                            <label>內容</label>
                            <textarea id="news-content" class="form-control {{ !$errors->has('content') ? : 'is-invalid' }}"
                                    name="content">{{ $value }}</textarea>
                            <div class="invalid-feedback">
                                @if ($errors->has('content'))
                                <span>{{ $errors->first('content') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <a class="btn btn-secondary" href="{{ route('admin.news.index') }}">返回</a>
                            <button type="submit" class="btn btn-primary">
                                {{ $isEditMode ? '編輯' : '新增'}}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>                
@endsection

@section('script2')
<script>
$(function () {
    initDateTimePicker()
    initTinymce()
    // 初始化 datetimepicker 套件
    function initDateTimePicker() {
        const elPublishDatePicker = $('.datetimepicker-input.datetime')
        const elDateStartPicker = $('.datetimepicker-input.date-start')
        const elDateEndPicker = $('.datetimepicker-input.date-end')

        const datetimeConfig = {
                format: 'YYYY-MM-DD',
                locale: 'zh-TW'
            } 

        elDateStartPicker.datetimepicker({
            ...datetimeConfig,
            }).on("dp.change", function (e) {
                    elPublishDatePicker.data("DateTimePicker").maxDate(e.date);
                    elDateEndPicker.data("DateTimePicker").minDate(e.date);
        })
                
        elDateEndPicker.datetimepicker({
            ...datetimeConfig,
            }).on("dp.change", function (e) {
                    elPublishDatePicker.data("DateTimePicker").maxDate(e.date);
                    elDateStartPicker.data("DateTimePicker").maxDate(e.date);
        })

        elPublishDatePicker.datetimepicker({
            ...datetimeConfig,
            }).on("dp.change", function (e) {
                    elDateStartPicker[0].value = elPublishDatePicker[0].value;
                    elDateStartPicker.data("DateTimePicker").minDate(e.date);
                    elDateEndPicker.data("DateTimePicker").minDate(e.date);
        })
    }
})
function initTinymce() {
        tinymce.init({
        selector: '#news-content',
        plugins: [
                    'advlist autolink link image lists charmap print preview hr anchor pagebreak',
                    'searchreplace wordcount visualblocks code fullscreen insertdatetime media nonbreaking',
                    'table emoticons template paste help'
                ],
        toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
                 'bullist numlist outdent indent | link image | print preview media fullpage | ' +
                 'forecolor backcolor emoticons | help',
        menu: {
                favs: {
                    title: 'My Favorites', 
                    items: 'code visualaid | searchreplace | emoticons'
                }
        },
        menubar: 'favs file edit view insert format tools table help',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
        language: 'zh_TW',
        automatic_uploads: true,
        file_picker_types: 'image',
        file_picker_callback: function (cb, value, meta) {

            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.onchange = function () {

                var file = this.files[0];
                var reader = new FileReader();

                reader.onload = function () {
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(',')[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);
                    cb(blobInfo.blobUri(), { title: file.name });
                };
                reader.readAsDataURL(file);
            };

            input.click();
        },
        path_absolute: "{{ route('admin.news.store') }}",
        height: 600,
     });
}    
</script>
@endsection