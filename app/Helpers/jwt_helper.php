<?php
<<<<<<< HEAD

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
=======
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function generateJWT($user)
{
    $key = getenv('JWT_SECRET');
    $payload = [
        'id'    => $user['id'],
        'email' => $user['email'],
        'role'  => $user['role'],
        'exp'   => time() + 3600, // expired 1 jam
    ];
    return JWT::encode($payload, $key, 'HS256');
}

function decodeJWT($token)
{
   return JWT::decode($token, new Key(getenv('JWT_SECRET'), 'HS256'));

}
>>>>>>> 9f75f859c6f4ab538a3c4198eb9659be812a688b
