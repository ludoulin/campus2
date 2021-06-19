@extends('layouts.basic')
@section('title', '測試')

@section('basic')
<link href="{{ asset('css/page/test.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid" id="chat">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">聊天室</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="d-lg-flex mb-4">
        <div class="chat-leftsidebar card">
            <div class="p-3 px-4">
                <div class="d-flex align-items-start">
                    <div class="flex-shrink-0 me-3 align-self-center">
                        <img src="assets/images/users/avatar-4.jpg" class="avatar-xs rounded-circle" alt="">
                    </div>
                    
                    <div class="flex-grow-1">
                        <h5 class="font-size-16 mb-1"><a href="#" class="text-dark">Marcus <i class="fas fa-circle text-success align-middle font-size-10 ms-1"></i></a></h5>
                        <p class="text-muted mb-0">上線中</p>
                    </div>

                    <div class="flex-shrink-0">
                        <div class="dropdown chat-noti-dropdown">
                            <button class="btn py-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">個人檔案</a>
                                <a class="dropdown-item" href="#">編輯</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-3">
                <div class="search-box chat-search-box">
                    <div class="position-relative">
                        <input type="text" class="form-control bg-light border-light rounded" placeholder="尋找...">
                        <i class="fas fa-search search-icon"></i>
                    </div>
                </div>
            </div>

            <div class="pb-3">
                <div style="overflow:scroll; max-height: 410px;">
                    <div class="p-4 border-top">
                        <div>
                            <h5 class="font-size-16 mb-3"><i class="far fa-user me-1"></i>全部使用者</h5>

                            <ul class="list-unstyled chat-list">
                                <li>
                                    <a href="#">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-shrink-0 me-3 align-self-center">
                                                <div class="user-img online">
                                                    <img src="assets/images/users/avatar-2.jpg" class="rounded-circle avatar-xs" alt="">
                                                    {{-- <span class="user-status"></span> --}}
                                                </div>
                                            </div>                                                                
                                            
                                            <div class="flex-grow-1 overflow-hidden">
                                                <h5 class="text-truncate font-size-14 mb-1">John Howard</h5>
                                                <p class="text-truncate mb-0">Hey! there I'm available</p>
                                            </div>
                                            
                                            <div class="flex-shrink-0">
                                                <div class="font-size-11">02 min</div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="unread">
                                    <a href="#">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-shrink-0 me-3 align-self-center">
                                                <div class="user-img online">
                                                    <div class="avatar-xs align-self-center">
                                                        <span class="avatar-title rounded-circle bg-soft-primary text-primary">
                                                            G
                                                        </span>
                                                    </div>
                                                    <span class="user-status"></span>
                                                </div>
                                            </div>

                                            <div class="flex-grow-1 overflow-hidden">
                                                <h5 class="text-truncate font-size-14 mb-1">Galen Rizo</h5>
                                                <p class="text-truncate mb-0">I've finished it! See you so</p>
                                            </div>

                                            <div class="flex-shrink-0">
                                                <div class="font-size-11">10 min</div>
                                                <div class="unread-message">
                                                    <span class="badge bg-danger rounded-pill">01</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-shrink-0 align-self-center me-3">
                                                <div class="user-img away">
                                                    <img src="assets/images/users/avatar-3.jpg" class="rounded-circle avatar-xs" alt="">
                                                    {{-- <span class="user-status"></span> --}}
                                                </div>
                                            </div>
                                            
                                            <div class="flex-grow-1 overflow-hidden">
                                                <h5 class="text-truncate font-size-14 mb-1">Bernard Spencer</h5>
                                                <p class="text-truncate mb-0">This theme is awesome!</p>
                                            </div>

                                            <div class="flex-shrink-0">
                                                <div class="font-size-11">22 min</div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-shrink-0 align-self-center me-3">
                                                <div class="user-img">
                                                    <img src="assets/images/users/avatar-4.jpg" class="rounded-circle avatar-xs" alt="">
                                                    {{-- <span class="user-status"></span> --}}
                                                </div>
                                            </div>

                                            <div class="flex-grow-1 overflow-hidden">
                                                <h5 class="text-truncate font-size-14 mb-1">Annie Holder</h5>
                                                <p class="text-truncate mb-0">Nice to meet you</p>
                                            </div>

                                            <div class="flex-shrink-0">
                                                <div class="font-size-11">01 Hr</div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-shrink-0 align-self-center me-3">
                                                <div class="user-img online">
                                                    <div class="avatar-xs align-self-center">
                                                        <span class="avatar-title rounded-circle bg-soft-primary text-primary">
                                                            V
                                                        </span>
                                                    </div>
                                                    {{-- <span class="user-status"></span> --}}
                                                </div>
                                            </div>
                                            
                                            <div class="flex-grow-1 overflow-hidden">
                                                <h5 class="text-truncate font-size-14 mb-1">Vernon Smith</h5>
                                                <p class="text-truncate mb-0">Wow that's great</p>
                                            </div>

                                            <div class="flex-shrink-0">
                                                <div class="font-size-11">04 Hrs</div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- end chat-leftsidebar -->

        <div class="w-100 user-chat mt-4 mt-sm-0 ms-lg-1">
            <div class="card">
                <div class="p-3 px-lg-4 border-bottom">
                    <div class="row">
                        <div class="col-md-4 col-6">
                            <h5 class="font-size-16 mb-1 text-truncate"><a href="#" class="text-dark">Designers</a></h5>
                        </div>
                        <div class="col-md-8 col-6">
                            <ul class="list-inline user-chat-nav text-end mb-0">
                                <li class="list-inline-item">
                                    <div class="dropdown">
                                        <button class="btn nav-btn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-md" style="position:end;">
                                            <form class="p-2">
                                                <div>
                                                    <input type="text" class="form-control rounded" placeholder="Search...">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="px-lg-2">
                    <div class="chat-conversation p-3">
                        <ul class="list-unstyled mb-0"  style="overflow:scroll;max-height: 455px;">
                            {{-- <li class="chat-day-title"> 
                                <div class="title">Today</div>
                            </li> --}}
                            <li>
                                <div class="conversation-list">
                                    <div class="ctext-wrap">
                                        <div class="ctext-wrap-content">
                                            <h5 class="font-size-14 conversation-name"><a href="#" class="text-dark">John Howard</a> <span class="d-inline-block font-size-12 text-muted ms-2">10:00</span></h5>
                                            <p class="mb-0">
                                                Good morning everyone !
                                            </p>
                                        </div>
                                        <div class="dropdown align-self-start">
                                            <a  href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </li>

                            <li class="right">
                                <div class="conversation-list">
                                    <div class="ctext-wrap">
                                        <div class="ctext-wrap-content">
                                            <h5 class="font-size-14 conversation-name"><a href="#" class="text-dark">Marcus</a> <span class="d-inline-block font-size-12 text-muted ms-2">10:02</span></h5>
                                            <p class="mb-0">
                                                Good morning everyone !
                                            </p>
                                        </div>
                                        <div class="dropdown align-self-start">
                                            <a href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </li>

                            <li>
                                <div class="conversation-list">
                                    <div class="ctext-wrap">
                                        <div class="ctext-wrap-content">
                                            <h5 class="font-size-14 conversation-name"><a href="#" class="text-dark">John Howard</a> <span class="d-inline-block font-size-12 text-muted ms-2">10:00</span></h5>
                                            <p class="mb-0">
                                                Good morning everyone !
                                            </p>
                                        </div>
                                        <div class="dropdown align-self-start">
                                            <a  href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </li>
                            

                            
                            <li class="right">
                                <div class="conversation-list">
                                    <div class="ctext-wrap">
                                        <div class="ctext-wrap-content">
                                            <h5 class="font-size-14 conversation-name"><a href="#" class="text-dark">Marcus</a> <span class="d-inline-block font-size-12 text-muted ms-2">10:02</span></h5>
                                            <p class="mb-0">
                                                Wow that's great
                                            </p>
                                        </div>
                                        <div class="dropdown align-self-start">
                                            <a  href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </li>

                            <li>
                                <div class="conversation-list">
                                    <div class="ctext-wrap">
                                        <div class="ctext-wrap-content">
                                            <h5 class="font-size-14 conversation-name"><a href="#" class="text-dark">John Howard</a> <span class="d-inline-block font-size-12 text-muted ms-2">10:00</span></h5>
                                            <p class="mb-0">
                                                Good morning everyone !
                                            </p>
                                        </div>
                                        <div class="dropdown align-self-start">
                                            <a  href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </li>

                            
                            
                        </ul>
                    </div>
                </div>

                <div class="p-3 chat-input-section">
                    <div class="row">
                        <div class="col">
                            <div class="position-relative">
                                <input type="text" class="form-control chat-input rounded" placeholder="Enter Message...">
                                
                            </div>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary chat-send w-md waves-effect waves-light"><span class="d-none d-sm-inline-block me-2">Send</span> <i class="fas fa-share"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End d-lg-flex  -->
    
</div> <!-- container-fluid -->

@endsection

@section('FrontEnd_Script')
<script>


</script>	
@endsection




