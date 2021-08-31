@extends('layouts.app')

				@section('header')
				<div class="container-fluid">
					<div class="row mb-2">
					  <div class="col-sm-6">
						<h5 class="m-0">Outlet Master</h5>
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
					@if(Auth::user()->role == 1 || Auth::user()->role == 2)
					<div class="row">
					  <div class="col-md-12">
						<div class="card">
						  <div class="card-header">
							<h6 class="card-title">Generate QR Code</h6>
						  </div>
						  <div class="card-body">
							<div class="row">
							  <div class="col-12">
							  <form method="post" action="{{ route('qr.code.store') }}">
								@csrf
								<div class="form-group">
								  <label>Please enter number of code to generate</label>
								   <input type="text" class="form-control" id="code" name="code">
								</div>
								
								<button type="submit" class="btn btn-block btn-primary">Submit</button><br>
							  </form>
							  </div>
							</div>
							<!-- /.row -->
						  </div>
					    </div>
					   </div>
					  <!-- /.col -->
					</div>
					@endif
					
					<div class="row">
					  <div class="col-md-12">
						<div class="card">
						  <div class="card-header">
							<h6 class="card-title">Outlet Master List</h6>
						  </div>
						  <div class="card-body">
							<div class="row">
							  <div class="col-12">
								<table id="example2" class="table table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th>#</th>
												<th>Outlet</th>
												<th>QR Code</th>
											</tr>
										</thead>
										<tbody>
										<?php $host = $_SERVER['SERVER_NAME']; ?>
										@foreach($outlets as $outlet)
											<tr>
												<td>
													{{ $loop->iteration }}.
												</td>
												<td>
													ID: {{ str_pad($outlet->id, 11, '0', STR_PAD_LEFT) }} <br>
													@if($outlet != null && $outlet->outlet_sname == null)  Empty @else Name: <a href="{{route('outlets.show',$outlet->id)}}">{{ $outlet->outlet_sname }} </a> @endif
												</td>
												<td>
													<!--<img src ="{{ asset('qr_code/'.$outlet->id.'.png') }}" height="50px">
													<br><br>-->
													<a class="btn btn-sm btn-primary btn-icon" target= "_blank" href="{{ route('printCode', $outlet->id) }}">Print QR code</a>
												</td>
												<!--<td>
													<button class="btn btn-danger btn-icon btn-sm" data-target="#user_delete" data-toggle="modal" data-id="" data-user="">Delete</button>
												</td>-->
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