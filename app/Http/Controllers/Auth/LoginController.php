<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller {
    use \Illuminate\Foundation\Auth\AuthenticatesUsers;

    protected $redirectTo = '/dashboard';


    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (!Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'The provided credentials are incorrect.',
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Logged in successfully!');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('home'))->with('success', __('auth.logged_out'));
    }
}
