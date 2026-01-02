<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default & Dashboard
$routes->get('/', 'Home::index');
$routes->get('dashboard', 'MainController::dashboard');
$routes->get('/dashboard', 'MainController::dashboard');
// Login a Logout
$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::processLogin');
$routes->get('/logout', 'AuthController::logout');

// Úkoly
$routes->get('/tasks', 'TasksController::index');
$routes->get('/tasks/add', 'TasksController::add');   // formulář pro přidání
$routes->post('/tasks/store', 'TasksController::store');   // zpracování formuláře
$routes->get('/tasks/delete/(:num)', 'TasksController::delete/$1'); // mazání
$routes->get('tasks/done/(:num)', 'TasksController::done/$1');

// Admin
