@extends('layouts.app')


				@section('header')
				
				<style>
				input[type=number]{
					width: 40px;
				}
				
				th.dt-center, td.dt-center { text-align: center; }
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
							<span class="info-box-text">Outlet ID : {{ str_pad($outlets->id, 11, '0', STR_PAD_LEFT) }}</span>
							<span class="info-box-text">Outlet Name : {{ $outlets->outlet_sname }}</span>
							<span class="info-box-text">Ordered Date : {{ date('Y-m-d',strtotime($outlets->created_at)) }}</span>
							<span class="info-box-text">Sales Rep : {{ $outlets->name }}</span>
						  </div>
						  <!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					  </div>
					</div>
					
					<div class="row">
						<div class="col-4">
						 <!--empty-->
					  </div>
					  <div class="col-4">
						<!--<button type="button" class="btn btn-block btn-outline-primary" onclick="location.href='{{ route('orders.index', ['id' => $outlets->id]) }}'">Order History</button>-->
					  </div>
					  <div class="col-4" style="text-align:right">
						@if($outlets->order_empty == 2  && count($orders) > 0)
							
							@if($outlets->order_status == 1 && $outlets->created_at != date('Y-m-d')) 
								<button type="button" class="btn btn-block btn-primary" onclick="location.href='{{ route('orders.reorder', $outlets->orderid) }}'">Re-order</button>
							@else
								<button type="button" class="btn btn-block btn-primary" onclick="location.href='{{ route('orders.edit', $outlets->orderid) }}'"> Edit</button>
							@endif
						@endif
					  </div>
					</div>
					<br>
					
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
	
							  @if(count($orders) > 0)
								<table id="summary" class="table table-bordered">
										<thead>
											<tr>
												<th rowspan="2">Product Item</th>
												<th colspan="2" style="text-align: center;">Quantity Order</th>
											</tr>
											<tr style="text-align: center;">
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
													{{ $cat1->product_description }}
												</td>
												<td style="text-align: center;">
													@if($cat1->order_carton == null) 0 @else {{ $cat1->order_carton }} @endif
												</td>
												<td style="text-align: center;">
													@if($cat1->order_pack == null) 0 @else {{ $cat1->order_pack }} @endif
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
													<p>TOTAL</p>
												</td>
												<td style="text-align: center;">
													<b>{{ $sum1 }}</b>
												</td>
												<td style="text-align: center;">
													<b>{{ $sums1 }}</b>
												</td>
											</tr>
										@endif
										@if(count($category1) > 0)<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>@endif
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
													{{ $cat1->product_description }}
												</td>
												<td style="text-align: center;">
													@if($cat1->order_carton == null) 0 @else {{ $cat1->order_carton }} @endif
												</td>
												<td style="text-align: center;">
													@if($cat1->order_pack == null) 0 @else {{ $cat1->order_pack }} @endif
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
													<p>TOTAL</p>
												</td>
												<td style="text-align: center;">
													<b>{{ $sum2 }}</b>
												</td>
												<td style="text-align: center;">
													<b>{{ $sums2 }}</b>
												</td>
											</tr>
										@endif
										@if(count($category2) > 0)<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>@endif
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
													{{ $cat1->product_description }}
												</td>
												<td style="text-align: center;">
													@if($cat1->order_carton == null) 0 @else {{ $cat1->order_carton }} @endif
												</td>
												<td style="text-align: center;">
													@if($cat1->order_pack == null) 0 @else {{ $cat1->order_pack }} @endif
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
													<p>TOTAL</p>
												</td>
												<td style="text-align: center;">
													<b>{{ $sum3 }}</b>
												</td>
												<td style="text-align: center;">
													<b>{{ $sums3 }}</b>
												</td>
											</tr>
										@endif
										@if(count($category3) > 0)<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>@endif
										@if($category4->count() > 0) 
											<tr>
												<td colspan="4">
													Feminine Care
												</td>
											</tr>
										@endif
										<?php $sum4=0; $sums4=0; ?>
										@foreach($category4 as $cat1)
											<tr>
												<td>
													{{ $cat1->product_description }}
												</td>
												<td style="text-align: center;">
													@if($cat1->order_carton == null) 0 @else {{ $cat1->order_carton }} @endif
												</td>
												<td style="text-align: center;">
													@if($cat1->order_pack == null) 0 @else {{ $cat1->order_pack }} @endif
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
													<p>TOTAL</p>
												</td>
												<td style="text-align: center;">
													<b>{{ $sum4 }}</b>
												</td>
												<td style="text-align: center;">
													<b>{{ $sums4 }}</b>
												</td>
											</tr>
										@endif
										@if(count($category4) > 0)<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>@endif
										</tbody>
										<tfoot>
										<?php 
												$sumall= $sum1+$sum2+$sum3+$sum4; 
												$sumsall= $sums1+$sums2+$sums3+$sums4;
												?>
											<tr>
												<td>
													<p>GRAND TOTAL</p>
												</td>
												<td style="text-align: center;">
													<b>{{ $sumall }}</b>
												</td>
												<td style="text-align: center;">
													<b>{{ $sumsall }}</b>
												</td>
											</tr>
										</tfoot>
									</table>
									
								@else
									
								<?php $date = date("Y-m-d") ?>
									
									<div class="form-check"><input class="form-check-input" type="checkbox" name="order_empty" id="order_empty" onclick="myFunction()" @if($outlets != null && $outlets->order_empty == 1)checked="checked"@endif @if($outlets->created_at != $date)) disabled @endif ><label class="form-check-label">No order today</label></div> 
									
									<p style="text-align:center"><img src="{{ asset('images/icon/shopping_cart.png') }}" width="110px" alt="order_cart" class="brand-image"></p>
								
									<p style="text-align:center">Oops, This outlet order cart is Empty. <br><small>Add new product now</small></p>
			
									<div class="row">
									  <div class="col-6">
										<button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#complete" id="reload" @if($outlets->order_empty == 1 || $outlets->created_at != $date) style="display:none" @endif>Add new product</button> 
									  </div>
									  <div class="col-6">
											<button type="button" class="btn btn-block btn-outline-primary" onclick="location.href='{{ route('orders.index', ['id' => $outlets->id]) }}'">Back</button>
									  </div>
									</div>
								@endif
							  </div>
							</div>
							<!-- /.row -->
							@if($outlets->order_empty == 2  && count($orders) > 0)
							<hr>
							<div class="row">
								<div class="col-4"></div>
								<div class="col-4"></div>
								<div class="col-4">
									<button type="button" class="btn btn-block  btn-outline-primary" onclick="location.href='{{ route('orders.index', ['id' => $outlets->id]) }}'">Close</button>
								</div>
							</div>
							@endif
							
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
						<form method="post" action="{{route('orders.store')}}">
								@csrf
								@method('POST')	 
							<!--Modal header-->
							<div class="modal-header">
								<h6 class="modal-title">Add new product</h6>
								<button type="button" class="close" data-dismiss="modal"><i class="pci-cross pci-circle"></i></button>
							</div>
							
							<div class="modal-body" align="justify">
							
						   
								<!--<div class="info-box">
								  <div class="info-box-content">
									<span class="info-box-text">Outlet ID : {{ str_pad($outlets->id, 11, '0', STR_PAD_LEFT) }}</span>
									<span class="info-box-text">Outlet Name : {{ $outlets->outlet_sname }}</span>
									<span class="info-box-text">Ordered Date : {{ $outlets->outlet_sname }}</span>
								  </div>
								</div>-->
								<div class="card">
								  <div class="card-body">
								  <h6>Category</h6>
								  <input type="hidden" name="order_no" value="{{$outlets->orderid}}">
								  
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
							
							<!--Modal footer-->
							<div class="modal-footer">
								
							</div>
							</form>	
						</div>	
					</div>
				</div>
				<!-- end of modal completed -->
				
				<!-- delete function -->
				<div class="modal fade" id="deletefunc" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
					<div class="modal-dialog">
						<form method="POST" action="{{ route('orders.destroy', $outlets->orderid) }}">
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
								<button class="btn btn-danger" type="submit">Yes, delete.</button>
							</div>
						</div>
						</form>
					</div>
				</div>
				<!-- end of delete -->
				 
				@endsection
				
				@section('script')
				
				<script type="text/javascript">
				//$(document).ready(function(){					
				@foreach ($categories as $category)
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
											var item = '<input type="image" src="/'+value+'" name="brand'+ key +'" class="brand" id="brand'+ key +'" value="'+ key +'" height="110px"/>';
											
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
				//});	
					
				//$(document).ready(function(){
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
				//});
				
				//$(document).ready(function(){
					$(document).on('click','#ty',function() {
						var subID = $(this).val();
							if(subID) { 
								$.ajax({
									url: '/myorder/prod?id='+subID,
									type: "GET",
									dataType: "json",
									success:function(data) { 
										console.log(data);
										$('#slist').show();
										$('#save').show();
										$('#add').show();
										$('#prod-list').empty();
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
				//});
				
				function myFunction() {
					// Get the checkbox
					var checkBox = document.getElementById("order_empty");
					if (checkBox.checked == true){ //alert('ada');
						//event.preventDefault();
						var catID = 1; //alert(catID);
						var outlet = {{$outlets->id}};
						var order = {{$outlets->orderid}};				//alert(outlet);
							if(catID) { 
								$.ajax({
									url: '/myorder/order?id='+catID+'&order='+order+'&outlet='+outlet,
									type: "GET",
									dataType: "json",
									success:function(data) { 
										//console.log(data);
										//$("#reload").hide();
										//$("#reload1").show();
									}
								});
							 window.location="{{ route('orders.index', ['id' => $outlets->id]) }}";
							return false;
							}
						}
					else {
						var catID = 2; //alert(catID);
						var outlet = {{$outlets->id}};
						var order = {{$outlets->orderid}};
																//alert(outlet);
							if(catID) { 
								$.ajax({
									url: '/myorder/order?id='+catID+'&order='+order+'&outlet='+outlet,
									type: "GET",
									dataType: "json",
									success:function(data) { //alert('test')
										//console.log(data);
										
										//$("#reload1").hide();
									}
								});
							$("#reload").show(); //window.location="{{ route('orders.index', ['id' => $outlets->id]) }}";
						return false;
						}
					} 
				};	
				</script>
				
				<script>
				$('#deletefunc').on('show.bs.modal', function(e) {
					var id = $(e.relatedTarget).data('id');
					
					$(e.currentTarget).find('input[name="id1"]').val(id);
				});
				</script>
				
				<script>
		  $(function () {
			$("#summary").DataTable({
				"columnDefs": [
					{"className": "dt-center", "targets": "3,4"}
				],
			  "responsive": true, "lengthChange": false, "autoWidth": false,"ordering": false,
			 // "buttons": ["excel", "pdf", "print", "colvis"]
			  buttons: [
					{
						extend: 'excel',
						title: 'Summary Order \n\n Outlet name : {{ $outlets->outlet_sname }} \n  Order Date: {{ date("d/m/Y",strtotime($outlets->created_at)) }} \n Sales name: {{ $outlets->name }} \n Sales ID: {{ $outlets->username }}',
						filename: 'SummaryOrder_{{ $outlets->outlet_sname }}_{{ date("d/m/Y",strtotime($outlets->created_at)) }}',
						autoFilter: true,
						footer: true
					},
					{
						extend: 'pdf',
						title: 'Summary Order \n\n Outlet name : {{ $outlets->outlet_sname }} \n  Order Date: {{ date("d/m/Y",strtotime($outlets->created_at)) }} \n Sales name: {{ $outlets->name }} \n Sales ID: {{ $outlets->username }}',
						filename: 'SummaryOrder_{{ $outlets->outlet_sname }}_{{ date("d/m/Y",strtotime($outlets->created_at)) }}',
						footer: true,
						//download: 'open',
						customize: function (doc) {
							//doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
							doc.content[1].table.widths = [ '25%',  '45%', '15%', '15%'];
							doc.styles.title.fontSize = 10;    
							doc.styles.title.alignment = 'justify';
							var rowCount = doc.content[1].table.body.length;
								for (i = 1; i < rowCount; i++) {
								doc.content[1].table.body[i][2].alignment = 'center';
								doc.content[1].table.body[i][3].alignment = 'center';
								}  							
						},
					},"colvis"
				]
			}).buttons().container().appendTo('#summary_wrapper .col-md-6:eq(0)');
		  });
		  
		</script>
				
				@endsection
