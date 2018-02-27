<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <style>
        html, body {
            height: 100%;
            margin: 0;
            overflow: auto;
        }
        
        body {
            margin: 0 !important;
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
        }
        .links {
            padding: 30px;
            text-align: right;
        }

        .links a {
            padding-left: 15px;
            color: #333;
            font-weight: bold;
        }        
        .panel {
            background-color: rgba(255,255,255, .8) !important;
        }
        </style>
        

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body style="background-image: url('{{asset('img/background/2.jpeg')}}'); ">
        <div class="navigation__homepage">
            @if (Route::has('login'))
                <div class="links">
                    @auth
                        <a href="{{ url('/dashboard') }}">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

        </div>


        
        <div class="content">
            @yield('content')
        </div>
        
    </body>
</html>
