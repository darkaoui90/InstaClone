<!doctype html>
@php
    $isAuthScreen = request()->routeIs('login') || request()->routeIs('register');
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Grand+Hotel&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="ig-app{{ $isAuthScreen ? ' ig-auth-screen' : '' }}">
    <div id="app">
        @unless($isAuthScreen)
            <nav class="navbar navbar-expand-md navbar-light ig-navbar">
                <div class="container ig-nav-wrap">
                    <a class="navbar-brand ig-brand" href="{{ auth()->check() ? route('dashboard') : url('/') }}">
                        InstaClone
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto ig-nav-list">
                            @auth
                                <li class="nav-item">
                                    <a class="nav-link ig-nav-link" href="{{ route('dashboard') }}">Feed</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link ig-nav-link" href="{{ route('posts.create') }}">Create</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link ig-nav-link" href="{{ route('profile.show', Auth::id()) }}">Profile</a>
                                </li>
                            @endauth
                        </ul>

                        <ul class="navbar-nav ms-auto ig-auth-list">
                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link ig-nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link ig-nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle ig-nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end ig-dropdown" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
        @endunless

        <main class="{{ $isAuthScreen ? 'ig-auth-main' : 'ig-main py-4' }}">
            @yield('content')
        </main>
    </div>
</body>
</html>
