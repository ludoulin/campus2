@extends('layouts.app')

@section('sass')
<link href="{{ asset('css/backend/control_panel.css') }}" rel="stylesheet">
@yield('sass_backend')
@endsection

@section('view')
<script src="https://kit.fontawesome.com/b99e675b6e.js"></script>

<div class="wrapper hover_collapse">
	<div class="top_navbar">
		<div class="logo">後端管理</div>
		<div class="menu">
			<div class="hamburger">
				<i class="fas fa-bars"></i>
			</div>
			<div class="profile_wrap">
                    @include('backend.nav_top_bar')
			</div>
		</div>
	</div>

	<div class="sidebar">
		@include('backend.side_bar')
	</div>

	<div class="main_container">
		<div class="container">
			<div class="content">
				@yield('content')
            </div>
            <div class="content">
                    @yield('content')
                </div>
		</div>
	</div>
</div>
@endsection

@section('script')
<script>
var li_items = document.querySelectorAll(".sidebar ul li");
var hamburger = document.querySelector(".hamburger");
var wrapper = document.querySelector(".wrapper");


li_items.forEach((li_item)=>{
	li_item.addEventListener("mouseenter", ()=>{
		if(wrapper.classList.contains("click_collapse")){
			return;
		}
		else{
			li_item.closest(".wrapper").classList.remove("hover_collapse");
		}
	})
})

li_items.forEach((li_item)=>{
	li_item.addEventListener("mouseleave", ()=>{
		if(wrapper.classList.contains("click_collapse")){
			return;
		}
		else{
			li_item.closest(".wrapper").classList.add("hover_collapse");
		}
	})
})


hamburger.addEventListener("click", () => {
	hamburger.closest(".wrapper").classList.toggle("click_collapse");
	hamburger.closest(".wrapper").classList.toggle("hover_collapse");
})
</script>

@endsection