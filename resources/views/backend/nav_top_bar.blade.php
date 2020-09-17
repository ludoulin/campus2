<div class="dropdown">
    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ Auth::user()->name }}
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="{{ route('users.show', Auth::id()) }}">個人中心</a>
            <a class="dropdown-item" href="{{ route('users.edit', Auth::id()) }}">編輯資料</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" id="logout" href="#">
              <form action="{{ route('logout') }}" method="POST">
                {{ csrf_field() }}
                <button class="btn btn-block btn-danger" type="submit" name="button">登出</button>
              </form>
            </a>
    </div>
  </div>

{{-- //舊的nav_top_bar --}}

{{-- <nav class="navbar navbar-default">
    <div class="container-fluid">
      <ul class="nav navbar-nav navbar-right">
        <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <!--<img src="https://cdn.learnku.com/uploads/images/201709/20/1/PtDKbASVcz.png?imageView2/1/w/60/h/60" class="img-responsive img-circle" width="30px" height="30px">-->
                  {{ Auth::user()->name }}
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="{{ route('users.show', Auth::id()) }}">個人中心</a>
                  <a class="dropdown-item" href="{{ route('users.edit', Auth::id()) }}">編輯資料</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" id="logout" href="#">
                    <form action="{{ route('logout') }}" method="POST">
                      {{ csrf_field() }}
                      <button class="btn btn-block btn-danger" type="submit" name="button">登出</button>
                    </form>
                  </a>
                </div>
              </li>
      </ul>
    </div>
  </nav> --}}