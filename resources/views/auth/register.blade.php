@extends('layouts.app')

@section('content')
    <div class="register-container">
        <h2>Sign Up</h2>
        @if ($errors->any())
            <div class="alert-box">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="input-group">
                <input type="text" name="name" id="name" required placeholder="Full name" value="{{ old('name') }}">
            </div>

            <div class="input-group">
                <input type="email" name="email" id="email" required placeholder="Email" value="{{ old('email') }}">
            </div>

            <div class="input-group">
                <input type="password" name="password" id="password" required placeholder="Password">
            </div>

            <div class="input-group">
                <input type="password" name="password_confirmation" id="password_confirmation" required
                       placeholder="Confirm password">
            </div>

            <div class="button-wrapper inline-group">
                <button type="submit" class="btn btn-small">Sign Up</button>
                <p class="redirect-text">Already have an account? <a href="{{ url('/') }}" class="login-link">Login</a>
                </p>
            </div>
        </form>
    </div>

@endsection
