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
      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <!--js necesarios-->
      <script type="text/javascript" src="{{ asset('js/animation2.js') }}"></script>
      <script type="text/javascript" src="{{ asset('js/animation1.js') }}"></script>
      <style type="text/css">
        body {
          background-color:#1E7FF4;
          overflow: hidden;
        }
        svg{
          width:100%;
          height:100%;
          visibility:hidden;
          margin:0 auto;
        }
        .animation-container{
          width: 40%;
          margin: 0 auto;
        }
        @media only screen and (max-width: 600px) {
        .animation-container{
          width: 100%;
          margin: 0 auto;
        }
        }
      </style>
    </head>
    <body>
    <div class="animation-container">
          <h3 class="center white-text">Error 403 Acceso denegado</h3>
          <h6 class="center white-text">No tienes permiso para ver el módulo. <b><a class="orange-text" href="{{ $Url }}">Clic aquí para volver</a></b><br></h6>
      <svg viewBox="0 0 800 600" xmlns="http://www.w3.org/2000/svg">
      <defs>
      </defs>
      <g id="wholeGroup">
      <g id="base">
          <path fill="#FFFFFF" stroke="#000000" stroke-width="8" stroke-miterlimit="10" d="M745.3,352.3l0,52.5c0,3.3-2.7,6-6,6h0
          c-3.3,0-6-2.7-6-6l0-52.5c0-3.3,2.7-6,6-6l0,0C742.6,346.2,745.3,349,745.3,352.3z"/>
        <path fill="#FFFFFF" stroke="#000000" stroke-width="8" stroke-linecap="round" stroke-miterlimit="10" d="M733.2,405.7
          c-5.9-0.3-11.8-0.6-17.7-0.8c-13.3-0.7-23.6-12.1-23.6-25.3c0,0,0,0,0,0c0-13.2,10.3-25.6,23.6-26.3c5.6-0.4,11.1-0.7,16.7-1.1"/>

          <circle fill="#1E7FF4" stroke="#000000" stroke-width="8" stroke-linecap="round" stroke-miterlimit="10" cx="714.2" cy="379.5" r="9.7"/>
      </g>
        <g id="headArc">
      <line id="neck" fill="none" stroke="#000000" stroke-width="8" stroke-linecap="round" stroke-miterlimit="10" x1="700" y1="276" x2="700" y2="360.7"/>
      <g id="headRot">
        <path fill="#FFFFFF" stroke="#000000" stroke-width="8" stroke-miterlimit="10" d="M712.1,288h-27.7c-4.3,0-7.9-3.6-7.9-7.9v-0.7
          c0-4.3,3.6-7.9,7.9-7.9h27.7c4.3,0,7.9,3.6,7.9,7.9v0.7C720,284.4,716.4,288,712.1,288z"/>

          <polygon fill="#FFFFFF" stroke="#000000" stroke-width="8" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="
          644.5,227 612.8,245.2 581,263.4 581,227 581,190.6 612.8,208.8   "/>
        <path fill="#FFFFFF" stroke="#000000" stroke-width="8" stroke-miterlimit="10" d="M750.5,271.5H621.4c-5,0-9-4-9-9v-72
          c0-4.9,4-9,9-9h129.1c5,0,9,4.1,9,9v72C759.5,267.5,755.5,271.5,750.5,271.5z"/>

          <circle fill="#1E7FF4" stroke="#000000" stroke-width="8" stroke-linecap="round" stroke-miterlimit="10" cx="640" cy="203.7" r="9.7"/>
      </g>
        </g>
          <circle id="ball" cx="300" cy="406" r="13"  fill="#FFF" stroke="none" stroke-width="4"/>

      <g id="popGroup" fill="none" stroke="rgba(255, 255, 255, 0.0)" stroke-width="3">
        <line x1="46" y1="46" x2="27.2" y2="0.6"/>
        <line x1="46" y1="46" x2="64.9" y2="0.6"/>
        <line x1="46" y1="46" x2="91.5" y2="27.2"/>
        <line x1="46" y1="46" x2="91.5" y2="64.9"/>
        <line x1="46" y1="46" x2="64.9" y2="91.5"/>
        <line x1="46" y1="46" x2="27.2" y2="91.5"/>
        <line x1="46" y1="46" x2="0.6" y2="64.9"/>
        <line x1="46" y1="46" x2="0.6" y2="27.2"/>
      </g>
        <line x1="100" y1="421" x2="600" y2="421" fill="none" stroke="#000" stroke-width="3"  stroke-miterlimit="10"/>
        </g>
      </svg>
      </div>
      <script type="text/javascript">
        var xmlns = "http://www.w3.org/2000/svg",
          xlinkns = "http://www.w3.org/1999/xlink",
          select = function(s) {
            return document.querySelector(s);
          },
          selectAll = function(s) {
            return document.querySelectorAll(s);
          },
            headArc = select('#headArc'),
            headRot = select('#headRot'),
            ball = select('#ball'),
            //ballContainer = select('#ballContainer'),
            neck = select('#neck'),
            popGroup= select('#popGroup'),
            popLines = selectAll('#popGroup line')


        TweenMax.set('#wholeGroup', {
          x:'-=50'
        })
        TweenMax.set('svg', {
          visibility: 'visible'
        })
        TweenMax.set(popGroup, {
          x:455,
          y:280
        })
        TweenMax.set(popLines, {
          drawSVG:'30% 30%'

        })

        var inspect = {headRot:-86, headArc:47},
            closeInspect = {headRot:-46, headArc:-23},
            start = {headRot:0, headArc:0},
            followInspect = {headRot:-20, headArc:-36},
            followInspectAgain = {headRot:-3, headArc:-46},
            lookUp = {headRot:20, headArc:20},
            checkUp = {headRot:0, headArc:0},
            slowlyLookDown = {headRot:-45, headArc:-55},
            withdraw = {headRot:-80, headArc:37},
            lookBehind = {headRot:-20, headArc:-37},
            withdrawTilt = {headRot:-75, headArc:49}

        TweenMax.set([ headArc], {
          svgOrigin:'698 360'
        })
        TweenMax.set([ headRot], {
          transformOrigin:'62% 99%'
        })

        var tl = new TimelineMax({repeat:-1, repeatDelay:1});
        tl.from(ball, 2, {
          attr:{
            cy:-1000,
            cx:150
          },
          ease:Bounce.easeOut
        })
        .to(ball, 4, {
          attr:{
            cx:500
          },
          ease:Sine.easeInOut
        },'-=2')


        /* .to('#grid', 4, {
          attr:{
            patternTransform:'rotate(150)'
          },
            ease:Sine.easeInOut

        },'-=4') */
        /*   .to([ headArc], 1, {
          rotation:18
        }) */

        //slowly look down
         .to([ headRot],2.3, {
          rotation:slowlyLookDown.headRot,
          delay:1,
          ease:Sine.easeOut
        })


         .to(headRot, 0.5, {
          rotation:slowlyLookDown.headArc,
          delay:1,
          ease:Sine.easeInOut
        })
         .to(headArc, 0.5, {
          rotation:5,
          ease:Sine.easeInOut

        },'-=0.3')
        //ball roll forward
        .to(ball, 0.3, {
          attr:{
            cx:510
          }
        },'-=0.5')

        //roll again
        .to(ball, 1, {
          attr:{
            cx:550
          },
          delay:1
        })


        //withdraw
         .to(headRot, 0.8, {
          rotation:withdraw.headRot
        },'-=0.8')
         .to(headArc, 0.8, {
          rotation:withdraw.headArc
        },'-=0.7')

        //inspect
        .to(headRot, 0.4, {
          rotation:inspect.headRot,
          delay:1
        })
         .to(headArc, 0.4, {
          rotation:inspect.headArc
        },'-=0.4')

        //look up
        .to(headRot, 0.4, {
          rotation:lookUp.headRot,
          delay:1,
          ease:Anticipate.easeOut
        })
         .to(headArc, 0.4, {
          rotation:lookUp.headArc,
          ease:Anticipate.easeOut
        },'-=0.4')

        //look forward
        .to(headRot, 0.3, {
          rotation:start.headRot+23,
          delay:1.3,
          ease:Power1.easeOut
        })
         .to(headArc,0.7, {
         // rotation:start.headArc,
          ease:Power1.easeInOut
        },'-=0.6')


        //withdraw
         .to(headRot, 0.6, {
          rotation:withdraw.headRot,
          delay:1.6,
          ease:Power3.easeOut
        })
         .to(headArc, 0.6, {
          rotation:withdraw.headArc,
          ease:Power3.easeOut
        },'-=0.6')

        //close inspect
        .to(headRot, 2, {
          rotation:closeInspect.headRot,
          delay:2
        })
         .to(headArc, 2, {
          rotation:closeInspect.headArc
        },'-=2')


        //ball back away
        .to(ball, 1, {
          attr:{
            cx:520
          },
          delay:2.2,
          ease:Sine.easeInOut
        })

        //follow inspect
        .to(headRot, 0.8, {
          rotation:followInspect.headRot,
          ease:Power3.easeInOut
        },'-=0.6')
         .to(headArc, 0.8, {
          rotation:followInspect.headArc,
          ease:Power3.easeInOut
        },'-=0.8')

        //ball back away again
        .to(ball, 1, {
          attr:{
            cx:500
          },
          delay:1.2,
          ease:Sine.easeInOut
        })

        //follow inspect
        .to(headRot, 0.8, {
          rotation:followInspectAgain.headRot,
            ease:Sine.easeInOut
        },'-=0.8')
         .to(headArc, 0.8, {
          rotation:followInspectAgain.headArc,
            ease:Sine.easeInOut

        },'-=0.8')

        //ball shake
        .to(ball, 0.015, {
          attr:{
            r:'-=5'
          },
          repeat:237,
          yoyo:true,
          delay:2,
          ease:Sine.easeInOut
        })

        //withdraw
        .to(headRot, 0.8, {
          rotation:withdraw.headRot,
          ease:Power3.easeInOut
        },'-=3.3')
         .to(headArc, 0.9, {
          rotation:withdraw.headArc,
          ease:Power3.easeInOut
        },'-=3.3')

        .to(ball, 0.3, {
          attr:{
            cy:320
          }
        },'-=0.3')
        .set(ball, {
          alpha:0
        })

        .to(headRot, 0.3, {
          rotation:withdrawTilt.headRot,
          ease:Anticipate.easeOut
        },'-=0.8')
         .to(headArc,0.3, {
          rotation:withdrawTilt.headArc,
          ease:Anticipate.easeOut
        },'-=0.3')

        .to(popLines, 0.2, {
          drawSVG:'70% 100%',
          ease:Linear.easeNone
        })
        .to(popLines, 0.2, {
          drawSVG:'100% 100%',
          ease:Expo.easeOut
        })

        .to(headRot, 0.3, {
          rotation:withdrawTilt.headRot+10,
          ease:Back.easeOut
        },'-=0.3')
         .to(headArc,0.5, {
          rotation:withdrawTilt.headArc+10,
          ease:Power3.easeOut
        },'-=0.3')

        .to(headRot, 0.3, {
          rotation:withdrawTilt.headRot,
          ease:Anticipate.easeInOut,
          delay:0.5
        })
         .to(headArc,0.3, {
          rotation:withdrawTilt.headArc,
          ease:Anticipate.easeInOut
        },'-=0.3')


        .to(headRot, 0.3, {
          rotation:lookBehind.headRot,
          ease:Power3.easeInOut,
          delay:0.5
        })
         .to(headArc,0.3, {
          rotation:lookBehind.headArc,
          ease:Power3.easeInOut
        },'-=0.3')

        .to(headRot, 0.3, {
          rotation:followInspectAgain.headRot,
          ease:Power3.easeInOut,
          delay:0.5
        })
         .to(headArc,0.3, {
          rotation:followInspectAgain.headArc,
          ease:Power3.easeInOut
        },'-=0.3')



        .to(headRot, 0.7, {
          rotation:lookUp.headRot,
          delay:1,
          ease:Power3.easeInOut
        })
         .to(headArc,0.6, {
          rotation:lookUp.headArc,
          ease:Power3.easeInOut
        },'-=0.8')



        .to(headRot, 0.6, {
          rotation:start.headRot,
          delay:2,
          ease:Power3.easeInOut
        })
         .to(headArc,0.6, {
          rotation:start.headArc,
          ease:Power2.easeInOut
        },'-=0.6')

        //ScrubGSAPTimeline(tl)
      </script>
    </body>
  </html>