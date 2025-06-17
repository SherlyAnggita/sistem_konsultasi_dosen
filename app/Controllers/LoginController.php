<?php

namespace App\Controllers;
use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;

class AuthController extends ResourceController
{
    protected $modelName = 'App\Models\UserModel';
    protected $format    = 'json';

    public function login()
    {
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $user = $this->model->where('email', $email)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return $this->failUnauthorized('Email atau password salah');
        }

        $token = generateJWT($user);

        return $this->respond([
            'status' => 200,
            'message' => 'Login berhasil',
            'token' => $token,
            'role' => $user['role']
        ]);
    }
}
