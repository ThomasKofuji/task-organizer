<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', "TaskController::index");
$routes->get('/create', "TaskController::create");
$routes->post('/submit', "TaskController::submit");
$routes->get('/delete/(:num)', "TaskController::delete/$1");
$routes->get('/edit/(:num)', "TaskController::edit/$1");
$routes->post('/update/(:num)', "TaskController::update/$1");

// Rotas para API REST

$routes->group('api', function ($routes) {
    $routes->get('tasks', 'Api\TaskController::findAll');
    $routes->get('tasks/(:num)', 'Api\TaskController::findById/$1');
    $routes->post('tasks', 'Api\TaskController::create');
    $routes->put('tasks/(:num)', 'Api\TaskController::update/$1');
    $routes->delete('tasks/(:num)', 'Api\TaskController::delete/$1');
});