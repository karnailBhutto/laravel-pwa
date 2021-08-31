@extends('layouts.app')

				@section('header')
				<div class="container-fluid">
					<div class="row mb-2">
					  <div class="col-sm-6">
						<h5 class="m-0">Change Password</h5>
					  </div><!-- /.col -->
					  <!--<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
						  <li class="breadcrumb-item"><a href="#">Home</a></li>
						  <li class="breadcrumb-item active">Dashboard v2</li>
						</ol>
					  </div>-->
					</div><!-- /.row -->
				</div><!-- /.container-fluid -->
				@endsection
				
				@section('content')
				<div class="container-fluid">
					<div class="row">
					  <div class="col-md-12">
						<div class="card">
									
						 <form method="POST" action="{{route('users.change')}}">
						{{ csrf_field() }}
						{{ method_field('POST') }}
										
						  
						  <div class="card-body">
							<div class="row">
							  <div class="col-12">
							  
							  @if ($message = Session::get('success'))
								<div class="alert alert-success alert-dismissible">
									<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>{{ $message }}</strong>
								</div>
							  @endif
								
								@if ($message = Session::get('error'))
									<div class="alert alert-danger alert-dismissible">
										<button type="button" class="close" data-dismiss="alert">×</button>
											<strong>{{ $message }}</strong>
									</div>
								@endif
							  
							  <p>You can reset your password here. Otherwise, you can leave this empty.</p><br>
								
								<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
									<input type="password" class="form-control" placeholder="Password" name="password" required>
									
									 @if ($errors->has('password'))
											<span class="help-block">
												<strong>{{ $errors->first('password') }}</strong>
											</span>
										@endif
								</div>
								 <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
									<input type="password" class="form-control" placeholder="Confirm your password" name="password1" required>
									
									 @if ($errors->has('password'))
											<span class="help-block">
												<strong>{{ $errors->first('password') }}</strong>
											</span>
										@endif
								</div>
								<hr>
							  </div>
							</div>
							
							<div class="row">
							  <div class="col-12">
								<button type="submit" class="btn btn-block btn-primary">Change Password</button>
							  </div>
							</div>
							<!-- /.row -->
						  </div>
						  </form>
					    </div>
					   </div>
					  <!-- /.col -->
					</div>
					<!-- /.row -->
			     </div><!--/. container-fluid --> 
				 
				@endsection
				
				@section('script')
				
				
				 
				 @endsection