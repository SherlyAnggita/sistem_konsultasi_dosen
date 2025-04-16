<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

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

//ROUTES ADMIN START
$routes->get('admin', 'AdminController::index');
$routes->get('admin/(:num)', 'AdminController::show/$1');
$routes->post('admin', 'AdminController::create');
$routes->put('admin/(:num)', 'AdminController::update/$1');
$routes->delete('admin/(:num)', 'AdminController::delete/$1');
//ROUTES ADMIN END

//ROUTES USERS START
$routes->get('users', 'UsersController::index');
$routes->get('users/(:num)', 'UsersController::show/$1');
$routes->post('users', 'UsersController::create');
$routes->put('users/(:num)', 'UsersController::update/$1');
$routes->delete('users/(:num)', 'UsersController::delete/$1');
//ROUTES USERS END

//ROUTES KONSULTASI START
$routes->get('konsultasi', 'KonsultasiController::index');
$routes->get('konsultasi/(:num)', 'KonsultasiController::show/$1');
$routes->post('konsultasi', 'KonsultasiController::create');
$routes->put('konsultasi/(:num)', 'KonsultasiController::update/$1');
$routes->delete('konsultasi/(:num)', 'KonsultasiController::delete/$1');
//ROUTES KONSULTASI END