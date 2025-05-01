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
$routes->get('/publikasi', 'PublikasiController::showpublikasi');

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
