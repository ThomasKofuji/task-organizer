<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', "TaskController::index");
$routes->get('/create', "TaskController::create");
$routes->post('/submit', "TaskController::submit");
$routes->get('/delete/(:num)', "TaskController::delete/$1");
$routes->get('/edit/(:num)', "TaskController::edit/$1");
$routes->post('/update/(:num)', "TaskController::update/$1");