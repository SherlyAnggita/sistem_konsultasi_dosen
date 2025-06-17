<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

if (!function_exists('createJWT')) {
    function createJWT($payload)
    {
        $key = getenv('JWT_SECRET'); // Make sure this is set in your .env
        return JWT::encode($payload, $key, 'HS256');
    }
}

if (!function_exists('decodeJWT')) {
    function decodeJWT($token)
    {
        $key = getenv('JWT_SECRET');
        return JWT::decode($token, new Key($key, 'HS256'));
    }
}
