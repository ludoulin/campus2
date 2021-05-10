@extends('layouts.basic')

@section('basic')
<link href="{{ asset('css/product/create.css') }}" rel="stylesheet">
@endsection

@section('content')
  <div class="container">
      <div class="col-md-10 offset-md-1">
          <div class="card ">
              <div class="card-body">
                  <h2 class="">
                      <i class="far fa-edit"></i>
                          @if($product->id)
                          編輯二手書資訊
                          @else
                          我要賣二手書
                          @endif
                  </h2>
                  <hr>
                  @if($product->id)
                  <form action="{{ route('products.update', $product->id) }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data" onsubmit="return BookForm()">
                        @method('PATCH')
                  @else
                  <form action="{{ route('products.store') }}" id="create_product" name="create_product" method="POST" accept-charset="UTF-8" enctype="multipart/form-data" onsubmit="return BookForm()">
                      <input type="hidden" name="_method" value="POST">
                  @endif
                      @csrf
                  @include('shared.error')
                      <div class="form-row">
                          <div class="form-group product-type-block col-md-12">
                              <label for="product_type" class="text-muted">* 拍賣類型：</label>
                              <div class="row type-block">
                                @foreach($product_types as $id => $product_type)
                                  <div class="custom-control custom-radio custom-control-inline ml-3">
                                      <input type="radio" class="custom-control-input necessaryRadio" id="product-type{{$id}}" name="product_type" value="{{$id}}" {{$product->type === $id ?'checked':'' }}>
                                      <label class="custom-control-label text-muted" for="product-type{{$id}}">{{$product_type}}</label>
                                  </div>
                                 @endforeach 
                              </div>
                          </div>

                          <div class="form-group col-md-6 isbn-block">
                              <label for="ISBN" class="text-muted">* ISBN： (10/13碼)</label>
                              <div class="input-group">
                                  <input id="ISBN" class="form-control necessary" type="text" name="isbn"  placeholder="請輸入ISBN" value="{{ old('isbn', $product->isbn ) }}"/>
                                  <div class="input-group-append">
                                      <button class="btn btn-primary" onclick="SearchIsbn()" type="button" id="isbn-button">查詢</button>
                                  </div>
                              </div>
                          </div>

                          <div class="form-group col-md-12 name-block">
                              <label for="name" class="text-muted">* 書名：</label>
                              <input id="name" class="form-control necessary" type="text" name="name" value="{{ old('name', $product->name ) }}" placeholder="請填寫書名"/>
                          </div>

                          <div class="form-group col-md-3 author-block">
                              <label for="author" class="text-muted">* 作者：</label>
                              <input id="author" class="form-control necessary" type="text" name="author"  placeholder="請填寫作者" />
                          </div>

                          <div class="form-group col-md-3">
                              <label for="price" class="text-muted">* 價格：</label>
                              <div class="input-group">
                                  <div class="input-group-prepend">
                                      <span class="input-group-text">$</span>
                                  </div>
                                  <input id="price" class="form-control necessary" type="text" name="price" value="{{ old('price', $product->price ) }}" placeholder="請填寫價格" />
                              </div>
                          </div>
                      </div>

                      <div class="form-row mb-2">
                          <div class="form-group col-md-6">
                              <label for="college" class="text-muted">* 學院：</label>
                              <div class="input-group">
                              <select class="form-control @if(!$product->id) necessaryMulitSelect @endif" name="college[]">
                                      <option value="0">--請選擇學院--</option>
                                      @foreach ($colleges as $value)
                                      <option value="{{ $value->id }}">{{ $value->name }}</option>
                                      @endforeach
                                  </select>
                              </div>
                          </div>

                          <div class="form-group col-md-6">
                              <label for="department" class="text-muted">* 系所：（可複選）每選完一次科系後請按下新增Tag</label>
                              <div class="input-group">
                                  <select name="department[]"  class="form-control @if(!$product->id) necessaryMulitSelect @endif">
                                      <option value="0">--請選擇科系--</option>
                                  </select>
                                  <div class="input-group-append">
                                      <button class="btn btn-outline-secondary ml-2" type="button" id="button-addon2">新增Tag</button>
                                  </div>
                              </div>
                          </div> 
                      </div>
               
                      <div class="form-group tags">
                          @if($product->id)
                            @foreach ($product->tags as $tag)
                               <div class="mdc-chip mr-1" role="row" style="color:#6129d6;background-color:#dfd4f7">
                                    <div class="mdc-chip__ripple"></div>
                                    <span role="gridcell">
                                        <span role="button" tabindex="0" class="mdc-chip__primary-action">
                                            <span class="mdc-chip__text">{{$tag->name}}</span>
                                        </span>
                                    </span>
                                    <span role="gridcell">
                                        <i id="{{$tag->id}}" class="material-icons mdc-chip__icon mdc-chip__icon--trailing r_tag" tabindex="-1" role="button">cancel</i>
                                   </span>
                              </div>
                            @endforeach
                              <select class="form-control hide" id="id_select2_demo1" name="departments[]" style="width:800px" multiple="multiple">
                                  @foreach ($product->tags as $tag)
                                    <option value="{{ $tag->id }}" selected>{{ $tag->name }}</option>
                                  @endforeach
                              </select>  
                              <select class="form-control hide" id="add_select2" name="add_departments[]" style="width:800px" multiple="multiple"></select>
                              <select class="form-control hide" id="remove_select2" name="remove_departments[]" style="width:800px" multiple="multiple"></select>
                            @else
                               <select class="form-control hide" id="id_select2_demo1" name="departments[]" style="width:800px" multiple="multiple"></select>
                            @endif
                      </div>

                      <div class="form-row mb-2">
                        <div class="form-group col-md-6">
                            <label for="college" class="text-muted">* 課程分類：</label>
                            <div class="input-group">
                                <select class="form-control necessarySelect" name="course_type">
                                    <option value="0">--請選擇課程分類--</option>
                                    @foreach ($course_types as $id => $course_type)
                                    <option value="{{ $id }}" {{$product->course_type === $id ?'selected':'' }}>{{ $course_type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                      </div>   

                      <div class="form-group">
                          <label for="content" class="text-muted">* 書況：</label>
                          <textarea id="content" name="content" class="form-control necessaryTextArea" rows="6" placeholder="請填入書況說明,至少3個字。">{{ old('content', $product->content ) }}</textarea>
                      </div>

                      <div class="form-row many">
                          <div class="form-group control-group increment" >
                              <label for="images" class="text-muted">* 商品圖片上傳：</label>
                              <div class="form-row inner-row">
                              @if(!$product->id)  
                                  <div class="input-group col-md-4 mb-2 count">
                                      <div class="preview">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <input class="file-upload form-control necessaryFile" type="file" name="images[]" />
                                      </div>
                                  </div>
                              @else
                              @foreach ($product->images as $image)
                                  <div class="input-group col-md-4 mb-2 count">
                                      <div class="edit_preview">
                                          <img class="keep_image"id="{{ $image->id }}"src="{{ url($image->path) }}"/>
                                      </div>
                                      <div class="input-group-append"> 
                                          <button class="btn btn-danger remove_image" type="button" data-target="#btn-delete-modal-{{ $image->id }}"><i class="fas fa-trash-alt"></i>刪除照片</button>
                                      </div>   
                                  </div>
                              @endforeach
                                  <select class="form-control hide" id="image_select2" name="remove_images[]" style="width:800px" multiple="multiple"></select>
                              @endif
                              </div>
                            </div>
                            @include('product.inputFile')
                        </div> 
                        
                        @include('product.tagModal')
                
                        <div class="well well-sm">
                            <button class="btn btn-success" type="button"> <i class="fas fa-plus pr-2"></i>新增圖片</button>
                            @if(!$product->id)  
                            <button type="submit" class="btn btn-primary"><i class="fas fa-file-import pr-2" aria-hidden="true"></i>刊登商品</button>
                            @else 
                            <button type="submit" class="btn btn-primary edit"><i class="far fa-save pr-2" aria-hidden="true"></i>編輯完成</button>
                            @endif 
                            <a href="{{ url()->previous() }}" class="btn btn-secondary float-right"><i class="fas fa-door-open pr-2"></i>回上一頁</a>
                        </div>
                  </form>
              </div>
          </div>
      </div>
  </div>

@endsection


@section('script')

@include('JS_Views.product.create_and_edit')

@endsection

