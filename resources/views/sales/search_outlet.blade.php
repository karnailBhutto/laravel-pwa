@extends('layouts.app')

<style>

#qr-canvas {
   <!--margin: auto;
  width: calc(100%);
 max-width: 400px*/;-->
  width: 100vh;
}

#btn-scan-qr {
  cursor: pointer;
}

#btn-scan-qr img {
  height: 10em;
  padding: 15px;
  margin: 15px;
  background: white;
}

#qr-result {
  font-size: 1.2em;
  margin: 20px auto;
  padding: 20px;
  max-width: 700px;
  background-color: white;
}

</style>

				@section('header')
				<div class="container-fluid">
					<div class="row mb-2">
					  <div class="col-sm-6">
						<h5 class="m-0">Visit Outlet</h5>
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
							<h6 class="card-title">Find outlet by enter outlet name or ID</h6>
						  </div>
						  <div class="card-body">
							<div class="row">
							  <div class="col-12">
							   <form method="post">
								
								<div class="form-group">
								  <label>Please enter outlet name or ID</label>
								  <select class="form-control select2" style="width: 100%;" id="myoutlet" name="outlet" required="required" onchange="myFunction()">
								    <option value=""></option>
									@foreach($outlets as $outlet)
									<option value="{{$outlet->id}}">{{ str_pad($outlet->id, 11, '0', STR_PAD_LEFT) }} @if($outlet != null && $outlet->outlet_sname == null) @else - {{ $outlet->outlet_sname }} @endif</option>
									@endforeach
								  </select>
								</div>
								<!--<button type="submit" class="btn btn-block btn-primary">Search</button><br>-->
								</form>
								
								<h3 style="text-align:center">---------- OR ----------</h3><br>
								<p><b>Please scan the QR code</b></p>
								<div class="form-group" style="text-align:center;">
								  <button type="button" class="btn btn-block btn-primary" id="btn-scan-qr" onclick="innerHTMLFn();">QR Code Scanner</button>
								  
								  <canvas hidden="" id="qr-canvas"></canvas>
								  <div id="qr-result" hidden="">
									<a href="" id="linkID"></a>
								  </div>
								</div><br>
							  </div>
							</div>
							<!-- /.row -->
						  </div>
					    </div>
					   </div>
					  <!-- /.col -->
					</div>
					<!-- /.row -->
			     </div><!--/. container-fluid -->
				 
				@endsection
				
				@section('script')
				
				 <script src="https://rawgit.com/sitepoint-editors/jsqrcode/master/src/qr_packed.js"></script>
				 <script src="{{ asset('js/qrCodeScanner.js') }}"></script>
				 
				 <script>
				 function myFunction() {
					// Get the checkbox
					var outlet = document.getElementById("myoutlet").value //alert('ada');					//alert(outlet);
					if(outlet) { 
						// $.ajax({
							// url: '/myoutlet/'+outlet,
							// type: "GET",
							// dataType: "json",
							// success:function(data) { 
								//console.log(data);
							// }
						// });
					 window.location = "https://sfa-staging.vindagroupsea.com/outlets?id="+outlet;
					// alert(outlet);	
					return false;
					}
				};	
				</script>
				 
				@endsection