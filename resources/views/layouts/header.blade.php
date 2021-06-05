<nav class="navbar navbar-expand-lg navbar-dark navbar-static-top fixed-top">
  <div class="container-fluid">
    <!-- Branding Image -->
    <a class="navbar-brand" href="{{ url('/') }}">
      校園二手書交易平台
    </a>
    
    <form action="{{ route('search') }}" class="login-form">
        <div class="form-row">    
    <auto-search></auto-search>
    <div class="col-auto"><button class="btn btn-success my-1 my-sm-0" type="submit">搜尋</button></div>
        </div>
    </form>
  
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Left Side Of Navbar -->
      <ul class="navbar-nav mr-auto">

      </ul>

      <!-- Right Side Of Navbar -->
      <ul class="navbar-nav navbar-right">
        <!-- Authentication Links -->
        @guest
          <li class="nav-item"><a class="nav-link" href="{{ route('products.create') }}">我要賣書</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('cart')}}"><i class="fas fa-cart-plus pr-2"></i>購物車</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">登入</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">註冊</a></li>
        @else
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <!--<img src="https://cdn.learnku.com/uploads/images/201709/20/1/PtDKbASVcz.png?imageView2/1/w/60/h/60" class="img-responsive img-circle" width="30px" height="30px">-->
              {{ Auth::user()->name }}
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              @if(!Auth::user()->is_admin)
              <a class="dropdown-item" href="{{ route('users.show', Auth::id()) }}">個人中心</a>
              <a class="dropdown-item" href="{{ route('users.edit', Auth::id()) }}">編輯資料</a>
              <a class="dropdown-item" href="{{ route('users.favorite')}}">收藏商品</a>
              <a class="dropdown-item" href="{{ route('cart')}}">我的購物車</a>
              <div class="dropdown-divider"></div>
              @endif
              <a class="dropdown-item" id="logout" href="#">
                <form action="{{ route('logout') }}" method="POST">
                  {{ csrf_field() }}
                  <button class="btn btn-block btn-danger" type="submit" name="button">登出</button>
                </form>
              </a>
            </div>
          </li>
          <li class="nav-item"><a class="nav-link" href="{{ route('products.create') }}" ><i class="fas fa-book mr-2"></i>我要賣書</a></li>
         
          <li class="nav-item"><a class="nav-link" href="{{ route('users.home') }}"><i class="fab fa-facebook-messenger"></i></a></li>
          <li class="dropdown message">
          <notification-app :counts="{{ auth()->user()->notification_count }}" :userid="{{ auth()->id()}}" :unreads="{{ auth()->user()->unreadNotifications}}" :reads="{{ auth()->user()->Notifications}} "></notification-app>
            </li> 
        @endguest
      </ul>
    </div>
  </div>
</nav>



