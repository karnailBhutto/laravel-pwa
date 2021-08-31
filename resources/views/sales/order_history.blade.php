@extends('layouts.app')

				@section('header')
				<div class="container-fluid">
					<div class="row mb-2">
					  <div class="col-sm-6">
						<h5 class="m-0">Order History</h5>
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
					  <div class="col-6">
						<button type="button" class="btn btn-block btn-primary" id="create">Create New order</button>
					  </div>
					</div>
					
					<br>
					
					<div class="row">
					  <div class="col-md-12">
						<div class="card">
						  <div class="card-body">
							<div class="row">
							  <div class="col-12">
							  
								<table id="example1" class="table table-bordered " cellspacing="0" width="100%">
										<thead>
											<tr>
												<th rowspan="2">#</th>
												<th rowspan="2">Order ID</th>
												<th rowspan="2">Date / Time</th>
												<th colspan="2">Quantity Order</th>
												<th rowspan="2">Order Status</th>
											</tr>
											<tr>
												<th>Carton</th>
												<th>Pack</th>
			
											</tr>
										</thead>
										<tbody>
										@foreach($orders as $order)
											<tr>
												<td>
													{{ $loop->iteration }}.
												</td>
												<td>
													@if($order->order_status == null && $order->order_empty != null && $order->date == date("Y-m-d"))
														<a href="{{route('orders.edit',$order->id)}}">O-{{ $order->id }}</a>
													@else
														<a href="{{route('orders.show',$order->id)}}">O-{{ $order->id }}</a>
													@endif
												</td>
												<td>
													{{ date('d-m-Y H:i:s A', strtotime($order->updated_at)) }} 
												</td>
												<td>
													@if($order->carton != null){{ $order->carton }} @else 0 @endif
												</td>
												<td>
													@if($order->packs != null){{ $order->packs }} @else 0 @endif
												</td>
												<td>
													@if($order->order_status == 1 && $order->order_empty == 2)Confirmed @elseif($order->order_status == null && $order->order_empty == 2) Pending @elseif($order->order_status == null && $order->order_empty == 1) No order @endif
												</td>
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
				
				<script src="{{ asset('js/indexeddb/order_historyDB.js') }}"></script>
				
				<script>
				$(document).ready(function() {
					if (!navigator.onLine) { loadData(); }
				});
				</script>
				
				<script>
				if (navigator.onLine) {
					$('#create').on("click", function(e){  
						e.preventDefault();  
						window.location = "{{ route('orders.addnew',['id' => $outlets->id]) }}";
					}); 
				}
				</script>
				 
				 @endsection