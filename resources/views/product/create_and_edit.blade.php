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
            <form action="{{ route('products.update', $product->id) }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                @method('PATCH')
          @else
            <form action="{{ route('products.store') }}" id="create_product" name="create_product" method="POST" accept-charset="UTF-8" enctype="multipart/form-data" onsubmit="return BookForm()">
                <input type="hidden" name="_method" value="POST">
          @endif
             @csrf
              @include('shared.error')



              <div class="form-row">

                <div class="form-group product-type-block col-md-12">
                <label for="product_type" class="text-muted">* 拍賣類型</label>
                  <div class="row type-block">
                  @foreach($product_types as $id => $product_type)
                  <div class="custom-control custom-radio custom-control-inline ml-3">
                      <input type="radio" class="custom-control-input necessaryRadio" id="product-type{{$id}}" name="product_type" value="{{$id}}">
                      <label class="custom-control-label text-muted" for="product-type{{$id}}">{{$product_type}}</label>
                  </div>
                  @endforeach 
                </div>
                </div>    

              <div class="form-group col-md-6 isbn-block">
                  <label for="ISBN" class="text-muted">* ISBN : (10/13碼)</label>
                  <div class="input-group">
                  <input id="ISBN" class="form-control necessary" type="text" name="isbn"  placeholder="請輸入ISBN" value="{{ old('isbn', $product->isbn ) }}"/>
                  <div class="input-group-append">
                    <button class="btn btn-primary" onclick="SearchIsbn()" type="button" id="isbn-button">查詢</button>
                  </div>
                </div>
              </div>  

              <div class="form-group col-md-12 name-block">
                <label for="name" class="text-muted">* 書名 :</label>
                <input id="name" class="form-control necessary" type="text" name="name" value="{{ old('name', $product->name ) }}" placeholder="請填寫書名"/>
              </div>

              <div class="form-group col-md-3 author-block">
                <label for="author" class="text-muted">* 作者 :</label>
                <input id="author" class="form-control necessary" type="text" name="author"  placeholder="請填寫作者" />
              </div>

              <div class="form-group col-md-3">
                <label for="price" class="text-muted">* 價格 :</label>
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
                    <label for="college" class="text-muted">* 學院 :</label>
                    <div class="input-group">
                    <select class="form-control necessarySelect" name="college[]">
                      <option value="0">--請選擇學院--</option>
                      @foreach ($colleges as $value)
                      <option value="{{ $value->id }}">{{ $value->name }}</option>
                      @endforeach
                    </select>
                    </div>
                 </div> 
               
                 <div class="form-group col-md-6">
                    <label for="department" class="text-muted">* 系所 :（可複選）每選完一次科系後請按下新增Tag</label>
                    <div class="input-group">
                    <select name="department[]"  class="form-control necessarySelect">
                      <option value="0">--請選擇科系--</option>
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary ml-2" type="button" id="button-addon2">新增Tag</button>
                      </div>
                    </div>
                 </div> 
                </div>
               



                <div class="form-group tags">
                    {{-- <label for="department-selected" class="text-muted">你所選擇的系所:</label> --}}
                  @if($product->id)
                    @foreach ($product->tags as $tag)
                      <div class="mdc-chip mr-1" role="row" style="color:#6129d6;background-color:#dfd4f7">
                          <div class="mdc-chip__ripple"></div>
                          <span role="gridcell">
                            <span role="button" tabindex="0" class="mdc-chip__primary-action">
                              <span class="mdc-chip__text">{{$tag->department->name}}</span>
                            </span>
                          </span>
                          <span role="gridcell">
                          <i id="{{$tag->department->id}}"class="material-icons mdc-chip__icon mdc-chip__icon--trailing r_tag" tabindex="-1" role="button">cancel</i>
                          </span>
                        </div>
                      @endforeach
                    <select class="form-control hide" id="id_select2_demo1" name="departments[]" style="width:800px" multiple="multiple">
                        @foreach ($product->tags as $tag)
                        <option value="{{ $tag->department->id }}" selected>{{ $tag->department->name }}</option>
                        @endforeach
                    </select>  
                    <select class="form-control hide" id="add_select2" name="add_departments[]" style="width:800px" multiple="multiple"></select>
                    <select class="form-control hide" id="remove_select2" name="remove_departments[]" style="width:800px" multiple="multiple"></select>
                   @else
                   <select class="form-control hide" id="id_select2_demo1" name="departments[]" style="width:800px" multiple="multiple">
                  
                  </select>
                  @endif
                </div>

                        

              <div class="form-group">
                <label for="content" class="text-muted">* 書況:</label>
                <textarea id="content" name="content" class="form-control necessaryTextArea" rows="6" placeholder="請填入書況說明,至少3個字。">{{ old('content', $product->content ) }}</textarea>
              </div>

                <div class="form-row many">
                <div class="form-group control-group increment" >
                    <label for="images" class="text-muted">* 商品圖片上傳:</label>
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

                  <div class="clone hide">
                      <div class="input-group col-md-4 mb-2">
                      <div class="preview">
                          <i class="fas fa-cloud-upload-alt"></i>
                          <input class="file-upload form-control" type="file" name="images[]"/>
                      </div>
                      <div class="input-group-append"> 
                        <button class="btn btn-secondary remove" type="button"><i class="fas fa-backspace mr-1"></i></i>移除新增</button>
                      </div>
                      </div>
                  </div>
                </div> 
                
              
              
              <div class="tag_model">
                <div class="mdc-chip mr-1" role="row">
                    <div class="mdc-chip__ripple"></div>
                    <span role="gridcell">
                      <span role="button" tabindex="0" class="mdc-chip__primary-action">
                        <span class="mdc-chip__text">Jane Smith</span>
                      </span>
                    </span>
                    <span role="gridcell">
                      <i class="material-icons mdc-chip__icon mdc-chip__icon--trailing r_tag" tabindex="-1" role="button">cancel</i>
                    </span>
                  </div>
                </div>


              <div class="well well-sm">
                <button class="btn btn-success" type="button"> <i class="fas fa-plus mr-2"></i>新增圖片</button>
                @if(!$product->id)  
                <button type="submit" class="btn btn-primary"><i class="fas fa-file-import mr-2" aria-hidden="true"></i>刊登商品</button>
                @else 
                <button type="submit" class="btn btn-primary edit"><i class="far fa-save mr-2" aria-hidden="true"></i>編輯完成</button>
                @endif 
                <a href="{{ url()->previous() }}" class="btn btn-secondary float-right">回上一頁</a>
              </div>
            </form>
        </div>
      </div>
    </div>
  </div>

@endsection


@section('script')
<script>
   function Loadslick(element,title){
    
    $(element).select2({
    placeholder: title,
    tags:true,
    allowClear: true
    }).next().hide();

   }

  $(document).ready(function() {

    Loadslick('#id_select2_demo1',"請確認系所Tag");

    Loadslick('#add_select2',"請確認新增系所Tag");

    Loadslick('#remove_select2',"請確認移除系所Tag");

    Loadslick('#image_select2',"請確認移除的照片");


    const max_input = 6;

    let y = $('.count').length;

    let t_selected_array = $('#id_select2_demo1 option:selected').toArray().map(item=>item.text);

    let add_selected_array = $('#add_select2 option:selected').toArray().map(item=>item.text);
    
    let remove_selected_array = $('#remove_select2 option:selected').toArray().map(item=>item.text);

    let remove_image_array = $('#image_select2 option:selected').toArray().map(item=>item.text);
    

    // console.log(t_selected_array);

    // console.log(document.getElementsByClassName("keep_image").length);

    document.querySelector('#product-type0').checked = true;

    $('input[name="product_type"]').on("change",function(){

        let value = $(this).val();

        if(value==="0"){

          if(document.getElementsByClassName("isbn-block").length===0){

              $('.product-type-block').after('<div class="form-group col-md-6 isbn-block"><label for="ISBN" class="text-muted">* ISBN : (10/13碼)</label><div class="input-group"><input id="ISBN" class="form-control necessary" type="text" name="isbn"  placeholder="請輸入ISBN" value="{{ old('isbn', $product->isbn ) }}"/><div class="input-group-append"><button class="btn btn-primary" onclick="SearchIsbn()" type="button" id="isbn-button">查詢</button></div></div></div>');
              
              }

          if(document.getElementsByClassName("author-block").length===0){

              $('.name-block').after('<div class="form-group col-md-3 author-block"><label for="author" class="text-muted">* 作者 :</label><input id="author" class="form-control necessary" type="text" name="author"  placeholder="請填寫作者" /></div>')
 
          }

          return
        
        }else if(value==="1"){

          $(".isbn-block").remove();

          if(document.getElementsByClassName("author-block").length===0){

            $('.name-block').after('<div class="form-group col-md-3 author-block"><label for="author" class="text-muted">* 作者 :</label><input id="author" class="form-control necessary" type="text" name="author"  placeholder="請填寫作者" /></div>')
             
          }

          return
          // $('#btn-CancelStatus-modal .modal-body').append('<div class="form-group reason"><label class="text-danger" for="cancelReason">請填寫拒絕理由</label><textarea class="form-control" id="cancelReason" name="reason" rows="3" required></textarea>');
          
        }else if(value==="2"){

          $(".isbn-block, .author-block").remove();
        }

        return

        })  
  
  
    $(".btn-success").click(function(){ 
      if(y<max_input){

        if($(".many").find(".hint")){
            $(".many").find(".hint").remove(); 
           }

        const html = $(".clone").find('.input-group').clone(true).appendTo('.inner-row');

        html.find("input").addClass('necessaryFile');

  
         if(document.getElementById("image_select2")){
            html.find("input").attr("name", "new_images[]")
        }

        y++;

        if(y==max_input){
        $(".btn-success").attr('disabled', true);
        }
      }
      return false
    });

    $("body").on("click",".remove",function(){ 
      if(y>1){
        if(y==max_input){
          $(".btn-success").attr('disabled', false);
        }
        $(this).parents(".input-group").remove();
        y--;
      }else{
       
        $(this).parents(".increment").append('<div class="hint">提醒:至少要有一張照片</div>');

      }
    });

    $("body").on("click",".r_tag",function(){

       const tag_text = $(this).parents(".mdc-chip").find(".mdc-chip__text").text();

       const tag_ndx = t_selected_array.indexOf(tag_text);

       if(document.getElementById("remove_select2")){

       const tag_id = $(this).attr("id");

       if(add_selected_array.indexOf(tag_text)=== -1&&t_selected_array.length>1){

       remove_selected_array.push(tag_text);

       console.log(remove_selected_array);
            
       $('#remove_select2').append('<option value="'+ tag_id +'" selected>' + tag_text + '</option>').trigger('change.select2');
     
       }else{
            
        $("#add_select2 option:selected").filter(function(){
                return $.trim($(this).text()) == tag_text
                 }).remove();
    
                add_selected_array.splice(add_selected_array.indexOf(tag_text),1);

       }

    }

         if(tag_ndx!==-1&&t_selected_array.length>1){


          $("#id_select2_demo1 option:selected").filter(function(){
                return $.trim($(this).text()) == tag_text
          }).remove();
           
          t_selected_array.splice(tag_ndx,1);

          $(this).parents(".mdc-chip").remove();
          
       }else{
          
        $(this).parents(".tags").append('<div class="hint">提醒:至少要有一個tag</div>');

       }
       
       console.log(t_selected_array);
      
    });



   $('select[name="college[]"]').on("change",function(){
      var collegeId = $(this).val();
      var collegeName = $('select[name="college[]"] option:selected').text();
      console.log(collegeName);
      if(collegeId){
         $.ajax({
           url: 'http://localhost/campus2/public/department/get/'+collegeId,
           type: "GET",
           dataType: "json",
          
           success: function(data){

               $('select[name="department[]"]').empty();

               $.each(data, function(key, value){
                  
                  $('select[name="department[]"]').append('<option value="'+ key +'">' + value + '</option>');

               });
           },

         });
      }else{

        $('select[name="department[]"]').empty();

      }

   });
          
    $(".btn-outline-secondary").click(function(){ 

      let c_id = $('select[name="college[]"]').val();

      let d_id = $('select[name="department[]"]').val();

      let d_name = $('select[name="department[]"] option:selected').text();

      if(d_id == 0 || c_id == 0){

        MessageObject.VaildSubmitMessage("發生錯誤","請選擇指定學院系所後再按下新增Tag");

        return false

      }
  
      if(t_selected_array.indexOf(d_name) === -1){

        if($(".tags").find(".hint")){
                    
            $(".tags").find(".hint").remove();
                
        }
        
        if($(".tags").find(".error")){

          $(".tags").find(".error").remove();

        }

       t_selected_array.push(d_name);
       
       $('#id_select2_demo1').append('<option value="'+ d_id +'" selected>' + d_name + '</option>').trigger('change.select2');

       let copy = $(".tag_model").find('.mdc-chip').clone(true);

       copy.find('.mdc-chip__text').text(d_name);
       
       $('.tags').append(copy);
         
         if(document.getElementById("add_select2")){

           if(remove_selected_array.indexOf(d_name)=== -1){

            add_selected_array.push(d_name);


            $('#add_select2').append('<option value="'+ d_id +'" selected>' + d_name + '</option>').trigger('change.select2');

           }else{

            $("#remove_select2 option:selected").filter(function(){
                return $.trim($(this).text()) == d_name
                 }).remove();
    
                remove_selected_array.splice(remove_selected_array.indexOf(d_name),1);

           }

         }


      }


    });

function preview2(el) {

  var file = el.files[0];

  let check_image = $(el).siblings("img");
  
  let check_icon = $(el).siblings("i"); 

  var reader = new FileReader()

  reader.onload = function(e) {

  var $img = $('<img>').attr("src", e.target.result)

  $img.on('click', function(event) {
              $(event.target).siblings(".file-upload").click();
                  });
               
  if(check_image.length!==0){

   $(el).siblings("img").remove();
      console.log("圖片更換");
  }
   
  $(el).parents('.preview').append($img);

  }

  reader.readAsDataURL(file)
  }


  $('[type=file]').change(function(e) {
 
        preview2(e.target);

  })

  $(".preview").on('click', function(e) {

    $(e.target).find(".file-upload").click();

   });


   $(".remove_image").on('click', function(e) {

    if(document.getElementsByClassName("keep_image").length>1){
    
    const image_id = $(e.target).parents(".input-group").find("img").attr("id");

    remove_image_array.push(image_id);


    $('#image_select2').append('<option value="'+ image_id +'" selected>' + image_id + '</option>').trigger('change.select2');

    $(e.target).parents(".input-group").remove();

    if(y==max_input){
          $(".btn-success").attr('disabled', false);
        }

    y--;

    }else{

      $(this).parents(".increment").append('<div class="hint">提醒:至少要保存一張原始照片</div>');

    }

  }); 

  });

  function SearchIsbn(){

    let number = document.getElementById("ISBN").value;

    if(number === ""){

      MessageObject.VaildSubmitMessage("查詢發生錯誤","不可以沒輸入ISBN碼按下查詢");

      $("#ISBN").addClass("is-invalid");

      return false

    }

    $.ajax({
           url: `https://www.googleapis.com/books/v1/volumes?q=isbn:${number}&key=AIzaSyCHZb02CUvtHrRXIk5qB7p_c2tz4G-sMic`,
           type: "GET",
           crossDomain: true,
           dataType: "jsonp",
          
           success: function(data){
            
                console.log(data);

              $("#ISBN").removeClass("is-invalid");  

              if(data.hasOwnProperty('items')){

                    document.getElementById("name").value = data.items[0].volumeInfo.hasOwnProperty('subtitle') ? data.items[0].volumeInfo.title + data.items[0].volumeInfo.subtitle : data.items[0].volumeInfo.title;


                  if(data.items[0].volumeInfo.hasOwnProperty('authors')){

                    if(data.items[0].volumeInfo.authors.length==1){

                        document.getElementById("author").value = data.items[0].volumeInfo.authors[0]

                       }

                     else if(data.items[0].volumeInfo.author.length > 1){

                        document.getElementById("author").value = data.items[0].volumeInfo.authors.join();

                       }
                     else{

                        MessageObject.OtherMessage("warning","沒有作者資料","請自行輸入");

                      }
                }

             } else{
              
              $("#ISBN").addClass("is-invalid");

              MessageObject.VaildSubmitMessage("找不到此書資料","ISBN錯誤或是此書並無存在於Google資料庫");

              return false

            }

      
              return true

           },
           error: function (error) {

            MessageObject.VaildSubmitMessage("找不到此書資料","ISBN錯誤或是此書並無存在於Google資料庫");

            return false
          }

         });

    return     
  }
  
  function BookForm(){

     return ValidateForm() && IsbnValidate() && PriceValidate() && ContentValidate()
  }
  function IsbnValidate(){

    let regx = /^([0-9]{10}|[0-9]{13})$/;

    let isbn = document.getElementById("ISBN").value;

      if(!regx.test(isbn)){

        MessageObject.VaildSubmitMessage("驗證錯誤","ISBN碼只能為10或13碼的數字");

        return false

      }

      if(isbn.length==10){

        let sum = 0;

        const isbn10 = isbn.split('');

        for(let i = 0,j=isbn.length;i<isbn.length,j>0;i++,j--){

            sum = sum + isbn10[i]*j;

        }
        
        if(!(sum % 11 === 0)){

          MessageObject.VaildSubmitMessage("驗證錯誤","ISBN碼不存在");

          return false

        }

      }

      else if(isbn.length==13){

        let sum = 0;

        const isbn13 = isbn.split('');

        console.log(isbn13);

        for(let i = 0; i < isbn.length-1; i++){        
            if(i % 2 == 0){ 

              sum = sum+isbn13[i]*1
        
             } 
            else{
              
              sum = sum+isbn13[i]*3

            } 
          }


          sum = sum+ Number(isbn13[12]);

          console.log(sum);

          if(!(sum % 10 === 0)){

            MessageObject.VaildSubmitMessage("驗證錯誤","ISBN碼不存在");

            return false

          }

      }
       
      return true

  }

  function PriceValidate(){
      
      let regx = /^\+?[1-9][0-9]*$/;

      if(!regx.test(document.getElementById("price").value)){

        $("#price").addClass("is-invalid");

        MessageObject.VaildSubmitMessage("驗證錯誤","價格只能為正整數");

          return false
      }
      
      return true
  }

  function ContentValidate(){
      
      let content = document.getElementById("content").value

      if(content.length < 3 ){

        $("#content").addClass("is-invalid");

        MessageObject.VaildSubmitMessage("驗證錯誤","內容至少要3個字");

          return false
      }
      
      return true
  }
</script>
@endsection

