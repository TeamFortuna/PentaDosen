<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


// Homepage Route
$routes->get('/', 'HomepageController::index');



// $routes->get('/register', 'AuthController::register');
// $routes->post('/register', 'AuthController::register');

// $routes->get('/login', 'AuthController::login');
// $routes->post('/login', 'AuthController::login'); 

$routes->get('/forgotpassword', 'AuthController::forgotpassword');
$routes->get('/kalender', 'KalenderController::showcalender');
$routes->get('/penelitian', 'PenelitianController::showpenelitian');
$routes->get('/publikasi', 'PublikasiController::showpublikasi');
$routes->get('/hki', 'HkiController::showhki');



// Auth Routes
$routes->get('/register', 'AuthController::register');
$routes->post('/register', 'AuthController::processRegister');
$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::processLogin');
$routes->get('auth/logout', 'AuthController::logout');

// Dashboard Route
$routes->get('/dashboard', 'DashboardController::index');

// Kalender API Routes
$routes->post('/kalender/save', 'KalenderController::saveEvent');
$routes->put('/kalender/update/(:num)', 'KalenderController::updateEvent/$1');
$routes->post('/kalender/delete/(:num)', 'KalenderController::deleteEvent/$1');
