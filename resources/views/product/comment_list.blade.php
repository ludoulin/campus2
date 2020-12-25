<ul class="list-unstyled">
        @foreach ($comments as $index => $comment)
          <li class=" media" name="reply{{ $comment->id }}" id="reply{{ $comment->id }}">
            <div class="media-left">
              <a href="{{ route('users.show', [$comment->user_id]) }}">
                <img class="media-object img-thumbnail mr-3" alt="{{ $comment->user->name }}" src="{{ $comment->user->avatar }}" style="width:48px;height:48px;" />
              </a>
            </div>
      
            <div class="media-body">
              <div class="media-heading mt-0 mb-1 text-secondary">
                <a href="{{ route('users.show', [$comment->user_id]) }}" title="{{ $comment->user->name }}">
                  {{ $comment->user->name }}
                </a>
                <span class="text-secondary"> • </span>
                <span class="meta text-secondary" title="{{ $comment->created_at }}">{{ $comment->created_at->diffForHumans() }}</span>
      
                {{-- comment刪除 --}}
                @can('destroy', $comment)
                <span class="meta float-right ">
                    <form action="{{ route('comments.destroy', $comment->id) }}"
                        onsubmit="return confirm('確定要刪除留言嗎？');"
                        method="post">
                      {{ csrf_field() }}
                      {{ method_field('DELETE') }}
                      <button type="submit" class="btn btn-danger btn-xs pull-left">
                        <i class="far fa-trash-alt"></i>
                      </button>
                    </form>
                </span>
                @endcan
              </div>
              <div class="reply-content text-secondary">
                {!! $comment->content !!}
              </div>
            </div>
          </li>
      
          @if ( ! $loop->last)
            <hr>
          @endif
      
        @endforeach
      </ul>
      