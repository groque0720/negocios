<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <meta id="token" name="csrf-token" content="{{ csrf_token() }}">

{{-- <meta property="og:locale" content="es_ES" />
<meta property="og:type" content="website" />
<meta property="og:title" content="Neveras inteligentes para hostelería" />
<meta property="og:description" content="Las bebidas más frías del mundo" />
<meta property="og:url" content="https://vidriera.online/" />
<meta property="og:site_name" content="Wondercool | Neveras inteligentes" /> --}}
<!-- Para facebook, SMS -->
{{-- <meta property="og:image" content="https://wondercool.eu/wp-content/uploads/2019/01/logo-wondercool-redes-sociales-3-lineas-original-1200x630.png" />
<meta property="og:image:secure_url" content="https://wondercool.eu/wp-content/uploads/2019/01/logo-wondercool-redes-sociales-3-lineas-original-1200x630.png" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="630" />
<meta property="og:image:alt" content="Neveras para hostelería, Wondercool" /> --}}
<!-- Para twitter -->
{{-- <meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:description" content="Las bebidas más frías del mundo" />
<meta name="twitter:title" content="Neveras inteligentes para hostelería" />
<meta name="twitter:image" content="https://wondercool.eu/wp-content/uploads/2019/01/logo-wondercool-redes-sociales-3-lineas-original-1024x512.png" /> --}}
<!-- Para whatsapp -->




<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes, minimum-scale=0.5, maximum-scale=2.0"/>
<meta property="keywords" content=""/>
<meta name="description" content="Dos grupos de neurofisiólogos y biólogos moleculares europeos coinciden en asegurar que el Sars-CoV-2 podría haber abierto otro cerrojo humano para replicarse en numerosos tejidos del cuerpo, incluidos el cerebro"/>
<meta name="robots" content="index, follow"/>
<meta name="distribution" content="global"/>
<meta name="rating" content="general"/>
<meta name="language" content="es_ES"/>
<meta name="news_keywords" content=""/>
{{-- <meta name="twitter:title" content="¿Cual es la nueva ruta que encontró el coronavirus para infectarnos?"/>
<meta name="twitter:site" content="@infobae"/>
<meta name="twitter:card" content="summary_large_image"/>
<meta name="twitter:creator" content="@infobae"/>
<meta name="twitter:image" content="https://www.infobae.com/new-resizer/W2OesLuPvhrh5FKFFgy_7-PrrhM=/1024x512/filters:format(jpg):quality(85)//cloudfront-us-east-1.images.arcpublishing.com/infobae/XS44YIFHG2SDDZPRGVVKX2EBFE.jpg"/> --}}
<meta property="og:title" content="¿Cual es la nueva ruta que encontró el coronavirus para infectarnos?"/>
<meta property="og:description" content="Dos grupos de neurofisiólogos y biólogos moleculares europeos coinciden en asegurar que el Sars-CoV-2 podría haber abierto otro cerrojo humano para replicarse en numerosos tejidos del cuerpo, incluidos el cerebro"/>
<meta property="og:url" content="https://vidriera.online/"/>
<meta property="og:type" content="article"/>
<meta property="og:site_name" content="infobae"/>
<meta property="og:locale" content="es_LA"/>
<meta itemProp="image" property="og:image" content="https://vidriera.online/images/pp.jpg"/>
<meta name="isDFP" content="true"/>
<meta name="dfpPageType" content="nota"/>
<meta name="dfp_path" content="america"/>
<meta property="article:publisher" content="https://www.facebook.com/infobae"/>

<meta property="og:image" content="https://wondercool.eu/wp-content/uploads/2019/01/logo-wondercool-redes-sociales-3-lineas-original-1200x630.png" />
<meta property="og:image:secure_url" content="https://wondercool.eu/wp-content/uploads/2019/01/logo-wondercool-redes-sociales-3-lineas-original-1200x630.png" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="630" />
<meta property="og:image:alt" content="Neveras para hostelería, Wondercool" />



















{{-- <meta property="og:site_name" content="San Roque 2014 Pollos">
<meta property="og:title" content="San Roque 2014 Pollos" />
<meta property="og:description" content="Programa de fiestas" />
<meta property="og:image" itemprop="image" content="https://vidriera.online/images/pp.jpg">
<meta property="og:type" content="website" />
<meta property="og:updated_time" content="1440432930" /> --}}

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            .svg-content {
              position: absolute;
              top:50%;
              left: 50%;
              transform: translate(-50%, -50%);
            }

            .title {
              text-align: center;
              color: white;
            }
        </style>
    </head>
    <body>
        <div id="app">
           <div class="flex-center position-ref full-height">
                @if (Route::has('acceder'))
                    <div class="top-right links">
                        @auth
                            <a href="{{ url('/home') }}">Home</a>
                        @else
                            <a href="{{ route('acceder') }}">Login</a>
                            <a href="{{ route('register') }}">Register</a>
                        @endauth
                    </div>
                @endif

                <div class="content">
                    <div class="svg-content">

  <svg xmlns="http://www.w3.org/2000/svg" width="920" height="200" viewBox="0 0 901 70">
  <path id="my-svg-path" fill="#FFF" fill-rule="evenodd" d="M418.688996,49.396862 C418.227515,50.1686691 417.005154,52.4239496 415.969637,54.4085965 C412.149477,61.737757 406.683746,68.0124485 403.673992,68.5266525 C399.261787,69.2814197 392.954134,60.9368818 382.702511,40.7766787 C362.102466,0.263821994 354.354093,-2.19493493 335.948895,25.9419447 C314.311081,59.0153828 309.178516,61.2746727 293.127995,44.7860663 C271.546459,22.6131507 264.441908,20.5743771 243.121503,30.4284494 C227.043968,37.8588469 217.251574,39.1799401 197.648778,36.5608077 L190.445178,35.5985547 L95.2225888,35.4692519 C10.9404676,35.353982 0,35.4091111 0,35.9423597 C0,36.4746059 11.0890419,36.5598053 94.3221388,36.6650518 L188.644278,36.7853334 L198.099003,37.9179854 C219.302349,40.4579324 229.119506,39.0596585 245.280332,31.1982518 C263.210543,22.4768315 269.48668,24.0966241 287.299832,42.0406382 C308.48517,63.3836105 315.501926,61.7217194 335.784563,30.5527404 C347.100968,13.1660312 352.179507,7.92876869 356.931631,8.74066967 C361.827828,9.57762933 369.065195,19.5419598 378.682002,38.6867854 C398.469391,78.0760113 407.039424,79.6897898 422.792796,46.9912295 C423.589695,45.3373571 424.375337,43.7135551 424.537418,43.3827806 C424.699499,43.0520062 426.475637,39.1729237 428.485892,34.7625974 C448.264276,-8.66408178 451.980884,-9.00087034 470.516647,30.9536792 C486.261016,64.8901379 490.508889,70.683703 498.93485,69.7134312 C504.846304,69.0328376 509.918089,62.3481862 520.899076,40.7766787 C531.384817,20.1744407 537.609178,11.2024336 542.845294,9.13659669 C547.820281,7.17500382 553.486362,12.6057193 564.564149,29.9513323 C584.286255,60.8356447 592.682951,63.2553101 611.86929,43.58325 C619.703205,35.550442 625.767736,30.6479634 630.765234,28.306481 C638.80175,24.5406637 641.678688,24.8934899 655.948569,31.3957141 C673.446564,39.370386 681.035107,40.4258573 702.801235,37.9129736 L712.706185,36.7692958 L806.578098,36.657033 C889.30019,36.558803 900.450012,36.4736035 900.450012,35.9443643 C900.450012,35.4131205 889.437509,35.3569891 805.677648,35.4672472 L710.905285,35.5915382 L703.25146,36.5648171 C683.376277,39.0927359 675.112397,38.0232318 658.449569,30.7662403 C647.144419,25.8427124 643.265731,24.5837647 639.319509,24.5567013 C631.97859,24.506584 622.15468,30.0505646 613.181696,39.3052335 C591.705963,61.4591045 587.930826,60.7434288 568.093913,30.7532098 C545.726734,-3.06296734 539.383064,-1.657677 517.382819,41.979495 C508.015888,60.5630064 502.01664,68.6419224 497.588677,68.6419224 C494.130949,68.6419224 487.872821,61.0832244 482.652462,50.5996783 C480.662468,46.6043236 472.646211,29.5513959 470.496387,24.7391284 C461.79804,5.27756115 454.166726,-2.51167655 446.949619,0.701847587 C441.513152,3.12251533 433.987641,14.9652439 426.455377,32.958373 C425.269034,35.796017 419.416109,48.1820176 418.688996,49.396862 Z"/>

    <circle id="sparrow" r="10px" fill="#e75936" stroke="#FFF" stroke-width="2">
        <animateMotion dur="20s" repeatCount="indefinite">
            <mpath xlink:href="#my-svg-path" />
        </animateMotion>
</svg>

</div>
                    <div class="title m-b-md">
                        Laravel
                        <example-component></example-component>
                    </div>

                    <div class="links">
                        <a href="https://laravel.com/docs">Documentation</a>
                        <a href="https://laracasts.com">Laracasts</a>
                        <a href="https://laravel-news.com">News</a>
                        <a href="https://forge.laravel.com">Forge</a>
                        <a href="https://github.com/laravel/laravel">GitHub</a>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
