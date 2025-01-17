<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        session()->regenerate();

        return redirect()->intended(route('home'));
    }

    public function destroy(): RedirectResponse
    {
        auth('web')->logout();

        session()->invalidate();
        session()->regenerateToken();

        return to_route('login.create');
    }
}
