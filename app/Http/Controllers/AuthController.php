<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Interfaces\AuthServiceInterface;
use App\Http\Requests\Auth\LoginRequest;

class AuthController extends Controller
{
    protected AuthServiceInterface $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $this->authService->register($data);

        return redirect()
            ->route('login')
            ->with('success', 'Registration successful!');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $credentials = [
            'email' => $data['email'],
            'password' => $data['password'],
        ];

        $remember = $request->boolean('remember');

        if ($this->authService->login($credentials, $remember)) {

            $request->session()->regenerate();

            return redirect()
                ->intended('dashboard')
                ->with('success', 'Login successful!');
        }

        return back()
            ->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])
            ->onlyInput('email');
    }

    public function logout()
    {
        $this->authService->logout();

        return redirect()
            ->route('login')
            ->with('success', 'Logout successful!');
    }
}
