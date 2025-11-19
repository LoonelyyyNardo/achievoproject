<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('dashboard', 'MainController::dashboard');
$routes->get('/dashboard', 'MainController::dashboard');

// Úkoly
$routes->get('/tasks', 'TasksController::index');
$routes->get('/tasks/add', 'TasksController::add');   // formulář pro přidání
$routes->post('/tasks/store', 'TasksController::store');   // zpracování formuláře
$routes->get('/tasks/delete/(:num)', 'TasksController::delete/$1'); // mazání
$routes->get('tasks/done/(:num)', 'TasksController::done/$1');

