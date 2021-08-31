@extends('layouts.app')

				@section('header')
				<div class="container-fluid">
					<div class="row mb-2">
					  <div class="col-sm-6">
						<h6 class="m-0">Welcome Back, <b>{{ Auth::user()->name }}</b> </h6>
					  </div><!-- /.col -->
					  <!--<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
						  <li class="breadcrumb-item"><a href="#">Home</a></li>
						  <li class="breadcrumb-item active">Dashboard v2</li>
						</ol>
					  </div>-->
					</div><!-- /.row -->
					
					<div class="row">
					  <div class="col-md-12">
						<div class="info-box">
						  <div class="info-box-content">
							<table style="text-align:center" width="100%">
								<tr>
									<td><input type="image" id="image" alt="visit"
       src="{{asset('images/icon/visit.png')}}" height="70px" onclick="location.href='{{ route('/search') }}'"></td>
									<!--<td><input type="image" id="image" alt="visit"
       src="{{asset('images/icon/order.png')}}" height="70px" onclick="location.href='{{ route('/search') }}'"></td>-->
									<td><input type="image" id="image" alt="visit"
       src="{{asset('images/icon/history.png')}}" height="70px" onclick="location.href='{{ route('orders.history') }}'"></td>
								</tr>
							</table>
						  </div>
						</div>
					  </div>
					</div>
					<hr>
					<h6 class="mb-0" style="text-align:center"><u>Summary of the Day - {{ date("l, d M y") }}</u></h6>
				</div><!-- /.container-fluid -->
				@endsection
				
				@section('content')
				<div class="container-fluid">
					<!-- Main row -->
					<div class="row">
					  <div class="col-6">
						<!-- Info Boxes Style 2 -->
						<div class="info-box mb-3 bg-primary">
						  <div class="info-box-content" style="text-align: center;">
							<span class="info-box-text">Total Visited Outlet</span>
							<span class="info-box-number" style="font-size: 25px;">{{$outlets->count()}}</font></span>
						  </div>
						  <!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					  </div>
					  <div class="col-6">
						<div class="info-box mb-3 bg-success">
						  <!--<span class="info-box-icon"><i class="far fa-heart"></i></span>-->

						  <div class="info-box-content" style="text-align: center;">
							<span class="info-box-text">Total Order</span>
							<span class="info-box-number"style="font-size: 25px;">{{$orders->count()}}</font></span>
						  </div>
						  <!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					  </div>
					</div>
				  
					<div class="row">
					  <div class="col-md-12" style="text-align: center;">
						<div class="card">
						  <div class="card-body">
							@if(count($order_lists) < 0)
								<img src="{{asset('images/icon/empty-list.png')}}" alt="empty" width="100px">
								<p>Oops, This listing is Empty <br>
								<small>Visit outlet to create order</small></p>
								<button type="button" class="btn btn-block btn-primary" onclick="location.href='{{ route('/search') }}'">Visit Outlet</button>
							@else
							
								<table id="dashboard" class="table table-bordered">
									<thead>
										<tr>
											<th rowspan="2">#</th>
											<th rowspan="2">Outlet</th>
											<th rowspan="2">Visited Time</th>
											<th colspan="2">Quantity Order</th>
											<th rowspan="2">Order Status</th>
										</tr>
										<tr>
											<th>Carton</th>
											<th>Pack</th>
		
										</tr>
									</thead>
									<tbody>
									@foreach($order_lists as $order)
										<tr>
											<td>
												{{ $loop->iteration }}.
											</td>
											<td>{{ $order->outlet_sname }}
												@if($order->order_status == null && $order->order_empty == '2' && $order->date == date("Y-m-d"))
													<a href="{{route('orders.edit',$order->id)}}"><br>View order</a>
												@elseif($order->date != date("Y-m-d") && $order->id != null || $order->order_status != null)
													<a href="{{route('orders.show',$order->id)}}"><br>View order</a>
												@endif
											</td>
											<td>
											{{ Carbon\Carbon::parse($order->created_at)->format('H:i:s A') }}
											</td>
											<td>
												@if($order->carton != null){{ $order->carton }} @else 0 @endif
											</td>
											<td>
												@if($order->packs != null){{ $order->packs }} @else 0 @endif
											</td>
											<td>
												@if($order->order_status == 1 && $order->order_empty == 2)Confirmed @elseif($order->order_status == null && $order->order_empty == 2) Pending @else No order @endif
											</td>
										</tr>
									 @endforeach
									</tbody>
								</table>
								
								@endif
							</div>
							
						  </div>
					    </div>
					   </div>
					  <!-- /.col -->
					</div>
					<!-- /.row -->
			     </div><!--/. container-fluid -->
			
				@endsection
				
				@section('script')
				<script src="{{ asset('js/indexeddb/outletDB.js') }}"></script>
				<script src="{{ asset('js/indexeddb/productDB.js') }}"></script>
				<script>
				$(document).ready(function() {
					//Preload data
					loadDB(); 
					insertDB(); 
				});
				</script>
				<script language="javascript">
				/*setInterval(function(){
				   window.location.reload(1);
				}, 5000);*/
				</script>
				@endsection
