<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <title>@yield('title', env('APP_NAME'))</title>
</head>

<body>
    <header class="py-4">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo__wrapper">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('img/logo.svg') }}" alt="">
                    </a>
                </div>
                <div class="auth-buttons d-flex flex-column align-items-end">
                    @guest
                        <a href="{{ route('auth.registerPage') }}">Регистрация</a>
                        <a href="{{ route('auth.loginPage') }}">Вход</a>
                    @else
                        <a href="{{ route('auth.logout') }}">Выйти</a>
                    @endguest
                </div>
            </div>
        </div>
    </header>
    <main class="py-2">
        @yield('content')
    </main>

    <script src="{{ asset('js/jquery-3.6.3.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>
