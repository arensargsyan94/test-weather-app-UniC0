@extends('layouts.app')

@section('content')

    <!-- Page Container -->
    <div class="container-wrapper">
        <div class="auth-container">
            <!-- Guest Search Section -->
            <div class="guest-container">
                <h2>Search as Guest</h2>

                <div class="input-group">
                    <input type="text" id="guest-search" placeholder="Enter city name...">
                </div>

                <div class="button-wrapper left-align">
                    <button class="btn btn-small" onclick="searchWeather()">Search</button>
                </div>

                <div id="weather-result" style="display:none;">
                    <h3 id="weather-city"></h3>
                    <p>🌡️ Temperature: <span id="weather-temp"></span><span id="unit-symbol">°C</span></p>
                    <p>🌥️ Condition: <span id="weather-condition"></span></p>
                    <p>💨 Wind Speed: <span id="weather-wind"></span> m/s</p>

                    <button id="unit-toggle" onclick="toggleUnit()">Switch to °F</button>
                </div>
            </div>

            <div class="divider"></div>

            <!-- Login Section -->
            <div class="login-container">
                <h2>Login</h2>

                @if(session('success'))
                    <div class="alert success-message">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert error-message">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" autocomplete="off">
                    @csrf
                    <div class="input-group">
                        <input type="email" name="email" autocomplete="off" placeholder="Email" required
                               value="{{ old('email') }}">
                    </div>

                    <div class="input-group">
                        <input type="password" name="password" placeholder="Password" autocomplete="off" required>
                    </div>

                    <div class="button-wrapper inline-group">
                        <button type="submit" class="btn btn-small">Login</button>
                        <p class="redirect-text">Don't have an account? <a href="{{ url('/register') }}"
                                                                           class="login-link">Sign Up</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

<script>
    var isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
</script>
