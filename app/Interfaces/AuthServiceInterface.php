<?php

namespace App\Interfaces;

use App\Models\User;

interface AuthServiceInterface
{
    public function register(array $data): User;

    public function login(array $credentials, bool $remember = false): bool;

    public function logout(): void;
}
