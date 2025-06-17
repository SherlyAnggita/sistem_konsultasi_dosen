<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->post('auth/register', 'AuthController::register');
$routes->post('auth/login', 'AuthController::login');

// group admin, mahasiswa, dosen kamu tetap seperti sebelumnya


$routes->group('admin', ['filter' => 'jwt:admin'], function ($routes) {
    // ROUTES DOSEN START
    $routes->get('dosen', 'DosenController::index');
    $routes->get('dosen/(:num)', 'DosenController::show/$1');
    $routes->post('dosen', 'DosenController::create');
    $routes->put('dosen/(:num)', 'DosenController::update/$1');
    $routes->delete('dosen/(:num)', 'DosenController::delete/$1');
    // ROUTES DOSEN END

    //ROUTES MAHASISWA START
    $routes->get('mahasiswa', 'MahasiswaController::index');
    $routes->get('mahasiswa/(:num)', 'MahasiswaController::show/$1');
    $routes->post('mahasiswa', 'MahasiswaController::create');
    $routes->put('mahasiswa/(:num)', 'MahasiswaController::update/$1');
    $routes->delete('mahasiswa/(:num)', 'MahasiswaController::delete/$1');
    //ROUTES MAHASISWA END

    //ROUTES KONSULTASI START
    $routes->get('konsultasi', 'KonsultasiController::index');
    $routes->get('konsultasi/(:num)', 'KonsultasiController::show/$1');
    $routes->post('konsultasi', 'KonsultasiController::create');
    $routes->put('konsultasi/(:num)', 'KonsultasiController::update/$1');
    $routes->delete('konsultasi/(:num)', 'KonsultasiController::delete/$1');
    //ROUTES KONSULTASI END
});

$routes->group('mahasiswa', ['filter' => 'jwt:mahasiswa'], function ($routes) {
    $routes->get('lihat', 'MahasiswaController::index');

    //ROUTES KONSULTASI START
    $routes->get('konsultasi', 'KonsultasiController::index');
    $routes->get('konsultasi/(:num)', 'KonsultasiController::show/$1');
    $routes->post('konsultasi', 'KonsultasiController::create');
    $routes->put('konsultasi/(:num)', 'KonsultasiController::update/$1');
    $routes->delete('konsultasi/(:num)', 'KonsultasiController::delete/$1');
    //ROUTES KONSULTASI END
});

$routes->group('dosen', ['filter' => 'jwt:dosen'], function ($routes) {
    $routes->get('lihat', 'DosenController::index');
    
});
