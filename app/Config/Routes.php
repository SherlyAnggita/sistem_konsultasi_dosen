<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// ADMIN: Semua route
$routes->group('', ['filter' => 'auth:admin'], function($routes) {
    $routes->resource('admin');
    $routes->resource('users');
    $routes->resource('mahasiswa');
    $routes->resource('dosen');
    $routes->resource('konsultasi');
});

// DOSEN: hanya akses ke detail_dosen dan jadwal_konsultasi
$routes->group('', ['filter' => 'auth:dosen'], function($routes) {
    $routes->resource('detail_dosen');
    $routes->resource('jadwal_konsultasi');
});

// MAHASISWA: hanya akses ke detail_mahasiswa dan konsultasi
$routes->group('', ['filter' => 'auth:mahasiswa'], function($routes) {
    $routes->resource('detail_mahasiswa');
    $routes->resource('konsultasi');
});