<!DOCTYPE html>
<html lang="es">
<head>
	<!--meta para caracteres especiales-->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>
	<!--Import Google Icon Font-->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<!--Import materialize.css-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.99.0/css/materialize.min.css">
	<!--estilo css personal-->
	<link type="text/css" rel="stylesheet" href="{{ asset('css/style.css') }}"  media="screen,projection"/>
</head>

<body>

<div class="row">
    <div class="center">
    	<h2>Bienvenido!</h2>
    
    	<h4>Esto es una prueba de envio de correo electrónico</h4>
    </div>
 
    <div>
        Hola, {{ $Nombre }}.<br><br>
        
        Un administrador te añadido como usuario para utilizar el sistema.<br><br>
        
        En este correo electrónico encontrara su nombre de usuario y contraseña para que pueda ingresar desde: {{ URL('/') }}<br><br>
        
        Usuario: {{ $Usuario }}<br>
        Contraseña: {{ $Password }}<br><br>
        
        Le recomendamos cambiar su contraseña. Click para cambiar contraseña<br><br>
        
        Cualquier problema relacionado al sistema favor de reportarlo al administrador del sistema.<br><br><br>
        
        Este mensaje fue generado automaticamente desde el sistema.<br>
        No responda a este correo.
    </div>
</div><!--/row section-->

	<!--Import jQuery before materialize.js-->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
	
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.99.0/js/materialize.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/InitiateComponents.js') }}"></script>
</body>
</html>