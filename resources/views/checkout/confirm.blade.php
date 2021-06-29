@extends('layouts.app')

@section('sass')
<link href="{{ asset('css/checkout/confirm.css') }}" rel="stylesheet">
@endsection

@section('view')

<div class="container" id="app">
    @include('shared.messages')
    <div class="line-pay-block d-flex flex-column">

        <div class="line-pay-logo" style="background-image: url('{{asset('images/linepay.png')}}')"></div>
        
        <div class="line-pay-order">
            <p><b>請按下『 確認 』按鈕<br>完成此筆交易</b></p>
            <div class="text-muted"><b>訂單編號</b> : <b>{{$order_number}}</b></div>
        </div> 

        <div class="order-confirm d-flex justify-content-center">
            @include('shared.error')
            <form id="Confirm" action="{{ route('linepay.confirm') }}" method="POST" role="form" accept-charset="UTF-8" enctype="multipart/form-data">
            @csrf
            <input id="confirm" type="hidden" name="confirm" value="{{$order_id}}">
            <input id="transactionId" type="hidden" name="transaction" value="">    
            <button type="submit" class="btn btn-lg btn-success confirm" onclick="return Confirm()">確認</button>
            </form>
        </div>

    </div>

</div>

@endsection


@section('script')
<script>
function Confirm(){


return Check()

}

function Check(){

let redirect_url = new URL(window.location); 

let input = document.getElementById('confirm').value;

if(input===""||!redirect_url.searchParams.has("transactionId")){

  MessageObject.VaildSubmitMessage("發生錯誤","請不要惡意操作");

 return false

}

document.querySelector('#transactionId').value = redirect_url.searchParams.get("transactionId");

return true

}
</script>
@endsection


