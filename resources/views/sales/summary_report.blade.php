@extends('layouts.app')

				@section('header')
				<div class="container-fluid">
					<div class="row mb-2">
					  <div class="col-sm-6">
						<h5 class="m-0">Summary Report</h5>
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
						  <form class="needs-validation" action="{{ route('orders.report') }}" method="POST">
								@csrf
								@method('GET')
							Filter by:
							<div class="row">
								<div class="col-6"> 
									<label for="premise">Begin date:</label>
									<div class="input-group">
										<input type="text" class="form-control" id="datepicker1" name="start" value="@if(isset($start1)){{$start1}}@endif" autocomplete="off">
									</div>
								</div>
								<div class="col-6"> 
									<label for="premise">End date:</label> 
									<div class="input-group">
										<input type="text" class="form-control" id="datepicker2" name="ends" value="@if(isset($end1)){{$end1}}@endif" autocomplete="off">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-6"> 
									<label for="premise">Region:</label>
									<div class="input-group">
									  <select class="form-control select2" style="width: 100%;" id="region" name="region" required="required">
										<option value="">-- Choose Region --</option>
										@foreach ($regions as $key => $value)
											<option value="{{ $value->region_code }}" @if(isset($region1) && $region1 == $key) selected @endif>{{ $value->region_name }}</option>
										@endforeach
									  </select>
									</div>
								</div>
								<div class="col-6"> 
									<label for="premise">Province:</label> 
									<div class="input-group">
										<select class="form-control select2" style="width: 100%;" id="province" name="province">
										<option value="0">-- Choose Province --</option>
									  </select>
									</div>
								</div>
							</div>
							<div class="row">
								<!--<div class="col-6"> 
									<label for="premise">Sales Rep:</label> 
									<div class="input-group">
										<select class="form-control select2" style="width: 100%;" id="sales" name="sales" required="required">
										<option>Choose Sales Rep</option>
										@foreach ($cities as $key => $value)
											<option value="{{ $key }}" @if(isset($sales1) && $sales1 == $key) selected @endif>{{ $value }}</option>
										@endforeach
									  </select>
									</div>
								</div>-->
								<div class="col-12"> 
									<div class="form-group">
									  <label>Order status</label>
									  <select class="form-control" name="status">
										<option value="">-- Please choose --</option>
										
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
							  
								<table id="summary" class="table table-bordered">
										<thead>
											<tr>
												<th rowspan="2">No.</th>
												<th rowspan="2">Region</th>
												<th rowspan="2">Province</th>
												<th rowspan="2">District</th>
												<th rowspan="2">Outlet name</th>
												<th rowspan="2">Outlet type</th>
												<th rowspan="2">Outlet Contact No.</th>
												<th rowspan="2">Sales Rep</th>
												<th rowspan="2">Date</th>
												<th colspan="2">Quantity</th>
												<th colspan="4">Product</th>
												<!--<th colspan="2">TENA</th>
												<th colspan="2">Vinda Deluxe</th>-->
												<th rowspan="2">Order Status</th>
											</tr>
											<tr>
												<th>Total (carton)</th>
												<th>Total (pack)</th>
												<th>Drypers (carton)</th>
												<th>Drypers (pack)</th>
												<th>Libresse (carton)</th>
												<th>Libresse (pack)</th>
											</tr>
										</thead>
										<tbody>
										@foreach($orders as $order)
											<tr>
												<td>
													{{ $loop->iteration }}.
												</td>
												<td>
													{{ $order->region_name }}
												</td>
												<td>
													{{ $order->province_name }}
												</td>
												<td>
													{{ $order->district_name }}
												</td>
												<td>
													<!--<a href="{{route('orders.show',$order->id)}}">O-{{ $order->id }}</a><br>-->
													{{$order->outlet_sname}}
												</td>
												<td>
													{{ $order->outlet_type }}
												</td>
												<td>
													{{$order->outlet_contact}}
												</td>
												<td>
													{{ $order->name }}
												</td>
												<td>
													{{ date('d M Y', strtotime($order->tarikh)) }} 
												</td>
												<td>
													@if($order->carton != null){{ $order->carton }} @else 0 @endif
												</td>
												<td>
													@if($order->packs != null){{ $order->packs }} @else 0 @endif
												</td>
												<td>
													@if($order->drypers_carton != null){{ $order->drypers_carton }} @else 0 @endif
												</td>
												<td>
													@if($order->drypers_pack != null){{ $order->drypers_pack }} @else 0 @endif
												</td>
												<td>
													@if($order->libresse_carton != null){{ $order->libresse_carton }} @else 0 @endif
												</td>
												<td>
													@if($order->libresse_pack != null){{ $order->libresse_pack }} @else 0 @endif
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
				
				<script type="text/javascript">
					$(document).ready(function() {
						$('select[name="region"]').on('change', function() {
							
							var stateID = $(this).val();
							if(stateID) {
								$.ajax({
									url: '/myform/ajax/'+stateID,
									type: "GET",
									dataType: "json",
									success:function(data) {

										
										$('select[name="province"]').empty();
										$('select[name="sales"]').empty();
										$('select[name="province"]').append('<option>Choose Province</option>');

										$.each(data, function(key, value) {
											$('select[name="province"]').append('<option value="'+ key +'">'+ value +'</option>');
										});


									}
								});
							}else{
								$('select[name="province"]').empty();
								$('select[name="sales"]').empty();
							}
						});
					});
					
					// $(document).ready(function() {
						// $('select[name="province"]').on('change', function() {
							
							// var stateID = $(this).val();
							// if(stateID) {
								// $.ajax({
									// url: '/myform/sales/'+stateID,
									// type: "GET",
									// dataType: "json",
									// success:function(data) {

										
										// $('select[name="sales"]').empty();
										// $('select[name="sales"]').append('<option>Choose Sales Rep</option>');

										// $.each(data, function(key, value) {
											// $('select[name="sales"]').append('<option value="'+ key +'">'+ value +'</option>');
										// });


									// }
								// });
							// }else{
								// $('select[name="sales"]').empty();
							// }
						// });
					// });
				</script>
				
				
				<script type="text/javascript">
				  $(function () {
					$("#summary").DataTable({
					  "responsive": true, "lengthChange": false, "autoWidth": false,"ordering": false,
					   "columnDefs": [
								   { targets: [11,12,13,14], visible: false }
								],
					 // "buttons": ["excel", "pdf", "print", "colvis"]
						buttons: [
							{
								extend: 'excel',
								title: 'Summary Order for Cambodia',
								filename: 'Summary_Report',
								autoFilter: true,
								footer: true
							},
							{
								extend: 'pdf',
								title: 'Summary Order for Cambodia',
								filename: 'Summary_Report',
								footer: true,
								orientation: 'landscape',
								customize: function (doc) {
									//doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
									doc.content[1].table.widths = [ '2%',  '10%', '10%', '10%', '10%', '10%', '10%','10%', '5%', '5%', '10%'];
									doc.styles.title.fontSize = 10;    
									doc.styles.title.alignment = 'justify';
									// var rowCount = doc.content[1].table.body.length;
										// for (i = 1; i < rowCount; i++) {
										// doc.content[1].table.body[i][2].alignment = 'center';
										// doc.content[1].table.body[i][3].alignment = 'center';
										// }  							
								},
							},"colvis"
						]
					}).buttons().container().appendTo('#summary_wrapper .col-md-6:eq(0)');
				  });
				  
				</script>
		
				
				<script type="text/javascript">
				$(function() {
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
