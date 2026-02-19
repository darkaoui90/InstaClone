@extends('layouts.app')

@section('content')
<div class="container-fluid ig-auth-wrap">
    <div class="ig-auth-grid">
        <section class="ig-auth-showcase">
            <div class="ig-auth-logo-dot"></div>
            <h2>See the moments your people share every day.</h2>
            <p>Post photos, react with likes, and join conversations in one clean feed.</p>

            <div class="ig-auth-collage" aria-hidden="true">
                <div class="ig-auth-tile ig-auth-tile-a"></div>
                <div class="ig-auth-tile ig-auth-tile-b"></div>
                <div class="ig-auth-tile ig-auth-tile-c"></div>
            </div>
        </section>

        <section class="ig-auth-panel">
            <div class="ig-auth-card">
                <p class="ig-auth-kicker">Welcome back</p>
                <h1>Sign in to InstaClone</h1>

                <form method="POST" action="{{ route('login') }}" class="ig-auth-form">
                    @csrf

                    <div class="ig-auth-field">
                        <label for="email" class="ig-label">Email address</label>
                        <input id="email" type="email" class="form-control ig-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="ig-auth-field">
                        <label for="password" class="ig-label">Password</label>
                        <input id="password" type="password" class="form-control ig-input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="ig-auth-meta">
                        <label class="ig-auth-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span>Remember me</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="ig-auth-link">Forgot password?</a>
                        @endif
                    </div>

                    <button type="submit" class="btn ig-auth-submit">Sign in</button>
                </form>

                <div class="ig-auth-divider"><span>or</span></div>

                <p class="ig-auth-switch">
                    No account yet?
                    <a href="{{ route('register') }}">Create one</a>
                </p>
            </div>
        </section>
    </div>
</div>
@endsection
