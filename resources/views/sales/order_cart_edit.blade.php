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
				<div class="container-fluid" id="reload">
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
						<div class="col-3">
						
					  </div>
					  <div class="col-3">
						
					  </div>
					  <div class="col-6" id="btn">
						<button type="button" class="btn btn-block btn-primary" id="btncomplete">Add new product</button>
						
					  </div>
					</div>
					<br>
					
					<div class="row">
					  <div class="col-12">
						<div class="card">
						  <div class="card-body">
							<div class="row" id="reload1">
							
								<form method="POST" action="@if($order1 != null){{ route('orders.update', $order1->id) }} @endif">
								@csrf
								@method('PUT') 
								
								<div class="col-12">
								
							    @if ($message = Session::get('success'))
								<div class="alert alert-success alert-dismissible">
									<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>{{ $message }}</strong>
								</div>
							    @endif
								
								<div class="form-check"><input class="form-check-input" type="checkbox" name="order_empty" id="order_empty" @if($order1 != null && $order1->order_empty == 1)checked="checked"@endif ><label class="form-check-label">No order today</label></div>
								<br>
								<table style="overflow-x:auto;" class="table table-bordered" width="100%" id="myTable">
										<thead>
											<tr>
												<th colspan="2" rowspan="2">Product Item</th>
												<th colspan="2">Quantity Order</th>
											</tr>
											<tr>
												<th>Carton</th>
												<th>Pack</th>
			
											</tr>
										</thead>
										<tbody>
										@if($category1->count() > 0) 
											<tr>
												<td colspan="4">
													Baby
												</td>
											</tr>
										@endif
										<?php $sum1=0; $sums1=0; ?>
										@foreach($category1 as $cat1)
											<tr>
												<td>
													<a href="#" data-target="#deletefunc" data-toggle="modal" data-id="{{ $cat1->iddetails }}" class="btn"><i class="fa fa-times-circle"></i></a>
												</td>
												<td>
													{{ $cat1->product_description }}
													<input type="hidden" name="sku1[]" value="{{ $cat1->iddetails }}">
												</td>
												<td>
													<input type="number" name="carton1[]" min="0" value="{{ $cat1->order_carton }}" placeholder="0">
												</td>
												<td>
													<input type="number" name="packs1[]" min="0" value="{{ $cat1->order_pack }}" placeholder="0">
												</td>
												<?php 
												$sum1+= $cat1->order_carton; 
												$sums1+= $cat1->order_pack; 
												?>
											</tr>
										 @endforeach
										 @if(count($category1) > 0)
											<tr>
												<td>
													&nbsp;
												</td>
												<td>
													Total
												</td>
												<td>
													{{ $sum1 }}
												</td>
												<td>
													{{ $sums1 }}
												</td>
											</tr>
										@endif
										@if($category2->count() > 0) 
											<tr>
												<td colspan="4">
													Feminine Care
												</td>
											</tr>
										@endif
										<?php $sum2=0; $sums2=0; ?>
										@foreach($category2 as $cat1)
											<tr>
												<td>
													<a href="#" data-target="#deletefunc" data-toggle="modal"  data-id="{{ $cat1->iddetails }}" class="btn"><i class="fa fa-times-circle"></i></a>
												</td>
												<td>
													{{ $cat1->product_description }}
													<input type="hidden" name="sku2[]" value="{{ $cat1->iddetails }}">
												</td>
												<td>
													<input type="number" name="carton2[]" min="0" value="{{ $cat1->order_carton }}" placeholder="0">
												</td>
												<td>
													<input type="number" name="packs2[]" min="0" value="{{ $cat1->order_pack }}" placeholder="0">
												</td>
												<?php 
												$sum2+= $cat1->order_carton; 
												$sums2+= $cat1->order_pack; 
												?>
											</tr>
										 @endforeach
										 @if(count($category2) > 0)
											<tr>
												<td>
													&nbsp;
												</td>
												<td>
													Total
												</td>
												<td>
													{{ $sum2 }}
												</td>
												<td>
													{{ $sums2 }}
												</td>
											</tr>
										@endif
										@if($category3->count() > 0) 
											<tr>
												<td colspan="4">
													Incontinence Care
												</td>
											</tr>
										@endif
										<?php $sum3=0; $sums3=0; ?>
										@foreach($category3 as $cat1)
											<tr>
												<td>
													<a href="#" data-target="#deletefunc" data-toggle="modal"  data-id="{{ $cat1->iddetails }}" class="btn"><i class="fa fa-times-circle"></i></a>
												</td>
												<td>
													{{ $cat1->product_description }}
													<input type="hidden" name="sku3[]" value="{{ $cat1->iddetails }}">
												</td>
												<td>
													<input type="number" name="carton3[]" min="0" value="{{ $cat1->order_carton }}" placeholder="0">
												</td>
												<td>
													<input type="number" name="packs3[]" min="0" value="{{ $cat1->order_pack }}" placeholder="0">
												</td>
												<?php 
												$sum3+= $cat1->order_carton; 
												$sums3+= $cat1->order_pack; 
												?>
											</tr>
										 @endforeach
										 @if(count($category3) > 0)
											<tr>
												<td>
													&nbsp;
												</td>
												<td>
													Total
												</td>
												<td>
													{{ $sum3 }}
												</td>
												<td>
													{{ $sums3 }}
												</td>
											</tr>
										@endif
										@if($category4->count() > 0) 
											<tr>
												<td colspan="4">
													Vinda Deluxe
												</td>
											</tr>
										@endif
										<?php $sum4=0; $sums4=0; ?>
										@foreach($category4 as $cat1)
											<tr>
												<!--<td>
													{{ $cat1->category_name }}
												</td>-->
												<td>
													<a href="#" data-target="#deletefunc" data-toggle="modal"  data-id="{{ $cat1->iddetails }}" class="btn"><i class="fa fa-times-circle"></i></a>
												</td>
												<td>
													{{ $cat1->product_description }}
													<input type="hidden" name="sku4[]" value="{{ $cat1->iddetails }}">
												</td>
												<td>
													<input type="number" name="carton4[]" min="0" value="{{ $cat1->order_carton }}" placeholder="0">
												</td>
												<td>
													<input type="number" name="packs4[]" min="0" value="{{ $cat1->order_pack }}" placeholder="0">
												</td>
												<?php 
												$sum4+= $cat1->order_carton; 
												$sums4+= $cat1->order_pack; 
												?>
											</tr>
										 @endforeach
										 @if(count($category4) > 0)
											<tr>
												<td>
													&nbsp;
												</td>
												<td>
													Total
												</td>
												<td>
													{{ $sum4 }}
												</td>
												<td>
													{{ $sums4 }}
												</td>
											</tr>
										@endif
										</tbody>
										<?php 
												$sumall= $sum1+$sum2+$sum3+$sum4; 
												$sumsall= $sums1+$sums2+$sums3+$sums4;
												?>
										<tfoot>
											<tr>
												<td colspan="2">
													Grand Total
												</td>
												<td id="tot1">
													{{ $sumall }}
												</td>
												<td id="tot2">
													{{ $sumsall }}
												</td>
											</tr>
										</tfoot>
									</table>
								
							  </div>
							  
							  <hr>
							  <div class="row">
								<div class="col-4">
									<button type="submit" id="update" class="btn btn-block btn-primary">Update</button>
								</div>
								</form>
								<div class="col-4">
									<form id="confirm" method="post">
									@csrf
									<input type="hidden" name="outlet" value="{{$outlets->outlet_sname}}">
									<button type="submit" class="btn btn-block btn-primary">Confirm</button>
									</form>
								</div>
								<div class="col-4">
									<button type="button" class="btn btn-block btn-outline-primary" id="close">Close</button>
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
							
							<div id="notify1" style="display:none;" class="alert alert-success">
								<button type="button" class="close" data-dismiss="alert">&times;</button>
								<strong>SKUs has been added to your order cart</strong>
							</div>
								
							<form id="addnew" method="POST">
								@csrf
								@method('POST') 
								
								<div class="card">
								  <div class="card-body">
								  <h6>Category</h6>
									 <div id="recipeCarousel" class="carousel slide w-100" data-ride="carousel">
										<div class="carousel-inner w-100" role="listbox">
											<div class="carousel-item row no-gutters active">
											@foreach ($categories as $category)
												<div class="col-3 float-left">
												<input type="image" src="{{ asset($category->category_icon) }}" name="kategori" class="img-fluid category" id="category{{$category->id}}" value="{{$category->id}}" width="100px"/>
												</div>
											@endforeach
											</div>
											<input type="hidden" class="fourth" id="cate" name="category">
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
									
									<h6 id="t1" style="display:none"><br> Brand / Sub-brand</h6>
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
											<table id="demo-dt-basic" class="table table-bordered table-responsive" cellspacing="0" width="100%">
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
									<div class="row" id="reload2">
									<input type="hidden" name="order_no" @if($order1 != null)value="{{$order1->id}}" @else value="0" @endif>
									  <div class="col-6">
										<button type="submit" class="btn btn-block btn-primary" id="save" style="display:none">Save</button>
									  </div>
									  <div class="col-6">
										<button type="button" class="btn btn-block btn-outline-primary" id="tutup" data-dismiss="modal"
										>Close</button>
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
				
				<!-- delete function -->
				<div class="modal fade" id="deletefunc" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
					<div class="modal-dialog">
						<form id="product" method="POST" action="@if($order1 != null) route('orders.destroy', ['id' => $order1->id]) @endif">
						@csrf
						@method('DELETE') 
						<div class="modal-content">
							<!--Modal body-->
							<div class="modal-body">
								<div class="panel-body">
									<p>Are you sure want to delete this SKU? </p>
									<input type="hidden" class="form-control" name="id1" id="id1">
								</div>
							</div>

							<!--Modal footer-->
							<div class="modal-footer">
								<button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
								<button class="btn btn-danger" id="remove" type="submit">Yes, delete.</button>
							</div>
						</div>
						</form>
					</div>
				</div>
				<!-- end of delete -->
				 
				@endsection
				
				@section('script')
				
				<script src="{{ asset('js/indexeddb/order_cartDB.js') }}"></script>
				
				<script>
				$(document).ready(function() {
					if (!navigator.onLine) { 
						loadData(); 
					}
					else 
					{
						$('#close').on("click", function(e){  
							e.preventDefault();   
							window.location = "{{ route('orders.index', ['id' => $outlets->id]) }}";
						}); 
					
						$('#confirm').on("submit", function(e){  
							e.preventDefault();  
							<?php if($order1 != null) $id = $order1->id; else $id=0; ?>
							$.ajax({  
								url:"{{route('orders.status', ['id' => $id])}}",  
								method:"POST",  
								data:$('#confirm').serialize(),  
								success:function(response){  
									alert('Order line has been confirmed');
									window.location = "{{route('orders.show', [$id])}}";
								},
								error: function(error) {
									//console.log(error);
									alert('Answer Not Submitted');
								}
							}); 
						}); 

						$("#order_empty").click(function myFunction() {
							// Get the checkbox
							var checkBox = document.getElementById("order_empty");
							if (checkBox.checked == true){ 
								//event.preventDefault();
								
								var catID = 1; //alert(catID);
								var outlet = {{$outlets->id}};
								var order = @if($order1 != null){{$order1->id}} @else 0 @endif;							//alert(order);
									if(catID) { 
										$.ajax({
											url: '/myorder/order?id='+catID+'&order='+order+'&outlet='+outlet,
											type: "GET",
											dataType: "json",
											success:function(data) { 
												console.log(data);
											}
										});
										
										alert('No order today for this store. You will redirect to Order History.');
										window.location="{{ route('orders.index', ['id' => $outlets->id]) }}";

									return false;
									}						
								}
							else {
								var catID = 2; //alert(catID);
								var outlet = {{$outlets->id}};
								var order = @if($order1 != null){{$order1->id}} @else 0 @endif;			//alert(outlet);
									if(catID) { 
										$.ajax({
											url: '/myorder/order?id='+catID+'&order='+order+'&outlet='+outlet,
											type: "GET",
											dataType: "json",
											success:function(data) { 
												//console.log(data);
											}
										});
										
									alert('No order today was removed. Please click on "Add New Product" to add item.');
									//window.location="{{ route('orders.index', ['id' => $outlets->id]) }}";
								return false;
								}
							} 
						});	
					}
				});
				</script>
				
				<script type="text/javascript">
				//$(document).ready(function(){					
				@foreach ($categories as $category)
					$('#category{{$category->id}}').click(function(event) {
						event.preventDefault();
						$(".category").css('opacity',0.5);
						$("#category{{$category->id}}").css('opacity',1);
						$('#notify1').hide();
	
						var catID = $(this).val();
						if(catID == 1) { var id = "Baby"; } else if(catID == 2) { var id = "Feminine Care"; } else if(catID == 3) { var id = "Incontinence Care"; } else if(catID == 4) { var id = "Consumer Tissue"; }
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
											var item = '<input type="image" src="https://sfa-staging.vindagroupsea.com/'+value+'" name="brand'+ key +'" class="brand" id="brand'+ key +'" value="'+ key +'" height="110px"/>';
											
											$('#sbrand').append(item);
										});
										
										$('#cate').val(id);
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
				//});	
					
				//$(document).ready(function(){
					@foreach ($brands as $sub) 
					$(document).on('click','#brand{{$sub->idbrands}}',function(event) {
					//alert('test');
						event.preventDefault();
						$(".brand").css('opacity',0.5);
						$("#brand{{$sub->idbrands}}").css('opacity',1);
						$('#notify1').hide();
						
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
				//});
				
				//$(document).ready(function(){
					$(document).on('click','#ty',function() {
						$('#notify1').hide();
						var subID = $(this).val();
							if(subID) { 
								$.ajax({
									url: '/myorder/prod1/'+subID+'?order=@if($order1 != null){{$order1->id}} @else 0 @endif',
									type: "GET",
									dataType: "json",
									success:function(data) { 
										//console.log(data);
										$('#slist').show();
										$('#save').show();
										$('#add').show();
										$('#prod-list').empty();
										$.each(data, function(key, value) {
											
											var item = '<tr><td>'+ value +'</td><td><input type="number" class="first" name="carton[]" min="1" placeholder="0"></td><td><input type="number" class="second" name="packs[]" min="1" placeholder="0"><input type="hidden" class="third" name="sku[]" value="'+ key +'"><input type="hidden" class="fifth" name="desc" value="'+ value +'"></td></tr>';
											
											$('#prod-list').append(item);
										});
									}
								});
							}else{
									$('#slist').hide();
									$('#prod-list').empty();
								}
							});
				//});
				</script>
				
				<script>
				$(document).ready(function(){
					$("#btncomplete").click(function(){ //alert('ada');
						$("#complete").modal({ 
							backdrop: "static",
							keyboard: false
						});
					});
					
					$('#deletefunc').on('show.bs.modal', function(e) {
						var id = $(e.relatedTarget).data('id');
						
						$(e.currentTarget).find('input[name="id1"]').val(id);
					});
				});
				
				$(document).ready(function(){
					$('#addnew').on("submit", function(e){ //alert('stop!!!'); 
						e.preventDefault();  
						
						$.ajax({  
							url:"{{ route('orders.store') }}",  
							method:"POST",  
							data:$('#addnew').serialize(),  
							success:function(response){  
								//console.log(response);
								//alert('clicked')
								$("#reload").load(" #reload > *");
								$("#reload1").load(" #reload1 > *");
								$("#reload2").load(" #reload2 > *");
								$('#slist').hide();
								$('#prod-list').empty();
								$('#notify1').show();
								//$('#note').show();
							},
							error: function(error) {
								//console.log(error);
								//alert('Answer Not Submitted');
								$('#slist').hide();
								$('#prod-list').empty();
								$('#notify1').show();
							}
						}); 
					});
				});
					
				// window.setTimeout(function() {
					// $(".notify1").fadeTo(500, 0).slideUp(500, function(){
						// $(this).remove(); 
					// });
				// }, 5000);
				</script>
				
				@endsection