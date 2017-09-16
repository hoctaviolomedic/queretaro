<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>{{config('app.name')}} - @yield('title')</title>
	{{ HTML::meta('viewport', 'width=device-width, initial-scale=1') }}
	{{ HTML::meta('csrf-token', csrf_token()) }}
	<!-- Bootstrap -->
	{{ HTML::style(asset('css/bootstrap.min.css')) }}
	{{ HTML::style(asset('css/style.css')) }}
	{{ HTML::style(asset('css/export.css')) }}
	{{ HTML::style(asset('css/bootstrap-multiselect.css')) }}
	{{ HTML::style(asset('css/select2.min.css')) }}
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	{{ HTML::script('https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js') }}
	{{ HTML::script('https://oss.maxcdn.com/respond/1.4.2/respond.min.js') }}

	<link href="css/style.css" rel="stylesheet">
	<![endif]-->
	@yield('header-top')

</head>
<body>
<div style=" height: 50px; text-align: center;"></div>
<div class="container-fluid">
	@yield('content')
</div>
<!-- scripts -->
{{ HTML::script(asset('js/jquery.min.js')) }}
{{ HTML::script(asset('js/bootstrap.min.js')) }}
{{ HTML::script(asset('js/bootstrap-multiselect.js')) }}
{{ HTML::script(asset('js/select2.min.js')) }}
{{ HTML::script(asset('js/bootstrap-datetimepicker.min.js')) }}
{{ HTML::script(asset('js/toaster.js')) }}

@yield('header-bottom')

</body>
</html>