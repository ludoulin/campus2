@extends('layouts.basic')
@section('title', '測試')

@section('basic')
<link href="{{ asset('css/page/test.css') }}" rel="stylesheet">
@endsection

@section('content')

{{-- <div class="container product">
    <div class="row">
         <div class="col-lg-12 user-contact">123</div>
        <div class="col-xl-6 col-lg-6 col-md-6 left">
            <div class="big-image">
               <img src="https://images.unsplash.com/photo-1580757468214-c73f7062a5cb?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&w=1000&q=80" class="image">
            </div>
            <div class="small-image">
                  <div class="xsimage1">
                        <img src="https://media.taaze.tw/showLargeImage.html?sc=12100442717&width=340&height=474" class="image">
                  </div>
                  <div class="xsimage2">
                    <img src="https://cdnec.sanmin.com.tw/product_images/730/730255210.jpg" class="image"> 
                 </div>
                 <div class="xsimage3">
                    <img src="https://img.alicdn.com/imgextra/i2/352798170/TB2AeoHqOMnBKNjSZFCXXX0KFXa_!!352798170-0-item_pic.jpg_960x960Q50s50.jpg" class="image">
                 </div>
                 <div class="xsimage2">
                        <img src="https://cdnec.sanmin.com.tw/product_images/730/730255210.jpg" class="image"> 
                     </div>
                     <div class="xsimage1">
                            <img src="https://media.taaze.tw/showLargeImage.html?sc=12100442717&width=340&height=474" class="image">
                      </div>    
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 mt-md-0 mt-3 right">
            <div class="product-name">
                <h4 style="text-align:center">Vue.js前端開發 快速入門與專業運用</h4>

                <hr class="hr-text" data-content="詳細資訊">
                
                <div class="inner-detail">
                <div class="mb-3">     
                 <span style="font-size:18px">分類：二手書</span>
                 <span style="font-size:14px;float:right;"><p class="text-muted">瀏覽次數：10</p></span>
                </div>
                <p class="mb-3 mt-2 text-uppercase" style="font-size:18px">ISBN：XXXXXXX</p>
                <p class="mb-3 mt-2" style="font-size:18px;color:#d9534f">二手價：<b style="font-size:22px">$300</b></p>
                <p class="mb-3 mt-2" style="font-size:16px">書況：九成新,內有一點筆記</p>
                <hr>
                <div class="mb-3 mt-2" style="font-size:16px">
                    <p>可付款方式：</p>
                    <div class="row">
                    <div class="col-4">校園面交</div>
                    <div class="col-4">LINE PAY</div>
                    <div class="col-4">街口支付</div>
                    </div>
                </div>
                <hr>
                <div class="mt-2">
                    <p style="font-size:16px">適用課程:</p>
                    <div class="row classname">
                        <div class="col-4 book1">123</div>
                        <div class="col-4">123</div>
                        <div class="col-4">123</div>
                    </div>   
                      </div>
                <hr class="hr-text" data-content="決定一下吧！">
                <div><button type="button" class="btn save"><i class="far fa-heart pr-2"></i>加入收藏</button></div>
                <div><button type="button" class="btn cart"><i class="fas fa-shopping-cart pr-2"></i>加入購物車</button></div>
                <div><button type="button" class="btn buy">立即購買</button></div>
            </div>
              </div>
        </div>
    </div>  
</div>   

<div class="spinner-grow text-secondary" role="status">
        <span class="sr-only">Loading...</span>
    </div> --}}
    <form enctype="multipart/form-data" action="" method="post">
        <div class="preview">
            <i class="fas fa-plus"></i>
            <input class="file-upload form-control-file" type="file" name="imageUpload"/>
        </div>
        <div class="preview">
            <i class="fas fa-plus"></i>
            <input class="file-upload form-control-file" type="file" name="imageUpload"/>
        </div>
        <select class="form-control" style="width:500px" multiple >
                <option value="">-----单选-----</option>
                <option value="1">OPS-COFFEE-A</option>
                <option value="2">OPS-COFFEE-B</option>
                <option value="3">OPS-COFFEE-C</option>
                <option value="4">OPS-COFFEE-D</option>
                <option value="5">OPS-COFFEE-E</option>
                <option value="6">OPS-COFFEE-F</option>
                <option value="7">OPS-COFFEE-G</option>
            </select>
    </form>
@endsection


@section('script')
<script type="text/javascript"> 
var selectorx = $('#id_select2_demo1').select2({
    tags:true,
    allowClear: true
});
function preview1(file) {
$('.upload-button').css("display","none");   
var img = new Image(), url = img.src = URL.createObjectURL(file)
var $img = $(img)
img.onload = function() {
URL.revokeObjectURL(url)
$('#preview').append($img)
}
}
function preview2(el) {

 var file = el.files[0];
 var reader = new FileReader()

reader.onload = function(e) {

var $img = $('<img>').attr("src", e.target.result)

$img.on('click', function(event) {
    $(event.target).siblings(".file-upload").click();
    });

$(el).siblings("img").remove();
$(el).parents('.preview').append($img)

}
reader.readAsDataURL(file)
}



$('[type=file]').change(function(e) {

preview2(e.target);
})
$(".preview").on('click', function(e) {
    $(e.target).find(".file-upload").click();
    //    $(".file-upload").click();
    });
  </script> 
@endsection

