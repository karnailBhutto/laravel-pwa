@extends('layouts.off')

				@section('header')
				<div class="container-fluid">
					<div class="row mb-2">
					  <div class="col-sm-6">
						<h5 class="m-0"></h5>
					  </div><!-- /.col -->
					  <!--<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
						  <li class="breadcrumb-item"><a href="#">Home</a></li>
						  <li class="breadcrumb-item active">Dashboard v2</li>
						</ol>
					  </div>--><br>
					</div><!-- /.row -->
				</div><!-- /.container-fluid -->
				@endsection
				
				@section('content')
				<div class="container-fluid">
					<!-- Info boxes -->
					<div class="row">
					  <div class="col-md-12" style="text-align:center;">
						<h4><i class="fas fa-exclamation-triangle text-warning"></i> Oops! You're offline.</h4><br>
						<p>This page cannot be access without internet connection.</p>
					  </div>
					  <!-- /.col -->
					
					</div>
					<!-- /.row -->
			     </div><!--/. container-fluid -->
			
				@endsection