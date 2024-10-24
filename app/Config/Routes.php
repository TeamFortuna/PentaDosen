<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 $routes->setDefaultNamespace('App\Controllers');
 $routes->setDefaultController('');
 $routes->setDefaultMethod('index');
 $routes->setTranslateURIDashes('false');
 $routes->set404Override();
 $routes->setAutoRoute(true);


$routes->get('/', 'RegisterLoginController::index');
$routes->get('/register_login', 'RegisterLoginController::index');
$routes->get('/dashboard', 'DashboardController::index');
$routes->post('/processRegister', 'RegisterLoginController::processRegister');
$routes->post('/processLogin', 'RegisterLoginController::processLogin');
