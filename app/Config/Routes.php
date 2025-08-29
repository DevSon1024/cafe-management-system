<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Landing::index');

// --- PUBLIC & GUEST ROUTES ---
// Routes for users who are NOT logged in
$routes->group('', ['filter' => 'guest'], function($routes) {
    $routes->get('login', 'UserController::login');
    $routes->post('login', 'UserController::authenticate');
});

// Route for logged-in users to log out
$routes->get('logout', 'UserController::logout');


// --- ADMIN-ONLY ROUTES ---
// All admin functionalities are grouped and prefixed here
$routes->group('admin', ['filter' => 'admin'], function($routes) {
    $routes->get('dashboard', 'Home::index');
    $routes->get('sales', 'SalesController::index');
    $routes->get('profile', 'ProfileController::index');
    $routes->get('profile/edit', 'ProfileController::edit');
    $routes->post('profile/update', 'ProfileController::update'); 
    
    // Resource routes now correctly live inside the admin group
    $routes->resource('menu', ['controller' => 'MenuController']);
    $routes->resource('staff', ['controller' => 'StaffController']);
    $routes->resource('tables', ['controller' => 'TableController']);
    $routes->resource('categories', ['controller' => 'CategoryController']);
    
    // Admin-specific order routes
    $routes->get('orders', 'OrderController::index');
    $routes->get('orders/receipt/(:num)', 'OrderController::receipt/$1');
    $routes->post('orders/complete/(:num)', 'OrderController::complete/$1');
});

// Routes for placing a new order, accessible by any logged-in user
$routes->group('orders', ['filter' => 'auth'], function($routes) {
    $routes->get('new', 'OrderController::new');
    $routes->post('create', 'OrderController::create');
});