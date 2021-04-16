<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Salon</title>

    <!-- Scripts -->
    <script src="{{ asset('public/js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{asset('public/css/app.css') }}" rel="stylesheet">
    <link href="{{asset('public/assets/css/main.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/css/jquery-ui.css')}}" rel="stylesheet">
</head>
<body>
    <div class="menu">
        <div class="container">
            <a href="{{url('/')}}"><img class="logo" src="{{asset('public/assets/images/logo.png')}}"></a>
            <span class="txt">MORE COSMETICS SOLUTION SYSTEM</span>
        </div>        
    </div>

