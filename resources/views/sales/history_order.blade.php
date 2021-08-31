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
					  <div class="col-12">
						<div class="info-box">

						  <div class="info-box-content">
						  <form class="needs-validation" action="{{ route('orders.history') }}" method="POST">
								@csrf
								@method('GET')
							Filter by:
							<div class="row">
								<div class="col-6"> 
									<label for="premise">Begin date:</label>
									<div class="input-group">
										<input type="text" class="form-control" id="datepicker1" name="start" value="@if(isset($start1)){{$start1}}@endif" autocomplete="off" required>
									</div>
								</div>
								<div class="col-6"> 
									<label for="premise">End date:</label> 
									<div class="input-group">
										<input type="text" class="form-control" id="datepicker2" name="ends" value="@if(isset($end1)){{$end1}}@endif" autocomplete="off" required>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-12">
									<div class="form-group">
									  <label>Order status</label>
									  <select class="form-control" name="status">
										<option value="0">-- Please choose --</option>
										<option value="1" @if(isset($location1) && $location1 == "1") selected @endif>Confirmed</option>
										<option value="2" @if(isset($location1) && $location1 == "2") selected @endif>Pending</option>
										<option value="3" @if(isset($location1) && $location1 == "3") selected @endif>No order</option>
									  </select>
									</div>
								</div>
							</div>
							<div class="row">
							  <div class="col-12">
								<button type="submit" class="btn btn-block btn-primary">Search</button>
							  </div>
							  <div class="col-6">
							  </div>
							</div>
							</form>
						  </div>
						  <!-- /.info-box-content -->
						</div>
						<!-- /.info-box -->
					  </div>
					</div>
					
					<!--<div class="row">
					  <div class="col-3">
						
					  </div>
					  <div class="col-3">
						
					  </div>
					  <div class="col-6">
						
					  </div>
					</div>
					
					<br>-->
					
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
												<th rowspan="2">Order Detail</th>
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
													@if($order->order_status == null && $order->order_empty == '2' && $order->date == date("Y-m-d"))
														<a href="{{route('orders.edit',$order->id)}}">O-{{ $order->id }}</a>
													@else
														<a href="{{route('orders.show',$order->id)}}">O-{{ $order->id }}</a>
													@endif<br>
													{{$order->outlet_sname}}
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
													@if($order->order_status == 1 && $order->order_empty == 2)Confirmed @elseif($order->order_status == null && $order->order_empty == 2) Pending @else No order @endif
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
				
				<script type="text/javascript">;
				$( function() {
					//var dateFormat = "mm/dd/yy",
						from = $( "#datepicker1" )
							.datepicker({
								//defaultDate: "+1w",
								changeMonth: true,
								numberOfMonths: 1,
								dateFormat: 'dd-mm-yy'
							})
							.on( "change", function() {
								to.datepicker( "option", "minDate", getDate( this ) );
							}),
						to = $( "#datepicker2" ).datepicker({
							//defaultDate: "+1w",
							changeMonth: true,
							numberOfMonths: 1,
							dateFormat: 'dd-mm-yy'
						})
						.on( "change", function() {
							from.datepicker( "option", "maxDate", getDate( this ) );
						});

					function getDate( element ) {
						var date;
						try {
							date = $.datepicker.parseDate( dateFormat, element.value );
						} catch( error ) {
							date = null;
						}

						return date;
					}
				} );
				</script>
				
				@endsection