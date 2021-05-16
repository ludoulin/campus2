@php
    $isEditMode = isset($activity);
@endphp

@extends('layouts.control_panel')

@if (!$isEditMode)
    @section('title', '新增活動')
@else
    @section('title', '編輯活動')
@endif

@section('sass_backend')
<link href="{{ asset('css/backend/activity/index.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
         <div class="activity-manage-card">
                <div class="activity-manage-header d-flex justify-content-between">
                        <div class="activity-manage-header-title"> 
                            <h4 class="card-title"> {{ !$isEditMode ? '新增活動' : '編輯活動'}}</h4>
                        </div>
                </div>
                <div class="card-body activity-manage-body">
                                <div class="mt-1 alert alert-warning" role="alert">
                                        注：建議 宣傳圖 尺寸（1024x380）
                                </div>
                                    @if (!$isEditMode)
                                        <form action="{{ route('admin.activity.store') }}" id="create_activity" name="create_activity" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                                            <input type="hidden" name="_method" value="POST">
                                    @else
                                        <form action="{{ route('admin.activity.update', $activity->id) }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                                        @method('PATCH')
                                    @endif
                                        @csrf
                                        <div class="form-group">
                                            @php
                                                $value = $errors->any() ? 
                                                    old('name') : 
                                                    ($isEditMode ? $activity->name : '')
                                            @endphp

                                            <label for="activity-title">活動名稱:</label>
                                            <input type="text" class="form-control {{ !$errors->has('name') ? : 'is-invalid' }}" 
                                                id="activity-title" placeholder="輸入活動名稱" name="name" value="{{ $value }}" required>
                                            <div class="invalid-feedback">
                                                @if ($errors->has('name'))
                                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            @php
                                                $value = $errors->any() ? 
                                                    old('avatar') : 
                                                    ($isEditMode ? $activity->avatar : '')
                                            @endphp
                                            <label for="activity-avatar">活動宣傳圖(限一張呈現於首頁):</label>
                                            <input type="file" id="activity-avatar" class="form-control-file" name="avatar" value="{{ $value }}" accept="image/*"/>
                                            @if($isEditMode)
                                            <div class="mt-2">
                                            <img src="{{ asset($activity->avatar) }}" width="1024" height="380">
                                            </div>
                                            @endif
                                            @if($errors->has('avatar'))
                                                <span class="text-danger">{{ $errors->first('avatar') }}</span>
                                            @endif
                                        </div>    

                                        <div class="form-group">
                                            <div class="d-flex">
                                                <div class="mr-3">
                                                    @php
                                                        $value = $errors->any() ? 
                                                            old('year') : 
                                                            ($isEditMode ? $activity->year : '')
                                                    @endphp

                                                    <label for="activity-year">年度(民國):</label>
                                                    <input type="number" class="form-control {{ !$errors->has('year') ? : 'is-invalid' }}"
                                                        id="activity-year" placeholder="{{ now()->year - 1911 }}" name="year" value="{{ $value }}" required>
                                                    <div class="invalid-feedback">
                                                        @if ($errors->has('year'))
                                                            <span class="text-danger">{{ $errors->first('year') }}</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="position-relative">
                                                    @php
                                                        $value = $errors->any() ? 
                                                            old('end_date') : 
                                                            ($isEditMode ? $activity->end_date : '')
                                                    @endphp

                                                    <label for="activity-end-date">結束日期:</label>
                                                    <input type="text" class="form-control date {{ !$errors->has('end_date') ? : 'is-invalid' }}"
                                                        id="activity-end-date" name="end_date" value="{{ $value }}"
                                                        data-toggle="datetimepicker" data-target="#activity-end-date" required>
                                                    <div class="invalid-feedback">
                                                        @if ($errors->has('end_date'))
                                                            <span class="text-danger">{{ $errors->first('end_date') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            @php
                                                $value = $errors->any() ? 
                                                    old('content') : 
                                                    ($isEditMode ? $activity->content : '')
                                            @endphp
                                            
                                            <label>內容:</label>
                                            <textarea id="activity-content" class="form-control {{ !$errors->has('content') ? : 'is-invalid' }}"
                                                name="content" >{{ $value }}</textarea>
                                            <div class="invalid-feedback">
                                                @if ($errors->has('content'))
                                                    <span class="text-danger">{{ $errors->first('content') }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="text-right">
                                            <button type="submit" class="btn btn-primary">
                                                {{ $isEditMode ? '儲存' : '新增'}}
                                            </button>
                                            <a class="btn btn-secondary" href="{{ route('admin.activity.index') }}">返回</a>
                                        </div>
                                </form>
                        </div>
                </div>
        </div>
</div>    
@endsection


@section('script2')
<script>
$(function(){

    initDateTimePicker()
    initTinymce()

     // 初始化 datetimepicker 套件
    function initDateTimePicker() {
        $('#activity-end-date').datetimepicker({
            format: 'YYYY-MM-DD',
            locale: 'zh-TW'
        });
    }
})
function initTinymce() {
        tinymce.init({
        selector: '#activity-content',
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
        path_absolute: "{{ route('admin.activity.store') }}",
        height: 600,
     });
}    
</script>    
@endsection