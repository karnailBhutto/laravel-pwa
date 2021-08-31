<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Vinda SFA Cambodia') }}</title>
		<link rel="manifest" href="{{ asset('manifest.json') }}">
		
        <!-- Fonts -->
        <link rel="stylesheet" href="{{ asset('css/font.css') }}">
		
		<!-- Font Awesome Icons -->
		<link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
		<!-- overlayScrollbars -->
		<link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
		 <!-- Tempusdominus Bootstrap 4 -->
		<link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
		<!-- Select2 -->
		<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
		<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
		<!-- Bootstrap4 Duallistbox -->
		<link rel="stylesheet" href="{{ asset('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
		<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
		<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
		<link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
		<!-- Theme style -->
		<link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
		<script>
		if ('serviceWorker' in navigator) {
		  window.addEventListener('load', function() {
			navigator.serviceWorker.register('{{ asset("sw.js") }}').then(function(registration) {
			  // Registration was successful
			  console.log('ServiceWorker registration successful with scope: ', registration.scope);
			  //button.onclick = function() {
				registration.update();
			  //}
			}, function(err) {
			  // registration failed :(
			  console.log('ServiceWorker registration failed: ', err);
			});
			
			if (!navigator.onLine) {
			console.log("Navigator is offline. Loading database offline.");
				if (!window.indexedDB) {
					alert("IndexedDB is not supported!");
				}
				else { 
					//openIndexedDBDatabase(); 
				}
			} else {
				console.log("Navigator is online. Loading database via online.");
				//\DB::disconnect('mysql');
				//openPHPdatabase();
			}
		  });
		} 
		</script>

    </head>
	<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
		<div class="wrapper">
		  <!-- Navbar -->
		  @include('layouts.navbar1')
		  <!-- /.navbar -->

		  <!-- Main Sidebar Container -->
		  <aside class="main-sidebar sidebar-dark-primary elevation-4">
			<!-- Brand Logo -->
			<a href="/dashboard" class="brand-link">
			  <img src="{{ asset('images/logo.png') }}" width="150px" alt="Vinda Logo" class="brand-image">
			  <span class="brand-text font-weight-light">SFA for Cambodia</span>
			</a>

			<!-- Sidebar -->
			<div class="sidebar">

			  <!-- Sidebar Menu -->
			  @include('layouts.sidebar')
			  <!-- /.sidebar-menu -->
			  
			</div>
			<!-- /.sidebar -->
		  </aside>

		  <!-- Content Wrapper. Contains page content -->
		  <div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
			  @yield('header')
			</div>
			<!-- /.content-header -->

			<!-- Main content -->
			<section class="content">
			 @yield('content')
			</section>
			<!-- /.content -->
		  </div>
		  <!-- /.content-wrapper -->

		  <!-- Control Sidebar 
		  <aside class="control-sidebar control-sidebar-dark">
			<!-- Control sidebar content goes here 
		  </aside>-->
		  <!-- /.control-sidebar -->

		  <!-- Main Footer -->
		  @include('layouts.footer')

		</div>
		<!-- ./wrapper -->

		<!-- REQUIRED SCRIPTS -->
		 <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.0/dist/alpine.js"></script>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		
		<!-- jQuery -->
		<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<!-- Bootstrap -->
		<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
		<!-- overlayScrollbars -->
		<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
		<!-- AdminLTE App -->
		<script src="{{ asset('dist/js/adminlte.js') }}"></script>
		<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

		<!-- PAGE PLUGINS -->
		<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
		<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
		<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
		<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
		<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
		<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
		<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
		<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
		<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
		<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
		<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
		<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
		
		<script>
		  $(function () {
			//Initialize Select2 Elements
			$('.select2').select2()
		   })
		</script>
		
		<script>
		  $(function () {
			$("#example1").DataTable({
			  "responsive": true, "lengthChange": false, "autoWidth": false,"ordering": false,
			  "buttons": ["excel", "pdf", "print", "colvis"]
			}).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
			$('#dashboard').DataTable({
			  "paging": true,
			  "lengthChange": false,
			  "searching": true,
			  "ordering": false,
			  "info": true,
			  "autoWidth": false,
			  "responsive": true,
			});
			
			$('#example2').DataTable({
			  "paging": true,
			  "lengthChange": false,
			  "searching": true,
			  "ordering": false,
			  "info": true,
			  "autoWidth": false,
			  "responsive": true,
			});
			
			$('#baby1').DataTable({
			  "paging": true,
			  "lengthChange": false,
			  "searching": true,
			  "ordering": false,
			  "info": true,
			  "autoWidth": false,
			  "responsive": true,
			});
			
			$('#fempro1').DataTable({
			  "paging": true,
			  "lengthChange": false,
			  "searching": true,
			  "ordering": false,
			  "info": true,
			  "autoWidth": false,
			  "responsive": true,
			});
			
			$('#inco1').DataTable({
			  "paging": true,
			  "lengthChange": false,
			  "searching": true,
			  "ordering": false,
			  "info": true,
			  "autoWidth": false,
			  "responsive": true,
			});
			
			$('#tissue1').DataTable({
			  "paging": true,
			  "lengthChange": false,
			  "searching": true,
			  "ordering": false,
			  "info": true,
			  "autoWidth": false,
			  "responsive": true,
			});
		  });
		</script>
		
		@yield('script')
		
		
	</body>
</html>
