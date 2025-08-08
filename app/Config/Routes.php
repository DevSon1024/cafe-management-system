<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'UserController::login');

// Move the admin dashboard to a protected route
$routes->get('dashboard', 'Home::index', ['filter' => 'auth']); // We will add an admin filter later

// Add/update these resource routes
$routes->resource('menu', ['controller' => 'MenuController']);
$routes->resource('staff', ['controller' => 'StaffController']);
$routes->resource('tables', ['controller' => 'TableController']);
$routes->resource('categories', ['controller' => 'CategoryController']);

// Custom routes for Orders
$routes->get('orders', 'OrderController::index');
$routes->get('orders/new', 'OrderController::new');
$routes->post('orders/create', 'OrderController::create');
$routes->get('orders/receipt/(:num)', 'OrderController::receipt/$1');
$routes->post('orders/complete/(:num)', 'OrderController::complete/$1');


// --- PROTECTED ADMIN ROUTES ---
$routes->group('', ['filter' => 'admin'], function($routes) {
    $routes->get('dashboard', 'Home::index');
    $routes->resource('menu', ['controller' => 'MenuController']);
    $routes->resource('staff', ['controller' => 'StaffController']);
    $routes->resource('tables', ['controller' => 'TableController']);
    $routes->resource('categories', ['controller' => 'CategoryController']);
    $routes->get('orders', 'OrderController::index');
    // Note: The '/orders/new' is used by both users and admins, so we leave it out of this admin-only group.
    $routes->get('orders/receipt/(:num)', 'OrderController::receipt/$1');
    $routes->post('orders/complete/(:num)', 'OrderController::complete/$1');
});

// Custom routes for Orders (accessible to logged-in users)
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('orders/new', 'OrderController::new');
    $routes->post('orders/create', 'OrderController::create');
});

// Authentication Routes
$routes->get('login', 'UserController::login');
$routes->post('login', 'UserController::authenticate');
$routes->get('register', 'UserController::register');
$routes->post('register', 'UserController::store');
$routes->get('logout', 'UserController::logout');

// Protected User Routes
$routes->group('user', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'UserController::dashboard');
    // Add other user-specific routes here, like order history
});

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