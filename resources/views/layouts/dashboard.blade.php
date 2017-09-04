<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIM - @yield('title')</title>
    {{ HTML::meta('viewport', 'width=device-width, initial-scale=1') }}
    {{ HTML::meta('csrf-token', csrf_token()) }}
    {{ HTML::style('https://fonts.googleapis.com/icon?family=Material+Icons') }}
    {{ HTML::style('https://cdnjs.cloudflare.com/ajax/libs/materialize/0.99.0/css/materialize.min.css') }}
    {{ HTML::style(asset('css/style.css'), ['media'=>'screen,projection']) }}
    @yield('header-top')
</head>
<body>

@yield('content')

<!-- scripts -->
{{ HTML::script('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js') }}
{{ HTML::script('https://cdnjs.cloudflare.com/ajax/libs/materialize/0.99.0/js/materialize.min.js') }}
{{ HTML::script(asset('js/InitiateComponents.js')) }}
@yield('header-bottom')
</body>
</html>