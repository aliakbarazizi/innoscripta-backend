<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\LoginRequest;

class LoginController
{
    public function index(LoginRequest $request): \Illuminate\Http\Response
    {
        $request->authenticate();

        $request->session()->regenerate();

        return response()->noContent();
    }
}
