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
$routes->get('/student', 'Home::student');
$routes->get('/idcard/(:num)', 'Home::idCard/$1');

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

$routes->group('admin', function ($routes) {
    $routes->get('student/create', 'Dashboard::createStudentForm');
    $routes->post('students/save', 'Dashboard::saveStudent');
});


$routes->get('run-migration/(:any)', 'DevTools::migrate/$1');
#$routes->get('run-seed/(:any)', 'DevTools::seed/$1');

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
$routes->get('/teacher_management', 'Dashboard::teacher_management');

$routes->post('/sub-update', 'Dashboard::teacherSubUpdate');
$routes->get('/assignSubject/(:num)', 'Dashboard::assignSubject/$1');

$routes->get('/ad-result/(:num)/(:num)', 'Dashboard::result/$1/$2');
$routes->get('/admin/resultCheck/(:num)/(:num)', 'Dashboard::ResultCheck/$1/$2');
$routes->post('/results/submit', 'Dashboard::submitResults');

$routes->get('/admin/tabulation_form', 'Dashboard::selectTabulationForm');
$routes->post('/admin/mark/', 'Dashboard::Mark');
$routes->get('admin/tabulation/download', 'Dashboard::downloadCSV');
$routes->get('admin/select-marksheet', 'Dashboard::selectMarksheetForm');
$routes->get('admin/show-marksheet', 'Dashboard::showMarksheet');

$routes->get('admin/student', 'Dashboard::student');
$routes->get('admin/students/view/(:num)', 'Dashboard::viewStudent/$1');
$routes->get('admin/students/edit/(:num)', 'Dashboard::editStudent/$1');
$routes->post('admin/students/update/(:num)', 'Dashboard::updateStudent/$1');
$routes->get('admin/students/edit-photo/(:num)', 'Dashboard::editStudentPhoto/$1');
$routes->post('admin/students/edit-photo/(:num)', 'Dashboard::updateStudentPhoto/$1');
$routes->post('admin/students/forth/(:num)', 'Dashboard::forthsub/$1');
$routes->get('admin/stAssaginSubView', 'Dashboard::stAssaginSubView');
$routes->post('admin/assignStudentsSubjects', 'Dashboard::assignStudentsSubjects');


$routes->get('/user_permit/(:num)', 'Dashboard::user_permit/$1');
$routes->get('/user_delete/(:num)', 'Dashboard::user_delete/$1');
$routes->get('generate-id-cards', 'IdCardGenerator::generate');

$routes->get('public-calendar', 'PublicCalendar::index');
$routes->get('public-calendar/events', 'PublicCalendar::events');


$routes->set404Override(function () {
    $controller = new \App\Controllers\ErrorController();
    return $controller->show404();
});
