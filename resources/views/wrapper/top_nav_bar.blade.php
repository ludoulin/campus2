<div class="campus-top-navbar">   
    <div class="campus-navbar-custom">
        <nav class="navbar navbar-expand-lg navbar-light p-0">
            <div class="campus-menu-bt d-flex align-items-center">
                <div class="wrapper-menu">
                    <div class="main-circle"><i class="fas fa-bars"></i></div>
                </div>
                <div class="campus-navbar-logo d-flex justify-content-between">
                    <a href="index.html" class="header-logo">
                        <img src="https://slc.ntut.edu.tw/var/file/45/1045/img/taipeitechsllogo.png" class="img-fluid rounded-normal" alt="">
                        <div class="logo-title">
                           <span class="text-primary text-uppercase">北科二手書平台</span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="navbar-breadcrumb">
                <h5 class="mb-0">Shop</h5>
            </div>
            <div class="campus-search-bar">
                <form action="{{ route('search') }}" class="campus-searchbox">
                    <auto-search></auto-search>
                    <a class="campus-search-link" href="javascript:void(0)" onclick="SearchForm(this)"><i class="fas fa-search"></i></a>
                </form>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"  aria-label="Toggle navigation">
                <i class="fas fa-grip-lines"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto navbar-list">
                    <li class="nav-item nav-icon search-content">
                        <a href="#" class="search-toggle campus-waves-effect text-gray rounded">
                            <i class="fas fa-search"></i>
                        </a>
                        <form action="{{ route('search') }}" class="campus-search-box p-0">
                            <auto-search></auto-search>
                            <a class="campus-search-link" href="javascript:void(0)" onclick="SearchForm(this)"><i class="fas fa-search"></i></a>
                        </form>
                    </li>
                    @guest
                    <li class="nav-item nav-icon">
                        <a href="{{ route('login') }}" class="nav-link campus-waves-effect text-gray rounded">
                            <i class="fas fa-sign-in-alt"></i>
                        </a>
                    </li>
                    <li class="nav-item nav-icon">
                        <a href="{{ route('register') }}" class="nav-link campus-waves-effect text-gray rounded">
                            <i class="fas fa-user-plus"></i>
                        </a>
                    </li>
                    @else
                    <notification-app :counts="{{ auth()->user()->notification_count }}" :userid="{{ auth()->id()}}" :unreads="{{ auth()->user()->unreadNotifications}}" :reads="{{ auth()->user()->Notifications}} "></notification-app>
                    <li class="nav-item nav-icon">
                        <a href="{{ route('users.home') }}" class="nav-link campus-waves-effect text-gray rounded">
                            <i class="fas fa-sms"></i>
                            <span class="bg-primary dots"></span>
                        </a>
                    </li>
                    <li class="line-height pt-3">
                        <a href="#" class="search-toggle campus-waves-effect d-flex align-items-center">
                            <img class="img-fluid rounded-circle mr-3" src="{{asset(Auth::user()->avatar)}}">
                            <div class="caption">
                              <h6 class="mb-1 line-height">{{ Auth::user()->name }}</h6>
                            </div>
                        </a>
                        <div class="campus-sub-dropdown campus-user-dropdown">
                            <div class="campus-card shadow-none m-0">
                                <div class="campus-card-body p-0">
                                    <div class="bg-primary p-3">
                                        <h5 class="mb-0 text-white line-height">Hello {{ Auth::user()->name }}</h5>
                                        <span class="text-white font-size-12">Available</span>
                                    </div>
                                    <a href="{{ route('users.show', Auth::id()) }}" class="campus-sub-card campus-bg-primary-hover">
                                        <div class="media align-items-center">
                                            <div class="rounded campus-card-icon campus-bg-primary">
                                                <i class="far fa-id-card"></i>
                                            </div>
                                            <div class="media-body ml-3">
                                                <h6 class="mb-0 ">查看個人檔案</h6>
                                                <p class="mb-0 font-size-12">確認自己的檔案資料</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="{{ route('users.edit', Auth::id()) }}" class="campus-sub-card campus-bg-primary-hover">
                                        <div class="media align-items-center">
                                            <div class="rounded campus-card-icon campus-bg-primary">
                                                <i class="fas fa-user-edit"></i>
                                            </div>
                                            <div class="media-body ml-3">
                                                <h6 class="mb-0">編輯個人檔案</h6>
                                                <p class="mb-0 font-size-12">修改自己的檔案資料</p>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="d-inline-block w-100 text-center p-3">
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button class="btn bg-primary campus-sign-btn" type="submit"><i class="fas fa-sign-out-alt ml-2"></i>登出</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    @endguest
                </ul>
            </div>
        </nav>
    </div>
</div> 
