@extends('layouts.app')


<style>
input[type=number]{
    width: 40px;
}
</style>

				@section('header')
				<div class="container-fluid">
					<div class="row mb-2">
					  <div class="col-sm-6">
						<h5 class="m-0">User Management</h5>
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
					<!--<div class="row">
					  <div class="col-md-12">
						<div class="info-box">

						  <div class="info-box-content">
							<span class="info-box-text">Date : {{ date('Y-m-d') }}</span>
						  </div>
						</div>
					  </div>
					</div>-->
					
					<!--<div class="row">
						<div class="col-4">
						
					  </div>
					  <div class="col-4">
					  </div>
					  <div class="col-4" style="text-align:right">
							<button type="button" class="btn btn-block btn-primary" onclick="location.href=''">Add user</button>
					  </div>
					</div>
					<br>-->
					
					<div class="row">
					  <div class="col-md-12">
						<div class="card">
						  <div class="card-body">
							<div class="row">
							  <div class="col-12">
							  
								@if ($message = Session::get('success'))
								<div class="alert alert-success alert-dismissible">
									<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>{{ $message }}</strong>
								</div>
							    @endif
								
								<table id="example1" class="table table-bordered">
										<thead>
											<tr>
												<th>#</th>
												<th>Name</th>
												<th>Username</th>
												<th>Region</th>
												<th>Last Login</th>
												<th>Role</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
										@foreach($users as $user)
											<tr>
												<td>
													{{ $loop->iteration }}
												</td>
												<td>
													{{ $user->name }}
												</td>
												<td>
													{{ $user->username }}
												</td>
												<td>
													@if($user->region_name !=null) {{ $user->region_name }} @else Cambodia @endif
												</td>
												<td>
													{{ $user->login }}
												</td>
												<td>
													@if($user->role == 3) Sales Manager @elseif($user->role == 4) Sales Rep @elseif($user->role == 5) Sales Supervisor @elseif($user->role == 6) Managing Director  @endif
												</td>
												<td>
													<button type="button" class="btn btn-block btn-primary btn-sm" data-toggle="modal" data-target="#complete" data-id="{{ $user->id }}">Set Password</button>
												</td>
											</tr>
										 @endforeach
									</table>
								
							  </div>
							</div>
							<!-- /.row -->
						  </div>
					    </div>
					   </div>
					  <!-- /.col -->
					</div>
			     </div><!--/. container-fluid -->
				 
				 <!--modal add product-->
				<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="complete">
					<div class="modal-dialog modal-lg" height="100%">
						<form class="form-horizontal" action="{{ route('users.update','reset') }}" method="POST">
						@csrf
						@method('PUT')
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Set new password</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<div class="form-row">
									<div class="col-md-12">
									<input name="id" type="hidden" class="form-control" id="id">
										<div class="position-relative form-group"><label class="">Set new password <span style="color:red">*</span></label><input name="password" type="text" class="form-control" required ></div>
									</div>
								</div>
								<div class="form-row">
									<div class="col-md-12">
										<div class="position-relative form-group"><label class="">Confirm new password <span style="color:red">*</span></label><input name="password1" type="text" class="form-control" required ></div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn btn-primary">Save Password</button>
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							</div>
						</div>
						</form>
					</div>
				</div>
				<!-- end of modal completed -->
				 
				@endsection
				
				@section('script')
				
				<script type="text/javascript">
				$('#complete').on('show.bs.modal', function(e) {
					var id = $(e.relatedTarget).data('id');
					
					$(e.currentTarget).find('input[name="id"]').val(id);
				});
	
				//$('#order_empty').click(function(event) {
				function myFunction() {
					// Get the checkbox
					var checkBox = document.getElementById("order_empty");
					if (checkBox.checked == true){ //alert('ada');
						//event.preventDefault();
						
						var catID = 1; //alert(catID);
						var outlet = 1;
						var order = 0;						//alert(outlet);
							if(catID) { 
								$.ajax({
									url: '/myorder/order/'+catID+'/'+order+'/'+outlet,
									type: "GET",
									dataType: "json",
									success:function(data) { 
										//console.log(data);
									}
								});
							return false;
							}
						}
					else {
						var catID = 2; //alert(catID);
						var outlet = 1;
						var order = 0;			//alert(outlet);
							if(catID) { 
								$.ajax({
									url: '/myorder/order/'+catID+'/'+order+'/'+outlet,
									type: "GET",
									dataType: "json",
									success:function(data) { 
										//console.log(data);
									}
								});
						return false;
						}
					} 
				};	
				</script>
				
				@endsection