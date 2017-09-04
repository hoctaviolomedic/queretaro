@extends('layouts.app')

@section('content')
<div class="valign-wrapper">
	<div class="col s12 center-block section center-align">
	<h4>¡Bienvenido!</h4>
		<div class="card-panel hoverable row">
			<form class="section" method="POST" action="{{ route('login') }}">
				{{ csrf_field() }}
				<object id="front-page-logo" class="Sim" type="image/svg+xml" data="img/sim2.svg" name="SIM">Your browser does not support SVG</object>
				<div class="row">
					<div class="input-field col s12">
						<i class="material-icons prefix">account_circle</i>
						<input id="user" type="text" class="validate" name="usuario" value="{{ old('usuario') }}" autofocus>
						<label for="user">Usuario:</label>
						@if ($errors->has('usuario'))
							<span class="help-block left red-text text-darken4">
								<strong>{{ $errors->first('usuario') }}</strong>
							</span>
						@endif
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12">
						<i class="material-icons prefix">vpn_key</i>
						<input id="password" type="password" class="validate" name="password">
						<label for="password">Contraseña:</label>
						@if ($errors->has('password'))
							<span class="help-block left red-text text-darken4">
								<strong>{{ $errors->first('password') }}</strong>
							</span>
						@endif
						<a class='teal-text right' href="{{ route('password.request') }}"><b>¿Olvidaste contraseña?</b></a>
					</div>
				</div>
				<div class="row">
						<div class="input-field col s12">
						</div>
					<div class="col s12">
						<button class="btn orange waves-effect waves-light" type="submit" name="enter">Entrar</button>
					</div>
				</div>
			</form><!--/section-->
		</div><!--/card-panel hoverable row-->
	</div><!--/col s12 center-block-->
</div><!--/valign-wrapper aquí termina el login-->

<!-- Modal para contraseña -->
<div id="forgotPass" class="modal">
	<div class="modal-content">
		<h4>Ingresa tu correo:</h4>
		<p>Te enviaremos al correo las instrucciones</p>
			<div class="row">
				<div class="input-field col s12">
					<i class="material-icons prefix">mail</i>
					<input id="email" type="email" class="validate">
					<label for="email">Correo:</label>
				</div>
			</div>
	</div>
	<div class="modal-footer">
		<button class="modal-action modal-close waves-effect waves-teal btn-flat teal-text">Cancelar</button>
		<button class="modal-action waves-effect waves-light btn blue darken-4" type="submit" name="send">Enviar</button>
	</div>
</div>
@endsection


