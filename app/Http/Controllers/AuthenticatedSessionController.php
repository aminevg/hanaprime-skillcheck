<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }
}
