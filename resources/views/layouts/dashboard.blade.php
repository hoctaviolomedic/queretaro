<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>SIM - @yield('title')</title>
	{{ HTML::meta('viewport', 'width=device-width, initial-scale=1') }}
	{{ HTML::meta('csrf-token', csrf_token()) }}
	<!-- Bootstrap -->
	{{ HTML::style(asset('css/bootstrap.min.css')) }}
	{{ HTML::style(asset('css/style.css')) }}
	{{ HTML::style('https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css') }}
	{{ HTML::style('https://fonts.googleapis.com/css?family=Roboto') }}
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	{{ HTML::script('https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js') }}
	{{ HTML::script('https://oss.maxcdn.com/respond/1.4.2/respond.min.js') }}
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	@yield('header-top')
</head>
<body>
<div style="background-color: black; color: white; height: 50px; text-align: center;">Aquí va el menú</div>
<div class="container-fluid">
	@yield('content')
</div>
<!-- scripts -->
{{ HTML::script('https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js') }}
{{ HTML::script('https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js') }}
{{ HTML::script(asset('js/bootstrap.min.js')) }}
@yield('header-bottom')
</body>
</html>