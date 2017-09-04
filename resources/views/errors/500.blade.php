<?php 
$Url = URL('/');
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
        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <style type="text/css">
            .error-page {
                margin: 100px 0 40px;
                text-align: center;
            }
            
            .error-page-header-image {
                width: 112px;
            }
        </style>
    </head>
	<body class="grey lighten-2">
        <div class="error-page">
            <header>
            	<img class="error-page-header-image" src="https://static.tutsplus.com/assets/sad-computer-128aac0432b34e270a8d528fb9e3970b.gif" alt="Sad computer">
            </header>
            <p>Estamos teniendo problemas con el <b>servidor.</b><br>Ya despachamos a los mejores ingenieros para resolver el problema.</p>
            <a class="teal-text" href="{{ $Url }}">Clic aquí para volver</a>
        </div>
	</body>
</html>