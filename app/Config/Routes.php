<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --- PUBLIC ROUTES (No login required) ---
$routes->group('', ['filter' => 'guest'], function($routes) {
    $routes->get('/', 'UserController::login');
    $routes->get('login', 'UserController::login');
    $routes->get('register', 'UserController::register');
});

$routes->post('login', 'UserController::authenticate');
$routes->post('register', 'UserController::store');
$routes->get('logout', 'UserController::logout');

// --- ADMIN-ONLY ROUTES (Requires admin role) ---
$routes->group('admin', ['filter' => 'admin'], function($routes) {
    $routes->get('dashboard', 'Home::index');
    $routes->resource('menu', ['controller' => 'MenuController']);
    $routes->resource('staff', ['controller' => 'StaffController']);
    $routes->resource('tables', ['controller' => 'TableController']);
    $routes->resource('categories', ['controller' => 'CategoryController']);
    $routes->get('orders', 'OrderController::index');
    $routes->get('orders/receipt/(:num)', 'OrderController::receipt/$1');
    $routes->post('orders/complete/(:num)', 'OrderController::complete/$1');
});

// --- LOGGED-IN USER ROUTES (Requires user or admin role) ---
$routes->group('user', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'UserController::dashboard');
});

$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('orders/new', 'OrderController::new');
    $routes->post('orders/create', 'OrderController::create');
});