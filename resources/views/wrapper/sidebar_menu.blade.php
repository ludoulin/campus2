<div class="campus-sidebar">
	<div class="campus-sidebar-logo d-flex justify-content-between">
		<a href="{{ url('/') }}" class="header-logo">
			<img src="https://slc.ntut.edu.tw/var/file/45/1045/img/taipeitechsllogo.png" class="img-fluid rounded-normal" alt>
			<div class="logo-title">
				<span class="text-primary">北科二手書</span>
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
		<div class="scroll-content" style="transform: translate3d(0px, 0px, 0px);">
			<nav class="campus-sidebar-menu">
				<ul id="campus-sidebar-toggle" class="campus-menu">
					<li class="active active-menu">
						<a href="#dashboard" class="campus-waves-effect collapsed" data-toggle="collapse" aria-expanded="true">
							<span class="ripple rippleEffect" style="width: 260px; height: 260px; top: -106px; left: 139px;"></span>
							<i class="fas fa-home campus-arrow-left"></i>
							<span>平台商場</span>
							<i class="fas fa-chevron-right campus-arrow-right"></i>
						</a>
						<ul id="dashboard" class="campus-submenu collapse show" data-parent="#campus-sidebar-toggle">
							<li>
								<a href="{{ url('/') }}">
									<i class="fas fa-store-alt"></i>首頁
								</a>
							</li>
							<li>
								<a href="{{route('products.index')}}">
									<i class="fas fa-border-all"></i>所有商品
								</a>
							</li>
						</ul>		
					</li>
					<li>
						<a href="#product" class="campus-waves-effect collapsed" data-toggle="collapse" aria-expanded="false">
							<i class="fas fa-mouse-pointer campus-arrow-left"></i>
							<span>一般功能</span>
							<i class="fas fa-chevron-right campus-arrow-right"></i>
						</a>
						<ul id="product" class="campus-submenu collapse" data-parent="#campus-sidebar-toggle">
							@guest
							<li>
								<a href="{{route('products.create')}}">
								<i class="fas fa-book"></i>我要賣書
								</a>	
							</li>	
							<li>
								<a href="{{ route('cart') }}">
									<i class="fas fa-cart-plus pr-2"></i>購物車
								</a>
							</li>	
							@else
							<li>
								<a href="{{route('products.create')}}">
								<i class="fas fa-book"></i>我要賣書
								</a>	
							</li>	
							<li>
								<a href="{{ route('users.favorite') }}">
									<i class="far fa-heart"></i>收藏商品
								</a>
							</li>
							<li>
								<a href="{{ route('cart') }}">
									<i class="fas fa-cart-plus pr-2"></i>購物車
								</a>
							</li>
							@endguest
						</ul>		
					</li>
					@if(Auth::check())
					<li>
						<a href="#management" class="campus-waves-effect collapsed" data-toggle="collapse" aria-expanded="false">
							<i class="fas fa-tools campus-arrow-left"></i>
							<span>管理功能</span>
							<i class="fas fa-chevron-right campus-arrow-right"></i>
						</a>
						<ul id="management" class="campus-submenu collapse" data-parent="#campus-sidebar-toggle">
							<li>
								<a href="{{ route('users.products', Auth::id() ) }}">
									<i class="fas fa-book-medical"></i>你的商品管理
								</a>
							</li>
							<li>
								<a href="{{ route('users.orders', Auth::id() ) }}">
									<i class="fas fa-tasks"></i>訂單管理
								</a>
							</li>
							<li>
								<a href="{{ route('users.orders_status', Auth::id() ) }}">
									<i class="fas fa-hands-helping"></i>訂單進度查詢
								</a>
							</li>
						</ul>		
					</li>
					@endif
					<li>
						<a href="#college" class="campus-waves-effect collapsed" data-toggle="collapse" aria-expanded="false">
							<i class="fas fa-university campus-arrow-left"></i>
							<span>六大學院</span>
							<i class="fas fa-chevron-right campus-arrow-right"></i>
						</a>
						<ul id="college" class="campus-submenu collapse" data-parent="#campus-sidebar-toggle">
							<li>
								<a href="{{ route('college.show', 1) }}">
									<i class="fas fa-cogs"></i>機電學院
								</a>
							</li>
							<li>
								<a href="{{ route('college.show', 2) }}">
									<i class="fas fa-hard-hat"></i>工程學院
								</a>
							</li>
							<li>
								<a href="{{ route('college.show', 3) }}">
									<i class="fas fa-poll"></i>管理學院
								</a>
							</li>
							<li>
								<a href="{{ route('college.show', 4) }}">
									<i class="fas fa-pencil-ruler"></i>設計學院
								</a>
							</li>
							<li>
								<a href="{{ route('college.show', 5) }}">
									<i class="fas fa-language"></i>人文與社會科學學院學院
								</a>
							</li>
							<li>
								<a href="{{ route('college.show', 6) }}">
									<i class="fas fa-bolt"></i>電資學院
								</a>
							</li>
						</ul>		
					</li>
					<li>
						<a href="#problem" class="campus-waves-effect collapsed" data-toggle="collapse" aria-expanded="false">
							<i class="fas fa-exclamation-circle campus-arrow-left"></i>
							<span>疑難排解</span>
							<i class="fas fa-chevron-right campus-arrow-right"></i>
						</a>
						<ul id="problem" class="campus-submenu collapse" data-parent="#campus-sidebar-toggle">
							<li>
								<a href="{{ route('problem.index') }}">
									<i class="fas fa-question-circle"></i>聯絡我們
								</a>
							</li>
						</ul>		
					</li>
				</ul>		
			</nav>
		</div>
		<div class="scrollbar-track scrollbar-track-x" style="display: none;">
			<div class="scrollbar-thumb scrollbar-thumb-x" style="width: 300px; transform: translate3d(0px, 0px, 0px);"></div>
		</div>			
		<div class="scrollbar-track scrollbar-track-y" style="display: none;">
			<div class="scrollbar-thumb scrollbar-thumb-y" style="height: 937px; transform: translate3d(0px, 0px, 0px);"></div>
		</div>
	</div>
</div>