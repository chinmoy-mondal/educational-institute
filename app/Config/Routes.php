<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


$routes->get('/', 'Home::index');
$routes->get('/home', 'Home::index');
$routes->get('/home/welcome', 'Home::welcome');
$routes->get('/home/history', 'Home::history');
$routes->get('/home/mission', 'Home::mission');
$routes->get('/home/staff', 'Home::staff');
$routes->get('/user', 'User::index');

$routes->get('database/migrate', 'DatabaseController::migrate');


$routes->get('/contain', 'Contain::index');
$routes->get('/about', 'About::index');
$routes->get('/exam', 'Home::exam');
$routes->get('/result', 'Home::result');
$routes->get('/courses', 'Home::courses');
$routes->get('/contact', 'Home::contact');
$routes->get('/apply', 'Home::apply');
$routes->get('/course-details/(:num)', 'Home::courseDetails/$1');
$routes->get('/activity-details/(:num)', 'Home::activityDetails/$1');

$routes->get('/student', 'Student::index');
$routes->post('/student/save', 'Student::save');
$routes->get('/student/list', 'Student::list');

$routes->get('/student/edit/(:num)', 'Student::edit/$1');
$routes->post('/student/update/(:num)', 'Student::update/$1');
$routes->post('/student/delete/(:num)', 'Student::delete/$1');



$routes->get('/page', 'Page::index');

$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::register');

$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');

$routes->get('/dashboard', 'Dashboard::index');

$routes->set404Override(function () {
    $controller = new \App\Controllers\ErrorController();
    return $controller->show404();
});
