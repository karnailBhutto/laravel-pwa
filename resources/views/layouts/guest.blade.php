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
        <!-- Styles -->
		<!-- Font Awesome -->
		<link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
		<!-- icheck bootstrap -->
		<link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
		<!-- Theme style -->
		<link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
		
    </head>
	<body class="hold-transition login-page" style="background-image:linear-gradient(180deg,blue,blue,black);">
		<div class="login-box">
		  <div class="login-logo">
			<img src="{{asset('images/logo.png')}}" width="120px"alt="corporate-logo">
		  </div>
		  <!-- /.login-logo -->
		  @yield('content')
		</div>
		<!-- /.login-box -->

		<!-- jQuery -->
		<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
		<!-- Bootstrap 4 -->
		<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
		<!-- AdminLTE App -->
		<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
	</body>
</html>
