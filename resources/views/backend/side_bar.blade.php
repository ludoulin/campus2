<div class="sidebar_inner">
    <ul>
        <li>
            <a href="{{ route('admin.users') }}">
                <span class="icon"><i class="fas fa-user-friends"></i></span>
                <span class="text">使用者管理</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.products.index') }}">
                <span class="icon"><i class="fas fa-book"></i></span>
                <span class="text">二手書商品管理</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.orders.index') }}">
                <span class="icon"><i class="fas fa-comments-dollar"></i></span>
                <span class="text">訂單動態管理</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.activity.index') }}">
                <span class="icon"><i class="fas fa-ad"></i></span>
                <span class="text">活動管理</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.news.index') }}">
                <span class="icon"><i class="fas fa-broadcast-tower"></i></span>
                <span class="text">消息管理</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.problem.index') }}">
                <span class="icon"><i class="fas fa-question-circle"></i></span>
                <span class="text">問題回報管理</span>
            </a>
        </li>
        {{-- <li>
            <a href="#">
                <span class="icon"><i class="fas fa-bullhorn"></i></span>
                <span class="text">推播管理</span>
            </a>
        </li> --}}
    </ul>
    </div>