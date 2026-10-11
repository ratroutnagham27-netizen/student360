@extends('layouts.auth')
@section('title', 'Login')
@section('content')
    <div class="login-box">
        <div class="brand-side">
            <h2><i class="bi bi-mortarboard-fill"></i> Student360</h2>
            <p class="lead">Smart Student Development and School Communication Platform</p>
            <ul>
                <li><i class="bi bi-check-circle-fill"></i> Centralized student profile</li>
                <li><i class="bi bi-check-circle-fill"></i> Structured teacher updates</li>
                <li><i class="bi bi-check-circle-fill"></i> Authorized parent view</li>
            </ul>
        </div>
        <div class="form-side">
            <h4>Welcome back</h4>
            <p class="subtitle">Sign in to your account</p>
            @if($errors->any())
                <div class="note note-error">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    {{ $errors->first() }}
                </div>
            @endif
            <form method="POST" action="{{ route('login.store') }}">
                @csrf
                <div class="field">
                    <label for="email">Email address</label>
                    <div class="input-box">
                        <span class="icon"><i class="bi bi-envelope-fill"></i></span>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@student360.test" required autofocus>
                    </div>
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <div class="input-box">
                        <span class="icon"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    </div>
                </div>
                <div class="check-row">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember me</label>
                </div>
                <button type="submit" class="btn btn-main btn-wide">
                    <i class="bi bi-box-arrow-in-right"></i> Sign In
                </button>
            </form>
        </div>
    </div>
@endsection