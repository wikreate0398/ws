@extends('layouts.app')

@section('content')
<div class="container no__home">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
             
            <h2 class="header_block">Вход</h2>

            <strong>{{ Session::get('flas_message') }}</strong>
			<div class="login_page">
				<form class="form-horizontal ajax__submit" method="POST" action="{{ route('run_login') }}">
					{{ csrf_field() }}

					<input type="hidden" name="redirectUri" value="{{ request('redirectUri') }}">

					<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
						<label for="email" class="col-md-12 control-label">E-Mail</label>

						<div class="col-md-12">
							<input id="email" type="email" class="form-control" name="email" value="" autofocus> 
						</div>
					</div>

					<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
						<label for="password" class="col-md-12 control-label">Пароль</label>

						<div class="col-md-12">
							<input id="password" type="password" class="form-control" name="password">

							@if ($errors->has('password'))
								<span class="help-block">
									<strong>{{ $errors->first('password') }}</strong>
								</span>
							@endif
						</div>
					</div>
					
					<input type="hidden" name="remember" value="1">
					<!-- <div class="form-group">
						<div class="col-md-6 col-md-offset-4">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
								</label>
							</div>
						</div>
					</div> -->

					<div class="form-group"> 
						<div class="col-md-12"> 
							<div id="error-respond"></div>
							<div class="btn_form">
								<button type="submit" class="btn btn-primary btn_login">
									Войти
								</button>
								<div class="clearfix"></div>
								@php $redirectUri =  request('redirectUri') ? '?redirectUri='.request('redirectUri') : '' @endphp
								<a class="btn btn-link" href="{{ route('registration') . $redirectUri }}">
									Регистрация
								</a>
								/
								<a class="btn btn-link" href="{{ route('forgot_password') }}">
									Я забыл пароль
								</a>
								<p>ЕСЛИ ВЫ УЖЕ ЗАРЕГИСТРИРОВАННЫ НА НАШЕМ ПОРТАЛЕ ВВЕДИТЕ СВОЙ АДРЕС ЭЛЕКТРОННОЙ ПОЧТЫ И ПАРОЛЬ.</p>
							</div>

						   <!--  <a class="btn btn-link" href="{{ route('forgot_password') }}">
								Forgot Your Password?
							</a> -->
						</div>
					</div>
				</form>
			</div>
    </div>
</div></div>
@endsection
