@include('shared.error')

<div class="reply-box">
  <form action="{{ route('comments.store') }}" method="POST" accept-charset="UTF-8">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    <div class="form-group">
      <textarea class="form-control" rows="3" placeholder="請在此輸入您的提問，賣家將會回覆您的提問~" name="content"></textarea>
    </div>
    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-share mr-1"></i>確認送出</button>
  </form>
</div>
