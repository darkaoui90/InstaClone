@extends('layouts.app')

@section('content')
<div class="container-fluid ig-auth-wrap">
    <div class="ig-auth-grid">
        <section class="ig-auth-showcase">
            <div class="ig-auth-logo-dot"></div>
            <h2>Create your profile and start sharing instantly.</h2>
            <p>Join your circle, upload posts, and interact through likes and comments.</p>

            <div class="ig-auth-collage" aria-hidden="true">
                <div class="ig-auth-tile ig-auth-tile-a"></div>
                <div class="ig-auth-tile ig-auth-tile-b"></div>
                <div class="ig-auth-tile ig-auth-tile-c"></div>
            </div>
        </section>

        <section class="ig-auth-panel">
            <div class="ig-auth-card">
                <p class="ig-auth-kicker">Get started</p>
                <h1>Create your account</h1>

                <form method="POST" action="{{ route('register') }}" class="ig-auth-form">
                    @csrf

                    <div class="ig-auth-field">
                        <label for="name" class="ig-label">Name</label>
                        <input id="name" type="text" class="form-control ig-input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="ig-auth-field">
                        <label for="email" class="ig-label">Email address</label>
                        <input id="email" type="email" class="form-control ig-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="ig-auth-field">
                        <label for="password" class="ig-label">Password</label>
                        <input id="password" type="password" class="form-control ig-input @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        @error('password')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="ig-auth-field">
                        <label for="password-confirm" class="ig-label">Confirm password</label>
                        <input id="password-confirm" type="password" class="form-control ig-input" name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <button type="submit" class="btn ig-auth-submit">Create account</button>
                </form>

                <div class="ig-auth-divider"><span>or</span></div>

                <p class="ig-auth-switch">
                    Already have an account?
                    <a href="{{ route('login') }}">Sign in</a>
                </p>
            </div>
        </section>
    </div>
</div>
@endsection
