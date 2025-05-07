<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */





// Homepage Route
$routes->get('/', 'HomepageController::index');

// Auth Routes 
$routes->group('', function ($routes) {
    // Registrasi
    $routes->get('register', 'AuthController::register');
    $routes->post('register', 'AuthController::processRegister');

    // Login/Logout
    $routes->get('login', 'AuthController::login');
    $routes->post('login', 'AuthController::processLogin');
    $routes->get('logout', 'AuthController::logout');

    // Password Recovery
    $routes->get('forgotpassword', 'AuthController::forgotpassword');
    $routes->post('forgotpassword', 'AuthController::processForgotPassword');
    $routes->get('verify-otp', 'AuthController::verifyOtp');
    $routes->post('verify-otp', 'AuthController::processVerifyOtp');
    $routes->get('reset-password', 'AuthController::resetPassword');
    $routes->post('reset-password', 'AuthController::processResetPassword');
});

$routes->group('', ['filter' => 'role'], function ($routes) {
    $routes->get('/dashboard', 'DashboardController::index');
    $routes->get('/penelitian', 'PenelitianController::showpenelitian');
    $routes->get('/hki', 'HkiController::showhki');
});

$routes->post('/penelitian/save', 'PenelitianController::save');
$routes->post('/penelitian/update/(:num)', 'PenelitianController::update/$1');
$routes->delete('/penelitian/delete/(:num)', 'PenelitianController::delete/$1');
$routes->post('/penelitian/upload-laporan/(:num)', 'PenelitianController::uploadLaporan/$1');
$routes->get('/penelitian/detail/(:num)', 'PenelitianController::getDetail/$1');

// Kalender
$routes->group('kalender', function ($routes) {
    $routes->get('/', 'KalenderController::index');
    $routes->get('events', 'KalenderController::getEvents');
    $routes->post('add', 'KalenderController::addEvent');
    $routes->post('update/(:num)', 'KalenderController::updateEvent/$1');
    $routes->post('delete/(:num)', 'KalenderController::deleteEvent/$1');
});

// Publikasi
$routes->group('publikasi', function ($routes) {
    $routes->get('/', 'PublikasiController::index');
    $routes->get('admin', 'PublikasiController::getAllForAdmin');
    $routes->post('/', 'PublikasiController::store');
    $routes->put('(:num)', 'PublikasiController::update/$1');
    $routes->delete('(:num)', 'PublikasiController::delete/$1');
    $routes->get('(:num)/penulis', 'PublikasiController::getPenulis/$1');
    $routes->get('download/(:num)', 'PublikasiController::download/$1');
    $routes->get('preview/(:num)', 'PublikasiController::preview/$1');
    $routes->get('publikasi/export', 'PublikasiController::export');
});



$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('profile', 'Profile::index');
    $routes->get('profile/edit', 'Profile::edit');
    $routes->post('profile/update', 'Profile::update');
});
