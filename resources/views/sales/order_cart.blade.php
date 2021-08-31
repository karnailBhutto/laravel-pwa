@extends('layouts.app')


				@section('header')
				
				<style>
				input[type=number]{
					width: 40px;
				}
				</style>
				
				<div class="container-fluid">
					<div class="row mb-2">
					  <div class="col-sm-6">
						<h5 class="m-0">Order Cart</h5>
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
					<!-- Info boxes -->
					<div class="row">
					  <div class="col-md-12">
						<div class="info-box">

						  <div class="info-box-content">
							<span class="info-box-text" id="outletid">Outlet ID : {{ str_pad($outlets->id, 11, '0', STR_PAD_LEFT) }}</span>
							<span class="info-box-text" id="outlet_sname">Outlet Name : {{ $outlets->outlet_sname }}</span>
							<span class="info-box-text">Ordered Date : {{ date('d-M-Y') }}</span>
							<span class="info-box-text">Sales Rep : {{ $outlets->name }}</span>
						  </div>
						  <!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					  </div>
					</div>
					
					<div class="row">
					  <div class="col-md-12">
						<div class="card">
						  <div class="card-body">
							<div class="row">
							  <div class="col-12">
								
								<div class="form-check"><input class="form-check-input" type="checkbox" name="order_empty" id="order_empty" onclick="myFunction()"><label class="form-check-label">No order today</label></div> 
								<hr>
								<p style="text-align:center"><img src="{{ asset('images/icon/shopping_cart.png') }}" width="110px" alt="order_cart" class="brand-image"></p>
							
								<p style="text-align:center">Oops, This outlet order cart is Empty. <br><small>Add new product now</small></p>
		
								<div class="row">
								 <!-- <div class="col-4">
									<button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#complete">Save</button>
								  </div>-->
								  <div class="col-6">
									<button type="button" class="btn btn-block btn-primary" id="btncomplete">Add new product</button>
								  </div>
								  <div class="col-6">
										<button type="button" class="btn btn-block btn-outline-primary" onclick="location.href='{{ route('orders.index', ['id' => $outlets->id]) }}'">Back</button>
								  </div>
								</div>
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
						<div class="modal-content">
							 <!--Modal header-->
							<div class="modal-header">
								<h6 class="modal-title">Add new product</h6>
								<button type="button" class="close" data-dismiss="modal"><i class="pci-cross pci-circle"></i></button>
							</div>
							
							<div class="modal-body" align="justify">
							<form id="add_new" method="post" action="{{ route('orders.store') }}">
								@csrf
								@method('POST')
								<div class="card">
								
								  <div class="card-body">
								  <h6>Category</h6>
								  @if($orders != null && $orders->order_empty == 2) <input type="hidden" name="order_no" value="{{$orders->id}}">@endif
									 <div id="recipeCarousel" class="carousel slide w-100" data-ride="carousel">
										<div class="carousel-inner w-100" role="listbox">
											<div class="carousel-item row no-gutters active">
											@foreach ($categories as $category)
												<div class="col-3 float-left">
												<input type="image" src="{{ asset($category->category_icon) }}" name="kategori" class="img-fluid category" id="category{{$category->id}}" value="{{$category->id}}" width="100px"/>
												</div>
											@endforeach
											</div>
										</div>
										<!--<a class="carousel-control-prev" href="#recipeCarousel" role="button" data-slide="prev">
											<span class="carousel-control-prev-icon" aria-hidden="true"></span>
											<span class="sr-only">Previous</span>
										</a>
										<a class="carousel-control-next" href="#recipeCarousel" role="button" data-slide="next">
											<span class="carousel-control-next-icon" aria-hidden="true"></span>
											<span class="sr-only">Next</span>
										</a>-->
									</div>
									<!--/row-->
									
									<h6 id="t1" style="display:none"><br>Brand / Sub-brand</h6>
									<div class="row" id="brands" style="display:none">
										<table id="demo-dt-basic" class="table table-responsive" cellspacing="0" width="100%">
											<tr>	
												<td id="sbrand">
												</td>
											</tr>
										</table>
									</div>
									<!--/row-->
									
									<h6 id="t2" style="display:none">Types</h6>
									<div class="form-group" id="stype">
										<!--content-->
									</div>
									<!--row-->
									
									<div class="row" id="slist" style="display:none">
										<div class="col-12">
										<input type="hidden" name="outlet" value="{{$outlets->id}}">
											<table id="demo-dt-basic" class="table table-responsive table-bordered" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th rowspan="2">Product</th>
														<!--<th rowspan="2">Pack per Carton</th>-->
														<th colspan="2">Quantity Order</th>
													</tr>
													<tr>
														<th rowspan="2">Carton</th>
														<th rowspan="2">Pack</th>
													</tr>
												</thead>
												<tbody id="prod-list">
												</tbody>
											</table>
										</div>
									</div>
									<hr>
									<div class="row">
									  <div class="col-6">
										<button type="submit" class="btn btn-block btn-primary" id="save" style="display:none">Save</button>
									  </div>
									  <!--<div class="col-4">
										<button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#complete" id="add" style="display:none">Next</button>
									  </div>-->
									  <div class="col-6">
										<button type="button" class="btn btn-block btn-outline-primary" data-dismiss="modal">Close</button>
									  </div>
									</div>
								  </div>
								</div>
								
							</div>
							
							<!--Modal footer
							<div class="modal-footer">
								
							</div>-->
							</form>	
						</div>
					</div>
				</div>
				<!-- end of modal completed -->
				 
				@endsection
				
				@section('script')
				
				<script src="{{ asset('js/indexeddb/order_cartDB.js') }}"></script>
				
				<script>
				$(document).ready(function() {
					if (!navigator.onLine) { loadData(); }
				});
				</script>
				
				<script type="text/javascript">
				$(document).ready(function(){ @foreach ($categories as $category)
					$('#category{{$category->id}}').click(function(event) {
						event.preventDefault();
						$(".category").css('opacity',0.5);
						$("#category{{$category->id}}").css('opacity',1);
	
						var catID = $(this).val();
							if(catID) { 
								$.ajax({
									url: '/myorder/ajax/'+catID,
									type: "GET",
									dataType: "json",
									success:function(data) { 
										//console.log(data);
										$('#t1').show();
										$('#brands').show();
										$('#sbrand').empty();
										$('#stype').empty();
										$('#t2').hide();
										$('#slist').hide();
										$('#prod-list').empty();
										$.each(data, function(key, value) {
											var item = '<input type="image" src="/'+ value +'" name="brand'+ key +'" class="brand" id="brand'+ key +'" value="'+ key +'" height="110px"/>';
											
											$('#sbrand').append(item);
										});
									}
								});
						}else{
								$('#sbrand').empty();
								$('#stype').empty();
								$('#t2').hide();
								$('#slist').hide();
								$('#prod-list').empty();
								
						}
							});
						@endforeach
				});	
					
				$(document).ready(function(){
					@foreach ($brands as $sub) 
					$(document).on('click','#brand{{$sub->idbrands}}',function(event) {
					//alert('test');
						event.preventDefault();
						$(".brand").css('opacity',0.5);
						$("#brand{{$sub->idbrands}}").css('opacity',1);
						
						var subID = $(this).val();
							if(subID) { 
								$.ajax({
									url: '/myorder/pack/'+subID,
									type: "GET",
									dataType: "json",
									success:function(data) { 
										//console.log(data);
										$('#t2').show();
										$('#stype').empty();
										$('#slist').hide();
										$('#prod-list').empty();
										$.each(data, function(key, value) {
											var item = '<div class="form-check"><input class="form-check-input" type="radio" name="ty" id="ty" value="'+ key +'"><label class="form-check-label">'+ value +'</label></div>';
											
											$('#stype').append(item);
										});
									}
								});
							}else {
									$('#stype').empty();
									$('#slist').hide();
									$('#prod-list').empty();
								}
							});
					@endforeach
				});
				
				$(document).ready(function(){
					
					$(document).on('click','#ty',function() {
						var subID = $(this).val(); //alert(subID);
							if(subID) { 
								$.ajax({
									url: '/myorder/prod/'+subID,
									type: "GET",
									dataType: "json",
									success:function(data) { 
										console.log(data); //alert(subID);
										$('#slist').show();
										$('#prod-list').empty();
										$('#save').show();
										$('#add').show();
										$.each(data, function(key, value) {
											
											var item = '<tr><td>'+ value +'</td><td><input type="number" name="carton[]" min="0" placeholder="0"></td><td><input type="number" name="packs[]" min="0" placeholder="0"><input type="hidden" name="sku[]" value="'+ key +'"></td></tr>';
											
											$('#prod-list').append(item);
										});
									}
								});
							}else{
									$('#slist').hide();
									$('#prod-list').empty();
								}
							});
				});
				
				//$('#order_empty').click(function(event) {
				function myFunction() {
					// Get the checkbox
					var checkBox = document.getElementById("order_empty");
					if (checkBox.checked == true){ //alert('ada');
						//event.preventDefault();
						
						var catID = 1; //alert(catID);
						var outlet = {{$outlets->id}};
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
							 window.location="{{ route('orders.index', ['id' => $outlets->id]) }}";
							return false;
							}
						}
					else {
						var catID = 2; //alert(catID);
						var outlet = {{$outlets->id}};
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
							 //window.location="{{ route('orders.index', ['id' => $outlets->id]) }}";
						return false;
						}
					} 
				};	
				
				$("#btncomplete").click(function(){
					$("#complete").modal({
						//backdrop: "static",
						//keyboard: false
					});
				});
				
				// $('#add_new').on("submit", function(e){  
					// e.preventDefault();  
					
					// $.ajax({  
						// url:"{{ route('orders.store') }}",  
						// method:"POST",  
						// data:$('#add_new').serialize(),  
						// success:function(response){  
							// $('#slist').hide();
							// $('#prod-list').empty();
							// $("#notify").show();
				  
						// },
						// error: function(error) {
							/////console.log(error);
							// alert('Answer Not Submitted');
						// }
					// }); 
				// }); 
				
				// window.setTimeout(function() {
					// $(".alert").fadeTo(500, 0).slideUp(500, function(){
						// $(this).remove(); 
					// });
				// }, 5000);
				</script>
				
				@endsection