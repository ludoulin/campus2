<div class="dropdown-item"> 
<div class="media">
        <div class="media-left">
          <a>
            <img class="media-object mr-3" alt="{{ $notification->data['user_name'] }}" src="{{ $notification->data['user_avatar'] }}" style="width:48px;height:48px;" />
          </a>
        </div>
      
        <div class="media-body">
          <div class="media-heading mt-0 mb-1 text-secondary">
            <a>{{ $notification->data['user_name'] }}</a>
            回覆了您的
            <a >{{ $notification->data['product_name'] }}</a>
          </div>
          <div class="reply-content">
            {!! $notification->data['reply_content'] !!}
          </div>
        </div>
    </div>
</div>
@if ( ! $loop->last) 
<hr/>
@endif
      