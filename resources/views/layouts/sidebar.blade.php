			  <nav class="mt-2">
				<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				  <!-- Add icons to the links using the .nav-icon class
					   with font-awesome or any other icon font library -->

				  <li class="nav-header">MENU</li>
				  <li class="nav-item">
					<a href="{{ route('/search') }}" class="nav-link">
					  <i class="nav-icon fa fa-search"></i>
					  <p>
						Visit Outlet
						<!--<span class="badge badge-info right">2</span>-->
					  </p>
					</a>
				  </li>
				  <li class="nav-item">
					<a href="{{ route('orders.history') }}" class="nav-link">
					  <i class="nav-icon fa fa-history"></i>
					  <p>Order History
					  </p>
					</a>
				  </li>
				  
				  @if(Auth::user()->role == 1 || Auth::user()->role == 2 || Auth::user()->role == 3 || Auth::user()->role == 5 || Auth::user()->role == 6)
				  <li class="nav-item">
					<a href="/master" class="nav-link">
					  <i class="nav-icon fa fa-list-alt"></i>
					  <p>
						Outlet Master
					  </p>
					</a>
				  </li>
				  <li class="nav-item">
					<a href="{{ route('products.index') }}"" class="nav-link">
					  <i class="nav-icon fa fa-database"></i>
					  <p>
						Product Master
					  </p>
					</a>
				  </li>
				  <li class="nav-item">
					<a href="{{ route('orders.report') }}"" class="nav-link">
					  <i class="nav-icon fas fa-columns"></i>
					  <p>
						Summary Report
					  </p>
					</a>
				  </li>
				  @endif
				  
				  @if(Auth::user()->role == 1 || Auth::user()->role == 2)
				  <li class="nav-item">
					<a href="{{ route('users.create') }}"" class="nav-link">
					  <i class="nav-icon fa fa-users"></i>
					  <p>
						User Management
					  </p>
					</a>
				  </li>
				  @endif
				  
				  @if(Auth::user()->role == 1 || Auth::user()->role == 2)
				  <li class="nav-item">
					<a href="{{ route('users.index') }}"" class="nav-link">
					  <i class="nav-icon fa fa-unlock-alt"></i>
					  <p>
						Change Your Password
					  </p>
					</a>
				  </li>
				  @endif
				</ul>
			  </nav>