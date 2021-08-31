@extends('layouts.app')

<style>
/* medium - display 2  */

@media (min-width:768px) {

  .carousel-inner .carousel-item-right.active,
  .carousel-inner .carousel-item-next {
      transform: translateX(50%);
  }
 
  .carousel-inner .carousel-item-left.active,
  .carousel-inner .carousel-item-prev {
      transform: translateX(-50%);
  }
}
 
/* large - display 3 */
@media (min-width:992px) {
  .carousel-inner .carousel-item-right.active,
  .carousel-inner .carousel-item-next {
      transform: translateX(33%);
  }
  .carousel-inner .carousel-item-left.active,
  .carousel-inner .carousel-item-prev {
      transform: translateX(-33%);
  }
}
 
@media (max-width:768px) {
  .carousel-inner .carousel-item>div {
      display:none;
  }
 
  .carousel-inner .carousel-item>div:first-child {
      display:block;
  }
}
 
.carousel-inner .carousel-item.active,
.carousel-inner .carousel-item-next,
.carousel-inner .carousel-item-prev {
  display: flex;
}
 
.carousel-inner .carousel-item-right,
.carousel-inner .carousel-item-left {
  transform: translateX(0);
}
</style>

				@section('header')
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
							<span class="info-box-text">Ordered Date : {{ $outlets->outlet_sname }}</span>
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
							  @if(count($orders) < 0)
								<table id="demo-dt-basic" class="table table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th rowspan="2">#</th>
												<th rowspan="2">Order ID</th>
												<th rowspan="2">Ordered Date</th>
												<th colspan="2">Quantity Order</th>
												<th rowspan="2">Order Status</th>
											</tr>
											<tr>
												<th rowspan="2">Carton</th>
												<th rowspan="2">Pack</th>
			
											</tr>
										</thead>
										<tbody>
										@foreach($orders as $order)
											<tr>
												<td>
													{{ $loop->iteration }}.
												</td>
												<td>
													O-{{ $order->idorders }}
												</td>
												<td>
													{{ $order->updated_at }} 
												</td>
												<td>
													{{ $order->idorders }} 
												</td>
												<td>
													<button class="btn btn-danger btn-icon btn-sm" data-target="#user_delete" data-toggle="modal" data-id="" data-user="">Delete</button>
												</td>
											</tr>
										 @endforeach
										</tbody>
									</table>
								@else
									<p style="text-align:center"><img src="{{ asset('images/icon/shopping_cart.png') }}" width="110px" alt="order_cart" class="brand-image"></p>
								
									<p style="text-align:center">Oops, This outlet order cart is Empty. <br><small>Add new product now</small></p>
			
									<div class="row">
									  <div class="col-6">
										<button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#complete">Add new</button>
									  </div>
									  <div class="col-6">
											<button type="button" class="btn btn-block btn-outline-primary" onclick="location.href='{{ route('orders.index', ['id' => $outlets->id]) }}'">Cancel</button>
									  </div>
									</div>
								@endif
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
								<div class="info-box">
								  <div class="info-box-content">
									<span class="info-box-text">Outlet ID : {{ str_pad($outlets->id, 11, '0', STR_PAD_LEFT) }}</span>
									<span class="info-box-text">Outlet Name : {{ $outlets->outlet_sname }}</span>
									<span class="info-box-text">Ordered Date : {{ $outlets->outlet_sname }}</span>
								  </div>
								</div>
								<div class="card">
								  <div class="card-body">
								    <h6>Category</h6>
									<div class="row mx-auto my-auto">
										<div id="myCarousel" class="carousel slide w-100" data-ride="carousel">
											<div class="carousel-inner w-100" role="listbox">
												<div class="carousel-item active">
													<div class="col-2">
														<img src="{{ asset('images/baby.png') }}" width="100px">
													</div>
												</div>
												<div class="carousel-item">
													<div class="col-2">
														<img class="" src="{{ asset('images/fempro.png') }}" width="100px">
													</div>
												</div>
												<div class="carousel-item">
													<div class="col-2">
														<img class="" src="{{ asset('images/inco.png') }}" width="100px">
													</div>
												</div>
												<div class="carousel-item">
													<div class="col-lg-4 col-md-6">
														<img class="" src="{{ asset('images/tissue.png') }}" width="100px">
													</div>
												</div>
											</div>
											<a class="carousel-control-prev bg-dark w-auto" href="#myCarousel" role="button" data-slide="prev">
												<span class="carousel-control-prev-icon" aria-hidden="true"></span>
												<span class="sr-only">Previous</span>
											</a>
											<a class="carousel-control-next bg-dark w-auto" href="#myCarousel" role="button" data-slide="next">
												<span class="carousel-control-next-icon" aria-hidden="true"></span>
												<span class="sr-only">Next</span>
											</a>
										</div>
									</div>
								  </div>
								</div>
							</div>
							
							<!--Modal footer-->
							<div class="modal-footer">
								<button data-dismiss="modal" class="btn btn-primary" type="button" onclick="location.href=''">Close</button>
							</div>
						</div>
					</div>
				</div>
				<!-- end of modal completed -->
				 
				@endsection
				
				@section('script')
				
				<script src="{{ asset('js/carousel.js') }}"></script>
				
				@endsection