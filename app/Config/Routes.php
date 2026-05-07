<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

# website page
$routes->get('/', 'Home::index');
$routes->get('home', 'Home::index');



#Auth
$routes->get('register', 'Auth::showRegisterForm');
$routes->post('register', 'Auth::processRegister');

$routes->get('login', 'Auth::showLoginForm');
$routes->post('login', 'Auth::processLogin');
$routes->get('logout', 'Auth::logout');

$routes->get('/forgot-password', 'Auth::forgotPassword');
$routes->post('/forgot-password/send', 'Auth::sendResetLink');
$routes->get('/reset-password/(:segment)', 'Auth::resetPassword/$1');
$routes->post('/reset-password/update', 'Auth::updatePassword');

#Dashboard
$routes->group('dashboard', function ($routes) {

    $routes->get('/', 'Dashboard::index');
    $routes->get('patients', 'Dashboard::patients');
    $routes->get('users', 'Dashboard::users');
    $routes->get('profile', 'Dashboard::profile');
});





// Migration DevTools routes (protected by secret key)
$routes->get('run-migration/(:any)', 'DevTools::migrate/$1');
$routes->get('run-rollback/(:any)', 'DevTools::rollback/$1');
$routes->get('run-reset/(:any)', 'DevTools::reset/$1');
$routes->get('run-status/(:any)', 'DevTools::status/$1');
$routes->get('run-drop-attendance/(:any)', 'DevTools::dropAttendance/$1');


$routes->set404Override(function () {
    $controller = new \App\Controllers\ErrorController();
    return $controller->show404();
});