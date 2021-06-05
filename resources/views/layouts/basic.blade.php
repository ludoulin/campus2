@extends('layouts.app')

@section('sass')

<link href="{{ asset('css/wrapper/index.css') }}" rel="stylesheet">

@yield('basic')

@endsection

@section('view')

<div id="app" class="wrapper">

  @include('wrapper.sidebar_menu')

  @include('wrapper.top_nav_bar')

    <div id ="content-page" class="content-page">

        @include('shared.messages')
    
        @yield('content')
    
    </div>
    
</div>
@include('layouts.footer')   
@endsection

@section('script')
<script>
(function(jQuery) {	
    $(document).ready(function(){

    "use strict"
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
           
            $(document).on("click", '.campus-menu > li > a', function() {
                $('.campus-menu > li > a').parent().removeClass('active');
                $(this).parent().addClass('active');
        });
        
  
        jQuery(document).on('click', function(e) {
                let myTargetElement = e.target;
                let selector, mainElement;
                if (jQuery(myTargetElement).hasClass('search-toggle') || jQuery(myTargetElement).parent().hasClass('search-toggle') || jQuery(myTargetElement).parent().parent().hasClass('search-toggle')) {
                    if (jQuery(myTargetElement).hasClass('search-toggle')) {
                        selector = jQuery(myTargetElement).parent();
                        mainElement = jQuery(myTargetElement);
                    } else if (jQuery(myTargetElement).parent().hasClass('search-toggle')) {
                        selector = jQuery(myTargetElement).parent().parent();
                        mainElement = jQuery(myTargetElement).parent();
                    } else if (jQuery(myTargetElement).parent().parent().hasClass('search-toggle')) {
                        selector = jQuery(myTargetElement).parent().parent().parent();
                        mainElement = jQuery(myTargetElement).parent().parent();
                    }
                    if (!mainElement.hasClass('active') && jQuery(".navbar-list li").find('.active')) {
                        jQuery('.navbar-list li').removeClass('campus-show');
                        jQuery('.navbar-list li .search-toggle').removeClass('active');
                    }
    
                    selector.toggleClass('campus-show');
                    mainElement.toggleClass('active');
    
                    e.preventDefault();
                } else if (jQuery(myTargetElement).is('.campus-search-input')) {} else {
                    jQuery('.navbar-list li').removeClass('campus-show');
                    jQuery('.navbar-list li .search-toggle').removeClass('active');
                }
            });
    
        var position = $(window).scrollTop();
            $(window).scroll(function() {
                var scroll = $(window).scrollTop();
                //  console.log(scroll);
                
                if(scroll < position) {
                     $('.tab-menu-horizontal').addClass('menu-up');
                     $('.tab-menu-horizontal').removeClass('menu-down');
                } 
                else {
                    $('.tab-menu-horizontal').addClass('menu-down');
                    $('.tab-menu-horizontal').removeClass('menu-up');
                }
                if(scroll == 0)
                {
                    $('.tab-menu-horizontal').removeClass('menu-up');
                    $('.tab-menu-horizontal').removeClass('menu-down');
                }
                position = scroll;
            });

            $(document).on('click', '.wrapper-menu', function() {
                $(this).toggleClass('open');
            });
    
        $(document).on('click', ".wrapper-menu", function() {
                $("body").toggleClass("sidebar-main");
            });
      });

    })(jQuery);

    function SearchForm(el){
        if($(el).prev().find('input').val()!==""){
            $(el).parent('form').submit();
        }else{
            MessageObject.VaildSubmitMessage("搜尋失敗","不可以空白送出");
        }
    }
</script>

@yield('FrontEnd_Script')

@endsection