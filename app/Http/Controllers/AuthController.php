<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request, AuthService $service)
    {
        $data = $request->validated();

        $auth = $service->login($data);

        if(!$auth) return back()->withErrors(['msg' => 'Неверный логин или пароль.']);

        return to_route('home')->with('success', 'Добро пожаловать!');
    }

    public function registerPage()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request, AuthService $service)
    {
        $data = $request->validated();

        $service->register($data);

        return to_route('home')->with('success', 'Добро пожаловать!');
    }

    public function logout()
    {
        auth()->logout();

        return to_route('home');
    }
}
