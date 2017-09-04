@extends('layouts.dashboard')

@section('title', 'Crear')

@section('header-top')
@endsection

@section('header-bottom')
    <script src="{{ asset('solicitudes') }}"></script>
@endsection

@section('content')
    <div class="col s12 xl8 offset-xl2">
        <p class="left-align">
            <a href="{{ url()->previous() }}" class="waves-effect waves-light btn">Regresar</a> <br>
        </p>
        <div class="divider"></div>
    </div>
    <div class="col s12 xl8 offset-xl2">
        <h4>Nuevo Usuario</h4>
    </div>

    <div class="col s12 xl8 offset-xl2">
        <div class="row">
            <form action="{{ companyRoute("index", ['company'=> $company]) }}" method="post" class="col s12">
                {{ csrf_field() }}
                {{ method_field('POST') }}
                <div class="row">
                    <div class="input-field col s12">
                        <input type="text" name="nombre_corto" id="nombre_corto" class="validate">
                        <label for="Nombre Corto">Nombre Corto</label>
                        @if ($errors->has('nombre_corto'))
                            <span class="help-block">
							<strong>{{ $errors->first('nombre_corto') }}</strong>
						</span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6">
                        <input type="text" name="usuario" id="usuario" class="validate">
                        <label for="banco">usuario</label>
                        @if ($errors->has('usuario'))
                            <span class="help-block">
							<strong>{{ $errors->first('banco') }}</strong>
						</span>
                        @endif
                    </div>
                    <div class="input-field col s6">
                        <input type="password" name="password" id="password" class="validate">
                        <label for="password">Password</label>
                        @if ($errors->has('password'))
                            <span class="help-block">
							<strong>{{ $errors->first('password') }}</strong>
						</span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <p>
                            <input type="checkbox" id="activo" name="activo" />
                            <label for="activo">¿Inactivo?</label>
                        </p>
                        @if ($errors->has('activo'))
                            <span class="help-block">
							<strong>{{ $errors->first('activo') }}</strong>
						</span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <button class="waves-effect waves-light btn right">Guardar Usuario</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
