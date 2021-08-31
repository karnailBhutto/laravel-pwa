@extends('layouts.app')

				@section('header')
				<div class="container-fluid">
					<div class="row mb-2">
					  <div class="col-sm-6">
						<h5 class="m-0">Product Master</h5>
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
						  <div class="card-header">
							<h6 class="card-title">Product Listing By Category</h6>
						  </div>
						  <div class="card-body">
							<div class="row">
							  <div class="col-12">
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
					<!-- /.row -->
					
					<div class="row">
					  <div class="col-md-12">
						<div class="card">
						  <div class="card-header">
							<h6 class="card-title">Outlet Master List</h6>
						  </div>
						  <div class="card-body">
							<div class="row">
							  <div class="col-12" id="all" style="display:block">
								<table id="example2" class="table table-striped table-bordered" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>#</th>
											<th>Product</th>
											<th>Type / Packaging</th>
											<th>SKU Code</th>
										</tr>
									</thead>
									<tbody>
									@foreach($products as $product)
										<tr>
											<td>{{ $loop->iteration }}.</td>
											<td><a href="">{{ $product->product_description }} </a></td>
											<td>{{ $product->type_description }}</td>
											<td>{{ $product->product_sku }}</td>
										</tr>
									 @endforeach
									</tbody>
								</table>
							</div>
							
							<div class="col-12" id="baby" style="display:none">
								<table id="baby1" class="table table-striped table-bordered" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>#</th>
											<th>Product</th>
											<th>Type / Packaging</th>
											<th>SKU Code</th>
										</tr>
									</thead>
									<tbody>
									@foreach($products1 as $product)
										<tr>
											<td>{{ $loop->iteration }}.</td>
											<td><a href="">{{ $product->product_description }} </a></td>
											<td>{{ $product->type_description }}</td>
											<td>{{ $product->product_sku }}</td>
										</tr>
									 @endforeach
									</tbody>
								</table>
							</div>
							<div class="col-12" id="fempro" style="display:none">	
								<table id="fempro1" class="table table-striped table-bordered" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>#</th>
											<th>Product</th>
											<th>Type / Packaging</th>
											<th>SKU Code</th>
										</tr>
									</thead>
									<tbody>
									@foreach($products2 as $product)
										<tr>
											<td>{{ $loop->iteration }}.</td>
											<td><a href="">{{ $product->product_description }} </a></td>
											<td>{{ $product->type_description }}</td>
											<td>{{ $product->product_sku }}</td>
										</tr>
									 @endforeach
									</tbody>
								</table>
							</div>
							<div class="col-12" id="inco" style="display:none">
								<table id="inco1" class="table table-striped table-bordered" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>#</th>
											<th>Product</th>
											<th>Type / Packaging</th>
											<th>SKU Code</th>
										</tr>
									</thead>
									<tbody>
									@foreach($products3 as $product)
										<tr>
											<td>{{ $loop->iteration }}.</td>
											<td><a href="">{{ $product->product_description }} </a></td>
											<td>{{ $product->type_description }}</td>
											<td>{{ $product->product_sku }}</td>
										</tr>
									 @endforeach
									</tbody>
								</table>
							</div>
							<div class="col-12" id="tissue" style="display:none">
								<table id="tissue1" class="table table-striped table-bordered" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>#</th>
											<th>Product</th>
											<th>Type / Packaging</th>
											<th>SKU Code</th>
										</tr>
									</thead>
									<tbody>
									@foreach($products4 as $product)
										<tr>
											<td>{{ $loop->iteration }}.</td>
											<td><a href="">{{ $product->product_description }} </a></td>
											<td>{{ $product->type_description }}</td>
											<td>{{ $product->product_sku }}</td>
										</tr>
									 @endforeach
									</tbody>
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
				 
				@endsection
				
				@section('script')
				
				<script type="text/javascript">
				$(document).ready(function(){ 
					$('#category1').click(function(event) { //alert($(this).val());
						event.preventDefault();
						$(".category").css('opacity',0.5);
						$("#category1").css('opacity',1);
						$("#baby").show();
						$("#fempro").hide();
						$("#inco").hide();
						$("#tissue").hide();
						$("#all").hide();
					});
					
					$('#category2').click(function(event) { //alert($(this).val());
						event.preventDefault();
						$(".category").css('opacity',0.5);
						$("#category2").css('opacity',1);
						$("#baby").hide();
						$("#fempro").show();
						$("#inco").hide();
						$("#tissue").hide();
						$("#all").hide();
					});
					
					$('#category3').click(function(event) { //alert($(this).val());
						$(".category").css('opacity',0.5);
						$("#category3").css('opacity',1);
						$("#baby").hide();
						$("#fempro").hide();
						$("#inco").show();
						$("#tissue").hide();
						$("#all").hide();
					});
					
					$('#category4').click(function(event) { //alert($(this).val());
						event.preventDefault();
						$(".category").css('opacity',0.5);
						$("#category4").css('opacity',1);
						$("#baby").hide();
						$("#fempro").hide();
						$("#inco").hide();
						$("#tissue").show();
						$("#all").hide();
					});
				});	
				</script>
				
				@endsection
				