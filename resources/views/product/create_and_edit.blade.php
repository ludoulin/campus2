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
            <form action="{{ route('products.store') }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="POST">
          @endif
             @csrf
              @include('shared.error')

              <div class="form-row">

              <div class="form-group col-md-6">
                <label for="name">書名:</label>
                <input id="name" class="form-control" type="text" name="name" value="{{ old('name', $product->name ) }}" placeholder="請填寫書名" required />
              </div>

              <div class="form-group col-md-5">
                <label for="price">價格:</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                <input id="price" class="form-control" type="text" name="price" value="{{ old('price', $product->price ) }}" placeholder="請填寫價格" required />
                </div>
              </div>
              </div>
            

              <div class="form-row mb-2">

                 <div class="form-group col-md-6">
                    <label for="college">學院:</label>
                    <div class="input-group">
                    <select class="form-control" name="college[]" required>
                      <option value="">--請選擇學院--</option>
                      @foreach ($colleges as $value)
                      <option value="{{ $value->id }}">{{ $value->name }}</option>
                      @endforeach
                    </select>
                    </div>
                 </div> 


                 <div class="form-group col-md-6">
                    <label for="department">系所:</label>
                    <div class="input-group">
                    <select name="department[]"  class="form-control"  required>
                      <option value="0">--請選擇科系--</option>
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="button-addon2">新增Tag</button>
                      </div>
                    </div>
                 </div> 

                </div>

                <div class="form-group tags">
                <select class="form-control hide" id="id_select2_demo1" name="departments[]" style="width:800px" multiple="multiple" >
                </select>
                </div>

              <div class="form-group">
                <label for="content">書況:</label>
                <textarea id="content" name="content" class="form-control" rows="6" placeholder="請填入書況說明,至少3個字。" required>{{ old('content', $product->content ) }}</textarea>
              </div>

                <div class="form-row many">
                <div class="form-group control-group increment" >
                    <label for="images">商品圖片上傳:</label>
                    <div class="form-row inner-row">
                    <div class="input-group col-md-4 mb-2">
                        <div class="preview">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <input class="file-upload form-control" type="file" name="images[]" required/>
                        </div>
                     </div>

                    </div>
                  </div>


                  <div class="clone hide">
                      <div class="input-group col-md-4 mb-2">
                      <div class="preview">
                          <i class="fas fa-cloud-upload-alt"></i>
                          <input class="file-upload form-control" type="file" name="images[]"/>
                      </div>
                      <div class="input-group-append"> 
                        <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                      </div>
                      </div>
                  </div>
                </div> 
                
              <div class="tag_model">
                <div class="mdc-chip mdc-chip--selected mr-1" role="row">
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
                  <button class="btn btn-success" type="button"> <i class="fas fa-plus mr-2"></i></i>新增圖片</button>
                <button type="submit" class="btn btn-primary"><i class="far fa-save mr-2" aria-hidden="true"></i>刊登商品</button>
              </div>
            </form>
        </div>
      </div>
    </div>
  </div>

@endsection


@section('script')
<script>
  $(document).ready(function() {

    $('#id_select2_demo1').select2({
    placeholder: "請確認系所Tag",
    tags:true,
    allowClear: true
    }).next().hide();

    const max_input = 5;
    let y = $('.increment').length;
    let t_selected_array = $('#id_select2_demo1 option:selected').toArray().map(item=>item.text);
    console.log(t_selected_array);
  
    $(".btn-success").click(function(){ 
      if(y<max_input){
        const html = $(".clone").find('.input-group').clone(true).appendTo('.inner-row');
        y++;
        if(y==max_input){
        $(".btn-success").attr('disabled', true);
        }
        console.log(y);
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
        console.log(y);
      }
      return false;
    });

    $("body").on("click",".r_tag",function(){

       const tag_text = $(this).parents(".mdc-chip").find(".mdc-chip__text").text();

       console.log(tag_text);

       const tag_ndx = t_selected_array.indexOf(tag_text);

         if(tag_ndx!==-1){

          $("#id_select2_demo1 option:selected").filter(function(){
                return $.trim($(this).text()) == tag_text
          }).remove();
           
          t_selected_array.splice(tag_ndx,1);

          $(this).parents(".mdc-chip").remove();
          
       }
       
       console.log(t_selected_array);
      
    });

   $('select[name="college[]"]').on("change",function(){
      var collegeId = $(this).val();
      var collegeName = $('select[name="college[]"] option:selected').text();
      console.log(collegeName);
      if(collegeId){
         $.ajax({
           url: 'department/get/'+collegeId,
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

      let d_id = $('select[name="department[]"]').val();

      let d_name = $('select[name="department[]"] option:selected').text();
  
      if(t_selected_array.indexOf(d_name) === -1){
       
       t_selected_array.push(d_name);

       console.log(t_selected_array);
       
       $('#id_select2_demo1').append('<option value="'+ d_id +'" selected>' + d_name + '</option>').trigger('change.select2');

       let copy = $(".tag_model").find('.mdc-chip').clone(true);

       copy.find('.mdc-chip__text').text(d_name);
       
       $('.tags').append(copy);


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

  });
</script>
@endsection