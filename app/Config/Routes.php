<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('tasks', 'TaskController::index');
$routes->get('tasks/getAll', 'TaskController::getAll');
$routes->post('tasks/add', 'TaskController::add');
$routes->post('tasks/update', 'TaskController::update');
$routes->post('tasks/delete', 'TaskController::delete');
$routes->get('tasks/editForm/(:num)', 'TaskController::editForm/$1');
$routes->post('tasks/edit', 'TaskController::edit');
