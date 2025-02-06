<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SearchHistory;
use App\Services\WeatherService;

class WeatherController extends Controller {
    protected WeatherService $weatherService;

    public function __construct(WeatherService $weatherService) {
        $this->weatherService = $weatherService;
    }

    public function showHome() {
        return Auth::check() ? redirect()->route('dashboard') : view('weather.home');
    }

    public function userDashboard() {
        $recentSearches = SearchHistory::where('user_id', Auth::id())->latest()->limit(5)->get();
        return view('weather.dashboard', compact('recentSearches'));
    }

    public function search(Request $request) {
        $request->validate([
            'city' => 'required|string|max:255',
            'unit' => 'nullable|string|in:metric,imperial'
        ]);

        $city = $request->input('city');
        $unit = $request->input('unit', 'metric');

        $data = $this->weatherService->fetchWeatherData($city, $unit);

        if (!$data) {
            return response()->json(['error' => 'City not found. Please enter a valid city name.'], 404);
        }

        $this->weatherService->saveSearchHistory($data);

        return response()->json($data);
    }

    public function getHistory() {
        $recentSearches = SearchHistory::where('user_id', Auth::id())->latest()->limit(5)->get();
        return response()->json($recentSearches);
    }
}

