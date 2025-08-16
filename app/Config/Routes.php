<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --- PUBLIC & GUEST ROUTES ---
// Routes for users who are NOT logged in
$routes->group('', ['filter' => 'guest'], function($routes) {
    $routes->get('/', 'UserController::login');
    $routes->get('login', 'UserController::login');
    $routes->get('register', 'UserController::register');
});

// These routes handle the form submissions and don't need the guest filter
$routes->post('login', 'UserController::authenticate');
$routes->post('register', 'UserController::store');
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

// --- LOGGED-IN USER ROUTES ---
// Routes for any logged-in user (admin or regular user)
$routes->group('user', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'UserController::dashboard');
    $routes->get('orders', 'UserController::orders');
    $routes->get('profile', 'ProfileController::index'); // route for the profile page
    $routes->get('profile/edit', 'ProfileController::edit');
    $routes->post('profile/update', 'ProfileController::update');
    // You can add user-specific order history routes here
    $routes->get('orders/receipt/(:num)', 'OrderController::receipt/$1'); // for user-specific reciepts
});

// Routes for placing a new order, accessible by any logged-in user
$routes->group('orders', ['filter' => 'auth'], function($routes) {
    $routes->get('new', 'OrderController::new');
    $routes->post('create', 'OrderController::create');
});