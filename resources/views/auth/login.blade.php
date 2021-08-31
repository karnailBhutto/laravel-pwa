@extends('layouts.guest')

  @section('content')
  <div class="card">
    <div class="card-body login-card-body"><br>
		<p class="login-box-msg"><font size="5px"><b>Vinda SFA for Cambodia </b></font><br> Sign in to start your session</p><br>

      <form method="post" action="{{ route('login') }}">
	   @csrf
	   
        <div class="input-group mb-3">
          <input type="text" class="form-control @error('username') is-invalid @enderror" placeholder="{{ __('Username') }}"  name="username" onclick="return false;" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
		  
		  @error('username')
			<span class="invalid-feedback" role="alert">
				<strong>{{ $message }}</strong>
			</span>
		  @enderror				
        </div>
		
        <div class="input-group mb-3">
          <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('Password') }}" onclick="return false;" name="password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
		  
		  @error('password')
			<span class="invalid-feedback" role="alert">
				<strong>{{ $message }}</strong>
			</span>
		   @enderror
        </div>
		
        <div class="row">
          <div class="col-12">
            <div class="icheck-primary">
              <input type="checkbox" id="remember" name="remember" id="remember" checked="checked">
              <label for="remember">
                {{ __('Keep me logged in') }}
              </label>
            </div>
          </div>
        </div>
		<hr>
		<div class="social-auth-links text-center mb-3">
			<button type="submit" class="btn btn-primary btn-block">{{ __('Login') }}</button>
        </div>
		
		<br>
      </form>

      <!--
	   @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
								<p class="mb-1">
        <a href="forgot-password.html"> {{ __('Forgot your password?') }}</a>
      </p>
      <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p>-->
    </div>
    <!-- /.login-card-body -->
  </div>
  @endsection

