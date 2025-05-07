<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */





// Route
$routes->get('/', 'HomepageController::index');

$routes->get('/register', 'AuthController::register');
$routes->post('/register', 'AuthController::processRegister');
$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::processLogin');
$routes->get('/logout', 'AuthController::logout');

$routes->get('/forgotpassword', 'AuthController::forgotpassword');
$routes->post('/forgotpassword', 'AuthController::processForgotPassword');
$routes->get('/verify-otp', 'AuthController::verifyOtp');
$routes->post('/verify-otp', 'AuthController::processVerifyOtp');
$routes->get('/reset-password', 'AuthController::resetPassword');
$routes->post('/reset-password', 'AuthController::processResetPassword');

$routes->get('/dashboard', 'DashboardController::index');
$routes->get('/penelitian', 'PenelitianController::showpenelitian');
$routes->post('/penelitian/save', 'PenelitianController::save');
$routes->post('/penelitian/update/(:num)', 'PenelitianController::update/$1');
$routes->delete('/penelitian/delete/(:num)', 'PenelitianController::delete/$1');
$routes->post('/penelitian/upload-laporan/(:num)', 'PenelitianController::uploadLaporan/$1');
$routes->get('/penelitian/detail/(:num)', 'PenelitianController::getDetail/$1');
$routes->get('/publikasi', 'PublikasiController::showpublikasi');
$routes->get('/hki', 'HkiController::showhki');

$routes->group('kalender', function ($routes) {
    $routes->get('/', 'KalenderController::index');
    $routes->get('events', 'KalenderController::getEvents');
    $routes->post('add', 'KalenderController::addEvent');
    $routes->post('update/(:num)', 'KalenderController::updateEvent/$1');
    $routes->post('delete/(:num)', 'KalenderController::deleteEvent/$1');
});

$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('profile', 'Profile::index');
    $routes->get('profile/edit', 'Profile::edit');
    $routes->post('profile/update', 'Profile::update');
});
