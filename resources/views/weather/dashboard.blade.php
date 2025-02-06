@extends('layouts.app')

@section('content')
    <div class="dashboard-container">
        <div class="dashboard-header">
            <span class="welcome-text">Welcome, {{ Auth::user()->name }}</span>
        </div>

        <!-- Search Section -->
        <div class="search-section">
            <div class="search-wrapper">
                <input type="text" id="city-input" placeholder="Enter city name..." class="search-input">
                <button onclick="searchWeather()" class="search-btn">Search</button>
            </div>
        </div>

        <!-- Weather Result Box -->
        <div id="weather-result" style="display:none;">
            <h3 id="weather-city"></h3>
            <p>🌡️ Temperature: <span id="weather-temp"></span><span id="unit-symbol">°C</span></p>
            <p>🌥️ Condition: <span id="weather-condition"></span></p>
            <p>💨 Wind Speed: <span id="weather-wind"></span> m/s</p>

            <button id="unit-toggle" onclick="toggleUnit()">Switch to °F</button>
        </div>

        <!-- Search History (Last 5 items)-->
        <div class="history-section">
            <h3>Your Search History</h3>
            <table class="history-table">
                <thead>
                <tr>
                    <th>City</th>
                    <th>Temperature</th>
                    <th>Condition</th>
                    <th>Wind Speed</th>
                    <th>Search Time</th>
                </tr>
                </thead>
                <tbody>
                @if($recentSearches->isEmpty())
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 10px;">No search data yet.</td>
                    </tr>
                @else
                    @foreach($recentSearches as $search)
                        <tr>
                            <td>{{ $search->city }}</td>
                            <td>{{ $search->temperature }}°C</td>
                            <td>{{ $search->weather_condition }}</td>
                            <td>{{ $search->wind_speed }} m/s</td>
                            <td>{{ $search->created_at->format('Y-m-d H:i:s') }}</td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
        <div class="logout-container" style="margin-top: 20px; text-align: center;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </div>
@endsection

<script>
    var isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
</script>
