<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

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