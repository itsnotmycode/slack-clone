<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @Auth()
        @php
            $user = ['name' => Auth::user()->name, 'email' => Auth::user()->email] ;
        @endphp
        <script>
            window.user = '{!! json_encode($user) !!}';
        </script>
    @endauth
</head>
<body>
<div id="app">
    @guest
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
            @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
            @endif
        </ul>
    </nav>
    @endguest

    @yield('content')

</div>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
