<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default route & Dashboard
$routes->get('/', 'Home::index');
$routes->get('dashboard', 'MainController::dashboard');
$routes->get('/dashboard', 'MainController::dashboard');

// Login a Logout
$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::processLogin');
$routes->get('/logout', 'AuthController::logout');

// Úkoly
$routes->get('tasks', 'TasksController::index');
$routes->get('tasks/add', 'TasksController::add');
$routes->post('tasks/store', 'TasksController::store');
$routes->get('tasks/done/(:num)', 'TasksController::done/$1');
$routes->get('tasks/delete/(:num)', 'TasksController::delete/$1');

// Rozvrh
$routes->get('/schedule', 'ScheduleController::index');

// Calendar
$routes->get('calendar', 'CalendarController::index');
$routes->get('calendar/events', 'CalendarController::events');

// Leaderboards
$routes->get('/leaderboard', 'LeaderboardController::index');

// Points
$routes->get('/points/form/(:num)/(:num)', 'PointsController::form/$1/$2');
$routes->post('/points/save', 'PointsController::save');
$routes->get('/points/task/(:num)', 'PointsController::taskStudents/$1');
$routes->get('/leaderboard', 'PointsController::leaderboard');

// Admin
$routes->get('admin/users', 'AdminController::users');
$routes->post('admin/create-user', 'AdminController::createUser');