<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader = $request->getHeaderLine("Authorization");

        if (!$authHeader || !str_starts_with($authHeader, "Bearer ")) {
            return response()->setJSON(['message' => 'Token not found'])->setStatusCode(401);
        }

        $token = explode(" ", $authHeader)[1];
        try {
            $decoded = JWT::decode($token, new Key(getenv('JWT_SECRET'), 'HS256'));

            // Simpan user login ke request attribute
            $request->user = (array)$decoded;

            // Cek role jika diminta
            if ($arguments) {
                $allowedRoles = $arguments;
                if (!in_array($decoded->role, $allowedRoles)) {
                    return response()->setJSON(['message' => 'Forbidden, role not allowed'])->setStatusCode(403);
                }
            }
        } catch (\Exception $e) {
            return response()->setJSON(['message' => 'Invalid token'])->setStatusCode(401);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
