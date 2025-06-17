<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class JwtAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader = $request->getHeaderLine('Authorization');

        if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            return service('response')
                ->setJSON(['status' => false, 'message' => 'Token tidak ditemukan.'])
                ->setStatusCode(401);
        }

        $token = $matches[1];

        try {
            $key = getenv('JWT_SECRET');
            $decoded = JWT::decode($token, new Key($key, 'HS256'));

            // simpan data user ke request
            $request->user = $decoded;

            // Jika ingin memfilter berdasarkan role (optional)
            if ($arguments && !in_array($decoded->role, $arguments)) {
                return service('response')
                    ->setJSON(['status' => false, 'message' => 'Akses ditolak untuk role ini.'])
                    ->setStatusCode(403);
            }
        } catch (Exception $e) {
            return service('response')
                ->setJSON(['status' => false, 'message' => 'Token tidak valid: ' . $e->getMessage()])
                ->setStatusCode(401);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // tidak digunakan
    }
}
