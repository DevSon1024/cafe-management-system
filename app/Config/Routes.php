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
    $routes->post('orders/update_status/(:num)', 'OrderController::update_status/$1'); // <-- ADD THIS LINE
});

// Routes for placing a new order, accessible by any logged-in user
$routes->group('orders', ['filter' => 'auth'], function($routes) {
    $routes->get('new', 'OrderController::new');
    $routes->post('create', 'OrderController::create');
});

// --- GUEST ORDERING ROUTES ---
$routes->get('order/new', 'OrderController::new_guest_order');
$routes->post('order/create', 'OrderController::create_guest_order');
$routes->post('order/process_type', 'OrderController::process_order_type');
$routes->post('order/process_payment', 'OrderController::process_payment');
$routes->get('order/receipt/(:num)', 'OrderController::receipt/$1');

// --- CHEF ROUTES ---
$routes->group('chef', ['filter' => 'chef'], function($routes) {
    $routes->get('dashboard', 'ChefController::index');
    $routes->get('order_history', 'ChefController::order_history'); // <-- ADD THIS LINE
    $routes->post('order/update_status/(:num)', 'ChefController::update_status/$1');
});

// --- CASHIER ROUTES ---
$routes->group('cashier', ['filter' => 'cashier'], function($routes) {
    $routes->get('dashboard', 'CashierController::index');
    $routes->get('sales', 'SalesController::index');
    $routes->get('orders/new', 'CashierController::new_order');
    $routes->post('orders/create', 'CashierController::create_order');
    $routes->get('receipt/(:num)', 'CashierController::receipt/$1');
});