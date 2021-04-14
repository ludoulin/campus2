@extends('layouts.app')
@section('title', '測試')

@section('sass')
<link href="{{ asset('css/page/test.css') }}" rel="stylesheet">
@endsection

@section('view')
<div class="wrapper" id="app">
	<div class="campus-sidebar">
		<div class="campus-sidebar-logo d-flex justify-content-between">
			<a href="{{ url('/') }}" class="header-logo">
				<img src="" class="img-fluid rounded-normal" alt>
				<div class="logo-title">
				   <span class="text-primary text-uppercase">Campus-Book</span>
				</div>		
			</a>	
			<div class="campus-menu-bt-sidebar">
				<div class="campus-menu-bt align-self-center">
					<div class="wrapper-menu">
						<div class="main-circle">
							<i class="fas fa-bars"></i>
						</div>	
					</div>		
				</div>		
			</div>
		</div>
		<div id="sidebar-scrollbar" data-scrollbar="true" tabindex="-1" style="overflow:hidden; outline: none;">
			<div class="scroll-content">
				<nav class="campus-sidebar-menu">
					<ul id="campus-sidebar-toggle" class="campus-menu">
						<li class="active active-menu">
							<a href="{{ url('/') }}" class="campus-waves-effect dropdown-toggle" data-toggle="collapse" aria-expanded="false">
								{{-- <span class="ripple rippleEffect"></span> --}}
								<i class="fas fa-home campus-arrow-left"></i>
								<span>主頁功能</span>
								<i class="fas fa-chevron-right campus-arrow-right"></i>
							</a>
							<ul id="dashboard" class="campus-submenu collapse" data-parent="#campus-sidebar-toggle">
								<li>
									<a href="{{ url('/') }}">
										<i class="fas fa-store-alt"></i>首頁
									</a>
								</li>
								<li>
									<a href="{{ url('/') }}">
										<i class="fas fa-store-alt"></i>首頁
									</a>
								</li>
							</ul>		
						</li>
						<li>
								<a href="javascript::void(0)" class="campus-waves-effect" data-toggle="collapse" aria-expanded="true">
									<span class="ripple rippleEffect"></span>
									<i class="fas fa-home campus-arrow-left"></i>
									<span>主頁功能</span>
									<i class="fas fa-chevron-right campus-arrow-right"></i>
								</a>
								<ul id="dashboard" class="campus-submenu collapse" data-parent="#campus-sidebar-toggle">
									<li >
										<a href="{{ url('/') }}">
											<i class="fas fa-store-alt"></i>首頁
										</a>
									</li>
									<li >
											<a href="{{ url('/') }}">
												<i class="fas fa-store-alt"></i>首頁
											</a>
									</li>
								</ul>		
							</li>
					</ul>		
				</nav>
				{{-- <div id="sidebar-bottom" class="p-3 position-relative">
				</div>		 --}}
			</div>
			<div class="scrollbar-track scrollbar-track-x" style="display: none;">
				<div class="scrollbar-thumb scrollbar-thumb-x" style="width: 300px; transform: translate3d(0px, 0px, 0px);"></div>
			</div>			
			<div class="scrollbar-track scrollbar-track-y" style="display: none;">
				<div class="scrollbar-thumb scrollbar-thumb-y" style="height: 937px; transform: translate3d(0px, 0px, 0px);"></div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
<script>
(function(jQuery) {
$(document).ready(function(){

"use strict"
/*---------------------------
Sidebar Widget
----------------------------*/
function checkClass(ele, type, className) {
            switch (type) {
                case 'addClass':
                    if (!ele.hasClass(className)) {
                        ele.addClass(className);
                    }
                    break;
                case 'removeClass':
                    if (ele.hasClass(className)) {
                        ele.removeClass(className);
                    }
                    break;
                case 'toggleClass':
                    ele.toggleClass(className);
                    break;
            }
        }
/*---------------------------------------------------------------------
        Ripple Effect
        -----------------------------------------------------------------------*/
        $(document).on('click', ".campus-waves-effect", function(e) {
            // Remove any old one
            $('.ripple').remove();
            // Setup
            let posX = $(this).offset().left,
                posY = $(this).offset().top,
                buttonWidth = $(this).width(),
                buttonHeight = $(this).height();

            // Add the element
            $(this).prepend("<span class='ripple'></span>");


            // Make it round!
            if (buttonWidth >= buttonHeight) {
                buttonHeight = buttonWidth;
            } else {
                buttonWidth = buttonHeight;
            }

            // Get the center of the element
            let x = e.pageX - posX - buttonWidth / 2;
            let y = e.pageY - posY - buttonHeight / 2;


            // Add the ripples CSS and start the animation
            $(".ripple").css({
                width: buttonWidth,
                height: buttonHeight,
                top: y + 'px',
                left: x + 'px'
            }).addClass("rippleEffect");
        });
 /*---------------------------------------------------------------------
        Sidebar Widget
        -----------------------------------------------------------------------*/
       
        $(document).on("click", '.campus-menu > li > a', function() {
            $('.campus-menu > li > a').parent().removeClass('active');
            $(this).parent().addClass('active');
        });

		//  /*---------------------------------------------------------------------
        // Scrollbar
        // -----------------------------------------------------------------------*/
        // let Scrollbar = window.Scrollbar;
        // if ($('#sidebar-scrollbar').length) {
        //     Scrollbar.init(document.querySelector('#sidebar-scrollbar'), options);
        // }

		/*---------------------------------------------------------------------
        Page Menu
        -----------------------------------------------------------------------*/
        $(document).on('click', '.wrapper-menu', function() {
            $(this).toggleClass('open');
        });

		$(document).on('click', ".wrapper-menu", function() {
            $("body").toggleClass("sidebar-main");
        });
});
})(jQuery);
</script>	
@endsection




