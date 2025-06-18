<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->post('auth/register', 'AuthController::register');
$routes->post('auth/login', 'AuthController::login');

// group admin, mahasiswa, dosen kamu tetap seperti sebelumnya

//ROUTES ADMIN
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

    // ROUTES JADWAL KONSULTASI
     $routes->get('jadwal_konsultasi', 'JadwalKonsultasiController::index');
    $routes->get('jadwal_konsultasi/(:num)', 'JadwalKonsultasiController::show/$1');
    $routes->post('jadwal_konsultasi', 'JadwalKonsultasiController::create');
    $routes->put('jadwal_konsultasi/(:num)', 'JadwalKonsultasiController::update/$1');
    $routes->delete('jadwal_konsultasi/(:num)', 'JadwalKonsultasiController::delete/$1');
});


//ROUTES MAHASISWA
$routes->group('mahasiswa', ['filter' => 'jwt:mahasiswa'], function ($routes) {
     $routes->get('mahasiswa', 'MahasiswaController::index');
    $routes->get('mahasiswa/(:num)', 'MahasiswaController::show/$1');
    $routes->post('mahasiswa', 'MahasiswaController::create');
    $routes->put('mahasiswa/(:num)', 'MahasiswaController::update/$1');
    $routes->delete('mahasiswa/(:num)', 'MahasiswaController::delete/$1');

//JADWAL KONSULTASI(lihat aja)
    $routes->get('lihatJadwal', 'JadwalKonsultasiController::index');


    //ROUTES KONSULTASI START (lihat dan buat booking konsultasi)
     $routes->get('konsultasi', 'KonsultasiController::index');
    $routes->get('konsultasi/(:num)', 'KonsultasiController::show/$1');
    $routes->post('konsultasi', 'KonsultasiController::create');
    //ROUTES KONSULTASI END
});


//ROUTES DOSEN
$routes->group('dosen', ['filter' => 'jwt:dosen'], function ($routes) {
    // LIHAT DATA DIRINYA (opsional)
    $routes->get('dosen', 'DosenController::index'); // kalau ingin lihat semua dosen
    $routes->get('dosen/(:num)', 'DosenController::show/$1'); // lihat profil spesifik
    $routes->post('dosen', 'DosenController::create');
    $routes->put('dosen/(:num)', 'DosenController::update/$1');
    $routes->delete('dosen/(:num)', 'DosenController::delete/$1');

    // KONSULTASI (lihat & edit saja)
    $routes->get('konsultasi', 'KonsultasiController::index');
    $routes->get('konsultasi/(:num)', 'KonsultasiController::show/$1');
    $routes->put('konsultasi/(:num)', 'KonsultasiController::update/$1');

        // ROUTES JADWAL KONSULTASI
    $routes->get('jadwal_konsultasi', 'JadwalKonsultasiController::index');
    $routes->get('jadwal_konsultasi/(:num)', 'JadwalKonsultasiController::show/$1');
    $routes->post('jadwal_konsultasi', 'JadwalKonsultasiController::create');
    $routes->put('jadwal_konsultasi/(:num)', 'JadwalKonsultasiController::update/$1');
    $routes->delete('jadwal_konsultasi/(:num)', 'JadwalKonsultasiController::delete/$1');
    
});

