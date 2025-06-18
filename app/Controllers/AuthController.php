<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use CodeIgniter\API\ResponseTrait;
use App\Models\UsersModel;
use Config\Database;

class AuthController extends ResourceController
{
    use ResponseTrait;

    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UsersModel();
        $this->db = Database::connect();
    }

    // Register function
    public function register()
    {
        $rules = $this->validate([
            'username' => 'required|string',
            'email' => 'required|valid_email',
            'password' => 'required|min_length[8]',
            // 'role' => 'required|in_list[admin,dosen,mahasiswa]'
        ]);

        if (!$rules) {
            return $this->failValidationErrors($this->validator->getErrors(), 400);
        }

        $username = $this->request->getVar('username');
        $email    = $this->request->getVar('email');
        $password = $this->request->getVar('password'); 
        $role     = 'mahasiswa';
        // $role     = $this->request->getVar('role');

        $cekUser = $this->userModel->where('email', $email)->first();
        if ($cekUser) {
            return $this->fail("Email sudah digunakan untuk akun user.");
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // ✅ Tambahan: generate token & set verifikasi
        $token = bin2hex(random_bytes(32));

        $this->userModel->insert([
            'username'     => $username,
            'email'        => $email,
            'password'     => $hashedPassword,
            'role'         => $role,
            'token'        => $token,
            'is_verified'  => false // Tambahan field verifikasi
        ]);

        // Tambahan: Kirim email verifikasi
        $emailService = \Config\Services::email();
        $emailService->setFrom('backendpbf@gmail.com', 'Verifikasi Email Konsultasi Dosen');
        $emailService->setTo($email);
        $emailService->setSubject('Verifikasi Email Konsultasi Dosen');
        $message = "Halo $username,\n\nKlik link berikut untuk verifikasi akun Anda:\n\n" .
                base_url("auth/verify/$token");
        $emailService->setMessage($message);

        if (!$emailService->send()) {
            return $this->failServerError($emailService->printDebugger(['headers']));
        }

        // ✅ Tetap tampilkan output versi kamu
        return $this->respondCreated([
            'message' => 'User berhasil didaftarkan. Silakan cek email untuk verifikasi.',
            'user' => [
                'email' => $email,
                'username' => $username,
                'role' => $role
            ]
        ]);
    }

    // Email verification function
    public function verify($token)
    {
        $user = $this->userModel->where('token', $token)->first();

        if (!$user) {
            return $this->failNotFound('Token tidak valid.');
        }

        $this->userModel->update($user['id'], [
            'is_verified' => true,
            'token' => null
        ]);

        return $this->respond(['message' => 'Email berhasil diverifikasi.']);
    }

        //Login function
        public function login()
    {
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        // $role = $this->request->getVar('role');

        if (!$email || !$password) {
            return $this->fail('Email dan password wajib diisi.', 400);
        }

        $user = $this->userModel->where('email', $email)->first();

        if (!$user) {
            return $this->failNotFound('Email tidak ditemukan.');
        }

        if (!password_verify($password, $user['password'])) {
            return $this->fail('Password salah.', 401);
        }
        // if ($user['role'] !== $role) {
        //     return $this->fail('Role tidak sesuai.');
        // }


        // JWT setup
        $key = getenv('JWT_SECRET');
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600; // 1 jam
        $payload = [
            'iat'  => $issuedAt,
            'exp'  => $expirationTime,
            'uid'  => $user['id'],
            'username' => $user['username'],
            'email'  => $user['email'],
            'role' => $user['role']
        ];

        $jwt = createJWT($payload);

        session()->set('userData', $payload);

        return $this->respond([
            'status' => true,
            'message' => 'Login berhasil.',
            'user' => [
                'username' => $user['username'],
                'role' => $user['role']
            ],
            'token' => $jwt
        ]);
    }
}
