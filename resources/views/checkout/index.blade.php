@extends('layouts.basic')

@section('basic')

@endsection

@section('content')
<section class="section-content bg padding-y">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    @if (Session::has('error'))
                        <p class="alert alert-danger">{{ Session::get('error') }}</p>
                    @endif
                </div>
            </div>
            <form id="PayForm" action="{{ route('order.create') }}" method="POST" role="form" accept-charset="UTF-8" enctype="multipart/form-data">
            <input type="hidden" name="p_id" value="{{$t_prd}}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <header class="card-header">
                                <h4 class="card-title mt-2">訂單明細</h4>
                            </header>
                            <article class="card-body">
                                <div class="form-row">
                                    <div class="col form-group">
                                        <label>姓:</label>
                                        <input type="text" class="form-control necessary" name="first_name" autocomplete="off" value="lin" required>
                                    </div>
                                    <div class="col form-group">
                                        <label>名字:</label>
                                        <input type="text" class="form-control necessary" name="last_name" autocomplete="off" value="dou" required>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                   
                                    <div class="form-group  col-md-6">
                                        <label>電話號碼:</label>
                                        <input type="text" class="form-control necessary" name="phone_number" autocomplete="off">
                                    </div>
    
                                    <div class="form-group  col-md-6">
                                        <label>希望面交時間:</label>
                                        <input type="date" class="form-control" name="face_time" required >
                                    </div>
    
                                </div>
    
                                {{-- <div class="form-group">
                                    <label class="d-block" >付款方式:</label>
                                    @foreach($p_type as $type)
                                        <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="payment{{$type["id"]}}" name="payment" class="custom-control-input" value="{{$type["id"]}}">
                                        <label class="custom-control-label" for="payment{{$type["id"]}}">{{$type["name"]}}</label>
                                        </div>
                                    @endforeach      
                                </div> --}}
    
                                <div class="form-group">
                                    <label>信箱:</label>
                                    <input type="email" class="form-control" name="email" value="{{ auth()->user()->email }}" disabled>
                                    <small class="form-text text-muted">我們不會洩漏您的個資.</small>
                                </div>
                                <div class="form-group">
                                    <label>訂單備註:</label>
                                    <textarea class="form-control" name="notes" rows="6"></textarea>
                                </div>
                            </article>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <header class="card-header">
                                        <h4 class="card-title mt-2">訂單確認</h4>
                                    </header>
                                    <article class="card-body">
                                        <dl class="dlist-align">
                                            <dt>訂單項目:</dt>
                                            @foreach($products as $id => $product)
                                        <dt class="mt-2" style="color:rgb(0, 0, 128)">項目{{$id+1}}: {{$product["name"]}}<span style="float: right;">$ {{$product["price"]}} 元</span></dt>
                                            @endforeach    
                                       </dl>
                                    
                                        <dl class="dlist-align">
                                        <dt style="font-size: 24px">總共花費:<span style="float: right;color:#bf0000">
                                            {{$total}}元</span></dt>
                                        </dl>
                                    </article>
                                </div>
                            </div>
                            <div class="col-md-12 mt-4">
                                <input type="hidden" id="payment" name="payment" value="">
                                    @foreach($p_type as $type)
                                    <button type="button" 
                                            data-type="{{$type["id"]}}" 
                                            onclick="Pay(this)"
                                            class="subscribe btn btn-lg btn-block
                                                @if($type->id===1)
                                                 btn-primary
                                                @elseif($type->id===2)
                                                 btn-success
                                                @elseif($type->id===3)
                                                 btn-danger
                                                 @endif">
                                                {{$type->name}}
                                    </button>
                                @endforeach   
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('script')
<script>
  $(function(){

        $("#PayForm").submit(function(event) {

            let form = $(this);

            let url = form.attr('action');

            // avoid to execute the actual submit of the form.
            event.preventDefault();

            console.log($(this).serialize());

            MessageObject.Waiting("下單中,請稍後");

            $.ajax({
                    type: "POST",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: form.serialize(), // serializes the form's elements.
                    success: function(response){
                                text=response.message==="面交付費下單成功"? "訂單" : "付款";
                                    swal.close();
                                        swal.fire({
                                            icon:'success',
                                            title: '下單成功',
                                            text:`準備前往${text}頁面`,
                                            timer: 2000,
                                            timerProgressBar: true,
                                            didOpen: () => {
                                                            swal.showLoading();
                                                            },
                                            willClose: () => {
                                                                if(response.returnCode==="0000"){
                                                                    window.location = response.info.paymentUrl.web
                                                                }else{
                                                                    window.location = '{{route("users.orders_status", Auth::id())}}'
                                                                }
                                                            }
                                                    });
                                        return true

                                },
                        error: function (error) {

                        MessageObject.VaildSubmitMessage("發生錯誤","表單提交失敗");

                        return false

                        }       
                  });
            }); 
            
    });    

  function Pay(el) {
        document.getElementById("payment").value = $(el).data().type
        swal.fire({
                    title: `確定要使用${$(el).text()}嗎?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#0c46ff',
                    confirmButtonText: '確定!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#PayForm").submit();
                  }
        });
  }

</script>
@endsection    