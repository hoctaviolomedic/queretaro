<?php 
$Url = url()->previous() != URL('/') ? url()->previous() : url()->previous().'/';
?>
  <!DOCTYPE html>
  <html>
    <head>
      <!--meta para caracteres especiales-->
      <meta charset="UTF-8">
      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <!--<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>-->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.99.0/css/materialize.min.css">
      <!--estilo css personal-->
      <link rel="stylesheet" type="text/css" href="{{ asset('css/404animation.css') }}">
      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <body>
      <div class="mars-box">
      <div class="space">
        <div class="ship">
          <div class="ship-rotate">
            <div class="pod"></div>
            <div class="fuselage"></div>
          </div>
        </div>
        <div class="ship-shadow"></div>
        <div class="mars">
          <div class="tentacle"></div>
          <div class="flag">
            <div class="small-tentacle"></div>
          </div>
          <div class="planet">
            <div class="surface"></div>
            <div class="crater1"></div>
            <div class="crater2"></div>
            <div class="crater3"></div>
          </div>
        </div>
        <div class="test">
          <h3 class="center white-text">Error 404</h3>
          <h6 class="center white-text">No pudimos encontrar la página. <a class="orange-text" href="{{ $Url }}">Clic aquí para volver</a><br></h6>
        </div>
      </div>
      </div>
      <!--Import jQuery before materialize.js-->
      <!--Script para hacer los datos ordenarse-->
    </body>
  </html>