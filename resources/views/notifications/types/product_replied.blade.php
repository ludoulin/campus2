<li class="media">
        <div class="media-left">
          <a href="{{ route('users.show', $notification->data['user_id']) }}">
            <img class="media-object img-thumbnail mr-3" alt="{{ $notification->data['user_name'] }}" src="{{ $notification->data['user_avatar'] }}" style="width:48px;height:48px;" />
          </a>
        </div>
      
        @if(isset($notification->data['reply_id']))
        <div class="media-body">
          <div class="media-heading mt-0 mb-1 text-secondary">
            <a href="{{ route('users.show', $notification->data['user_id']) }}">{{ $notification->data['user_name'] }}</a>
            回覆了您的
            <a href="{{ $notification->data['product_link'] }}">{{ $notification->data['product_name'] }}</a>
    
            <span class="meta float-right" title="{{ $notification->created_at }}">
              <i class="far fa-clock"></i>
              {{ $notification->created_at->diffForHumans() }}
            </span>
          </div>
          <div class="reply-content">
            {!! $notification->data['reply_content'] !!}
          </div>
        </div>
        @else 
        <div class="media-body">
          <div class="media-heading mt-0 mb-1 text-secondary">
            <a href="{{ route('users.show', $notification->data['user_id']) }}">{{ $notification->data['user_name'] }}</a>
            回覆了您在
            <a href="{{ $notification->data['product_link'] }}">{{ $notification->data['product_name'] }}</a>
            底下的留言
            <span class="meta float-right" title="{{ $notification->created_at }}">
              <i class="far fa-clock"></i>
              {{ $notification->created_at->diffForHumans() }}
            </span>
          </div>
          <div class="reply-content">
            {!! $notification->data['content'] !!}
          </div>
        </div>
        @endif
      </li>
      @if ( ! $loop->last) 
      <hr />
      @endif     
