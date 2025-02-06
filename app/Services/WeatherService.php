<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\SearchHistory;
use Illuminate\Support\Facades\Auth;

class WeatherService {
    protected string $apiKey;

    public function __construct() {
        $this->apiKey = env('OPENWEATHER_API_KEY');
    }

    public function fetchWeatherData(string $city, string $unit = 'metric') {
        $url = "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$this->apiKey}&units={$unit}";
        $response = Http::get($url);

        if ($response->failed() || empty($response->json()['name'])) {
            return null;
        }

        return $response->json();
    }

    public function saveSearchHistory(array $data) {
        if (Auth::check()) {
            SearchHistory::create([
                'user_id' => Auth::id(),
                'city' => $data['name'],
                'temperature' => $data['main']['temp'],
                'weather_condition' => $data['weather'][0]['description'],
                'wind_speed' => $data['wind']['speed']
            ]);
        }
    }
}
