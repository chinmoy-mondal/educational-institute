<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

# website page
$routes->get('/', 'Home::index');
$routes->get('/home', 'Home::index');
$routes->get('/home/welcome', 'Home::welcome');
$routes->get('/home/history', 'Home::history');
$routes->get('/home/mission', 'Home::mission');
$routes->get('/home/staff', 'Home::staff');
$routes->get('/user', 'User::index');
$routes->get('/print-admit/(:num)', 'AdmitCard::index/$1');
$routes->get('/print-admit', 'AdmitCard::index');

$routes->get('/contain', 'Contain::index');
$routes->get('/about', 'About::index');
$routes->get('/exam', 'Home::exam');
$routes->get('/result', 'Home::result');
$routes->get('/courses', 'Home::courses');
$routes->get('/contact', 'Home::contact');
$routes->get('/apply', 'Home::apply');
$routes->get('/subjects', 'Home::subjects');
$routes->get('/course-details/(:num)', 'Home::courseDetails/$1');
$routes->get('/activity-details/(:num)', 'Home::activityDetails/$1');

$routes->get('/student', 'Student::index');
$routes->post('/student/save', 'Student::save');
$routes->get('/student/list', 'Student::list');

$routes->get('/student/edit/(:num)', 'Student::edit/$1');
$routes->post('/student/update/(:num)', 'Student::update/$1');
$routes->post('/student/delete/(:num)', 'Student::delete/$1');

$routes->get('run-migration/(:any)', 'DevTools::migrate/$1');
$routes->get('run-seed/(:any)', 'DevTools::seed/$1');

$routes->get('/page', 'Page::index');

$routes->get('register', 'Account::showRegisterForm');
$routes->post('register', 'Account::processRegister');

$routes->get('login', 'Account::showLoginForm');
$routes->post('login', 'Account::processLogin');
$routes->get('logout', 'Account::logout');

#Dashboard
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/profile', 'Dashboard::profile');
$routes->get('/calendar', 'Dashboard::calendar');
$routes->get('/calendar/events', 'Dashboard::events');
$routes->post('/calendar/add', 'Dashboard::addEvent');
$routes->post('/calendar/update', 'Dashboard::updateEvent');
$routes->post('/calendar/delete', 'Dashboard::deleteEvent');
$routes->get('/ad_teacher_list', 'Dashboard::teachers');
$routes->get('/ad_new_user', 'Dashboard::newUser');
$routes->get('/ad-result', 'Dashboard::result');

$routes->get('/user_permit/(:num)', 'Dashboard::user_permit/$1');
$routes->get('/user_delete/(:num)', 'Dashboard::user_delete/$1');


$routes->get('public-calendar', 'PublicCalendar::index');
$routes->get('public-calendar/events', 'PublicCalendar::events');


$routes->set404Override(function () {
    $controller = new \App\Controllers\ErrorController();
    return $controller->show404();
});
