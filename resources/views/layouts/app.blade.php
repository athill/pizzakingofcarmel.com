<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <header id="header">
           <div class=""> 
                Pizza King me!
           </div>
           <div class=""> 
                &nbsp;
           </div>
           <div class=""> 
                Pizza King of Carmel
           </div>
           <div class=""> 
                We deliver!
           </div>
           <div class=""> 
                &nbsp;
           </div>
           <div class=""> 
                Pizza King Me!
           </div>
        </header>
        <aside id="left-sidebar">sidebar</aside>
        <main id="main" class="py-4">
            @yield('content')
        </main>
        <footer id="footer"> © Pizza King of Carmel, {{ date('Y') }} | About Us | Contact Us</footer>
    </div>
</body>
</html>
