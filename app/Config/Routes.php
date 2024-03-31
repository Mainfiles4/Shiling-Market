<?php

// Set CORS headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Role, Origin, Content-Type, Authorization"); // Add Authorization header
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit; // Preflight request, exit early
}

$routes->get('/', 'ApiControllers::index');
$routes->post('/', 'ApiControllers::index');
$routes->get('/api/v1', 'ApiControllers::index');
$routes->post('/api/v1', 'ApiControllers::index');

// for user registration
$routes->post('api/v1/auth-register', 'AuthController::register');
$routes->post('api/v1/auth-login', 'AuthController::login');
$routes->get('api/v1/auth-logout', 'AuthController::logout');

// for products manipulation
$routes->get('/api/v1/products', 'ProductsController::index');
$routes->post('/api/v1/products', 'ProductsController::create');

// to buy products
$routes->post('/api/v1/products/buy/(:num)', 'AuthController::buyProduct/$1');
$routes->post('/api/v1/buy-shiling', 'AuthController::buyShiling');

// users transaction history
$routes->get('/api/v1/transactions/(:num)', 'AuthController::transactionHistory/$1');
