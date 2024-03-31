<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'ApiControllers::index');
$routes->post('/', 'ApiControllers::index');
$routes->get('/api/v1', 'ApiControllers::index');
$routes->post('/api/v1', 'ApiControllers::index');

// for user registration
$routes->post('api/v1/auth-register', 'AuthController::register');
$routes->post('api/v1/auth-login', 'AuthController::login');

// for products manpulation
$routes->get('/api/v1/products', 'ProductsController::index');
$routes->post('/api/v1/products', 'ProductsController::create');

// to buy products
$routes->post('/api/v1/products/buy/(:num)', 'AuthController::buyProduct/$1');
$routes->post('/api/v1/buy-shiling', 'AuthController::buyShiling');

// users transaction history
$routes->get('/api/v1/transactions/(:num)', 'AuthController::transactionHistory/$1');