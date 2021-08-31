<nav class="main-header navbar navbar-expand navbar-dark navbar-primary">
			<!-- Left navbar links -->
			<ul class="navbar-nav">
			  <li class="nav-item">
				<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
			  </li>
			  <a href="/dashboard"><img src="{{asset('images/logo.png')}}" width="60px" alt="Vinda Logo" class="brand-image" style=" position: absolute;left: 50%;margin-left: -27px !important; display: block;"></a>
			</ul>

			<!-- Right navbar links -->
			<ul class="navbar-nav ml-auto">
			  
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
					<span class="text-muted text-sm"><i class="fas fa-exclamation mr-2"></i> Have 0 pending order</span>
				  </a>
				</div>
			  </li>
			</ul>
		  </nav>