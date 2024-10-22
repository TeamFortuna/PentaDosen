<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'RegisterLoginController::index');
$routes->get('/register_login', 'RegisterLoginController::index');
$routes->get('/dashboard', 'DashboardController::index');
$routes->post('/processRegister', 'RegisterLoginController::processRegister');
$routes->post('/processLogin', 'RegisterLoginController::processLogin');


