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
                @if(!empty($user))
                <a class="navbar-brand" href="{{url('/admin-dashboard') }}">
                    <img class="logo" src="{{asset('public/assets/images/logo.png')}}">
                </a>
                @endif

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @if(!empty($user) && ($user->permission == 1))
                        <li><a href="{{url('/admin-query-overall')}}">質問全体図</a></li>
                        @endif
                        <li><a href="{{route('admin_account_list.index', ['step'=>'list'])}}">利用者情報</a></li>
                        @if(!empty($user) && ($user->permission == 1))
                        <li><a href="{{route('admin_info.index', ['step'=>'top'])}}">管理者情報</a></li>
                        @endif
                        <li><a href="{{url('/logout')}}">ログアウト</a></li>
                    </ul>                   
                </div>            
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

