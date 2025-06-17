<?php
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