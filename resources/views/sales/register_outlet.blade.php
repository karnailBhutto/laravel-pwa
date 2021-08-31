@extends('layouts.app')

				@section('header')
				<div class="container-fluid">
					<div class="row mb-2">
					  <div class="col-sm-6">
						<h5 class="m-0">Outlet Details</h5>
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
						  <!--<div class="card-header">
							<h6 class="card-title">Find outlet by enter outlet name or ID</h6>
						  </div>-->
									
						  <form action="{{ route('outlets.update', $outlets->id) }}" method="post">
						  
						   @csrf
						   @method('PUT')
						   <input type="hidden"  id="token1" name="token1" value="{{ Session::token() }}">
						  
						  <div class="card-body">
							<div class="row">
							  <div class="col-12">
							  
							  @if ($message = Session::get('success'))
								<div class="alert alert-success alert-dismissible">
									<button type="button" class="close" data-dismiss="alert">x</button>
										<strong>{{ $message }}</strong>
								</div>
							  @endif
							  
							  <input type="hidden" class="form-control" id="outletid" name="outletid" value="{{ $outlets->id }}">
							  <input type="hidden" class="form-control" id="team_id" name="team_id" value="{{ Auth::user()->current_team_id }}">
							  <input type="hidden" class="form-control" id="update" name="update" value="{{ Auth::user()->id }}">
							  
								<div class="form-group">
								  <label>Outlet ID</label>
								  <input type="text" class="form-control" id="outlet_id" name="outlet_id" value="{{ str_pad($outlets->id, 11, '0', STR_PAD_LEFT) }}" readonly>
								</div>
								
								<div class="form-group">
								  <label>Outlet / Shop Name</label>
								  <input type="text" class="form-control" id="outlet_sname" name="outlet_sname" value="{{ $outlets->outlet_sname }}" required="required">
								</div>
								
								<div class="form-group">
								  <label>Outlet Type</label>
								  <select class="form-control select2" style="width: 100%;" id="outlet_type" name="outlet_type" required="required">
								    <option value="">Choose Outlet Type</option>
									@foreach ($types as $key => $value)
										<option value="{{ $key }}" @if($outlets != null && $outlets->outlet_type == $key) selected @endif>{{ $value }}</option>
									@endforeach
								  </select>
								</div>
								
								<div class="form-group">
								  <label>Owner Name</label>
								  <input type="text" class="form-control" id="outlet_owner" name="outlet_owner" value="{{ $outlets->outlet_owner }}" required="required">
								</div>
								
								<div class="form-group">
								  <label>Contact No. <small>(e.g. +855 XX XXX XXXX)</small></label>
								  <input type="text" class="form-control" id="outlet_contact" name="outlet_contact" value="{{ $outlets->outlet_contact }}" required="required">
								</div>
								
								<div class="form-group">
								  <label>Region</label>
								  <select class="form-control select2" style="width: 100%;" id="outlet_region" name="outlet_region" required="required">
								    <option>Choose Region</option>
									@foreach ($regions as $key => $value)
										<option value="{{ $key }}" @if($outlets != null && $outlets->outlet_region == $key) selected @endif>{{ $value }}</option>
									@endforeach
								  </select>
								</div>
								
								<div class="form-group">
								  <label>Province</label>
								  <select class="form-control select2" style="width: 100%;" id="outlet_province" name="outlet_province" required="required">
								  <option>Choose Province</option>
									@foreach ($cities as $city)
										<option value="{{ $city->province_code }}" @if($outlets != null && $outlets->outlet_province == $city->province_code) selected @endif>{{ $city->province_name }}</option>
									@endforeach
								  </select>
								</div>
								
								<div class="form-group">
								  <label>District</label>
								  <select class="form-control select2" style="width: 100%;" id="outlet_district" name="outlet_district" required="required">
								  <option>Choose District</option>
								    @foreach ($towns as $town)
										<option value="{{ $town->iddistricts }}" @if($outlets != null && $outlets->outlet_district == $town->iddistricts) selected @endif>{{ $town->district_name }}</option>
									@endforeach
								  </select>
								</div>
								
								<div class="form-group">
								  <label>Postal Code (optional)</label>
								  <input type="text" class="form-control" id="outlet_postal" id="outlet_postal" name="outlet_postal" value="{{ $outlets->outlet_postal }}">
								</div>
								
								<div class="form-group">
								  <label>Address</label>
								  <input type="text" class="form-control" id="outlet_address" name="outlet_address" value="{{ $outlets->outlet_address }}" required="required">
								  
								   <input type="hidden" class="form-control" name="updated_by" id="updated_by" value="{{ Auth::user()->id}}">
								</div>
								
								<hr>
								
							  </div>
							</div>
							
							<div class="row">
							  <div class="col-6">
								<button type="submit" id="submit" class="btn btn-block btn-primary">Save</button>
							  </div>
							  <div class="col-6">
									<button type="button" class="btn btn-block btn-outline-primary" @if($outlets->outlet_sname == null) disabled @endif id="nextid">Next</button>
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
				
				<script src="{{ asset('js/indexeddb/register_outletDB.js') }}"></script>
				
				<script>
				window.addEventListener('load', function() {
					if (!navigator.onLine) { openIndexedDBDatabase(); }
				});
				</script>
				
				<script type="text/javascript">
				
				function checkCheckBoxes(theForm) {

					var phonenumber = /^\+855([\s]?\d{2}[\s]?)?(\d{3}[\s]?)\d{3,4}/;
					var x=document.getElementById("outlet_contact").value;
					if(phonenumber.test(x)==true) {
						//alert("Employee id ");
					}else if(phonenumber.test(x)==false){
						alert("Please insert mobile number as requested format");
						return false;
						}
				}
				</script>
				
				<script type="text/javascript">
					$(document).ready(function() {
						$('input[name="_token"]').attr('id','token');
						$('select[name="outlet_region"]').on('change', function() {
							
							var stateID = $(this).val();
							if(stateID) {
								$.ajax({
									url: '/myform/ajax/'+stateID,
									type: "GET",
									dataType: "json",
									success:function(data) {

										
										$('select[name="outlet_province"]').empty();
										$('select[name="outlet_district"]').empty();
										$('select[name="outlet_province"]').append('<option>Choose Province</option>');

										$.each(data, function(key, value) {
											$('select[name="outlet_province"]').append('<option value="'+ key +'">'+ value +'</option>');
										});


									}
								});
							}else{
								$('select[name="outlet_province"]').empty();
								$('select[name="outlet_district"]').empty();
							}
						});
					});
					
					$(document).ready(function() {
						$('select[name="outlet_province"]').on('change', function() {
							var stateID = $(this).val();
							if(stateID) {
								$.ajax({
									url: '/myform/town/'+stateID,
									type: "GET",
									dataType: "json",
									success:function(data) {

										
										$('select[name="outlet_district"]').empty();
										$.each(data, function(key, value) {
											$('select[name="outlet_district"]').append('<option value="'+ key +'">'+ value +'</option>');
										});


									}
								});
							}else{
								$('select[name="outlet_district"]').empty();
							}
						});
					});
				</script>
				
				<script>
				if (!navigator.onLine) {} else {
					$('#nextid').on("click", function(e){  
						e.preventDefault();  
						
						$.ajax({  
							url:"{{ route('outlets.visit', ['id' => $outlets->id]) }}",  
							type: "GET",
							dataType: "json",
							success:function(response){  
								//console.log(response);
							}
						}); 
						window.location = "{{ route('orders.index', ['id' => $outlets->id]) }}";
					}); 
				}
				</script>
				@endsection