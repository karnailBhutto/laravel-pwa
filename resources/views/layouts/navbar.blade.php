<nav class="main-header navbar navbar-expand navbar-dark navbar-primary">
			<!-- Left navbar links -->
			<ul class="navbar-nav">
			  <li class="nav-item">
				<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
			  </li>
			  <a href="/dashboard"><img src="{{asset('images/logo.png')}}" width="60px" alt="Vinda Logo" class="brand-image" style=" position: absolute;left: 50%;margin-left: -27px !important; display: block;"></a>
			 <!-- <li class="nav-item d-none d-sm-inline-block">
				<a href="index3.html" class="nav-link">Home</a>
			  </li>
			  	<a href="#" class="nav-link">Contact</a>
			  </li>-->
			</ul>

			<!-- Right navbar links -->
			<ul class="navbar-nav ml-auto">
			  <!-- Messages Dropdown Menu -->
			  <!--<li class="nav-item dropdown">
				<a class="nav-link" data-toggle="dropdown" href="#">
				  <i class="far fa-comments"></i>
				  <span class="badge badge-danger navbar-badge">3</span>
				</a>
				<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
				  <a href="#" class="dropdown-item">
					<!-- Message Start 
					<div class="media">
					  <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
					  <div class="media-body">
						<h3 class="dropdown-item-title">
						  Brad Diesel
						  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
						</h3>
						<p class="text-sm">Call me whenever you can...</p>
						<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
					  </div>
					</div>
					<!-- Message End 
				  </a>
				  <div class="dropdown-divider"></div>
				  <a href="#" class="dropdown-item">
					<!-- Message Start ->
					<div class="media">
					  <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
					  <div class="media-body">
						<h3 class="dropdown-item-title">
						  John Pierce
						  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
						</h3>
						<p class="text-sm">I got your message bro</p>
						<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
					  </div>
					</div>
					<!-- Message End 
				  </a>
				  <div class="dropdown-divider"></div>
				  <a href="#" class="dropdown-item">
					<!-- Message Start 
					<div class="media">
					  <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
					  <div class="media-body">
						<h3 class="dropdown-item-title">
						  Nora Silvester
						  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
						</h3>
						<p class="text-sm">The subject goes here</p>
						<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
					  </div>
					</div>
					<!-- Message End 
				  </a>
				  <div class="dropdown-divider"></div>
				  <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
				</div>
			  </li>-->
			  <!-- Notifications Dropdown Menu -->
			  <li class="nav-item dropdown">
				<a class="nav-link" data-toggle="dropdown" href="#">
				  <i class="fas fa-shopping-cart"></i>
				  <span class="badge badge-danger navbar-badge">{{$pending->pending}}</span>
				</a>
				<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
				  <span class="dropdown-item dropdown-header">Order Cart</span>
				  <div class="dropdown-divider"></div>
				  <a href="{{ route('orders.history') }}" class="dropdown-item">
					<span class="text-muted text-sm"><i class="fas fa-exclamation mr-2"></i> Have {{$pending->pending}} pending order</span>
				  </a>
				</div>
			  </li>
			  <li class="nav-item dropdown">
				<a class="nav-link" data-toggle="dropdown" href="#">
				  <i class="far fa-user-circle"></i>
				</a>
				<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
				  <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><span class="dropdown-item dropdown-header">
					<i class="fas fa-sign-out-alt"></i> Logout</a>
						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
						@csrf
						</form>
					</span>
				</div>
			  </li>
			  <!--<li class="nav-item">
				<a class="nav-link" data-widget="fullscreen" href="#" role="button">
				  <i class="fas fa-expand-arrows-alt"></i>
				</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
				  <i class="fas fa-th-large"></i>
				</a>
			  </li>-->
			</ul>
		  </nav>