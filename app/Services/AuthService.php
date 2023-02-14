<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function login($data)
    {
        return auth()->attempt(['email' => $data['email'], 'password' => $data['password']]);
    }

    public function register($data)
    {
        $this->model->create($data);

        $this->login($data);
    }
}
