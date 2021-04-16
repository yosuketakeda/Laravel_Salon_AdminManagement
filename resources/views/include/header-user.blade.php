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
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
    <link href="{{asset('public/assets/css/main.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/css/jquery-ui.css')}}" rel="stylesheet">
</head>
<body>
    <?php 
        $user = auth()->user();    
    ?>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{route('user_question.index',['step'=>'question-section'])}}">
                    <img class="logo" src="{{asset('public/assets/images/logo.png')}}">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @if(!empty($user))
                            @if($user->permission == 2)
                                <li><a href="{{route('user.index', ['step'=>'list'])}}">利用者情報</a></li>                                
                            @endif
                            <li><a href="{{url('/logout')}}">ログアウト</a></li>
                        @endif
                    </ul>                   
                </div>            
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

