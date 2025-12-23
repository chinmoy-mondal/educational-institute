<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

# website page
$routes->get('/', 'Home::index');
$routes->get('home', 'Home::index');
$routes->get('home/welcome', 'Home::welcome');
$routes->get('home/history', 'Home::history');
$routes->get('home/mission', 'Home::mission');
$routes->get('home/staff', 'Home::staff');
$routes->get('user-id', 'Home::userProfile');
$routes->get('user', 'User::index');
$routes->get('print-admit-form', 'Home::admit_print_view');
$routes->post('print-admit', 'Home::printAdmit');
$routes->get('student', 'Home::student');
$routes->get('student_stat', 'Home::student_stat');
$routes->get('student-id', 'Home::studentById');
$routes->get('idcard/(:num)', 'Home::idCard/$1');
$routes->get('teacher_idcard/(:num)', 'Home::teacher_idcard/$1');
$routes->get('attendance', 'Home::attendance');
$routes->get('notice', 'Home::notice');

$routes->get('contain', 'Contain::index');
$routes->get('about', 'About::index');
$routes->get('exam', 'Home::exam');
$routes->get('result', 'Home::result');
$routes->get('courses', 'Home::courses');
$routes->get('contact', 'Home::contact');
$routes->get('apply', 'Home::apply');
$routes->get('subjects', 'Home::subjects');
$routes->get('attendanceStats', 'Home::attendanceStats');
$routes->get('course-details/(:num)', 'Home::courseDetails/$1');
$routes->get('activity-details/(:num)', 'Home::activityDetails/$1');




// Migration DevTools routes (protected by secret key)
$routes->get('run-migration/(:any)', 'DevTools::migrate/$1');
$routes->get('run-rollback/(:any)', 'DevTools::rollback/$1');
$routes->get('run-reset/(:any)', 'DevTools::reset/$1');
$routes->get('run-status/(:any)', 'DevTools::status/$1');
$routes->get('run-drop-attendance/(:any)', 'DevTools::dropAttendance/$1');

#$routes->get('run-seed/(:any)', 'DevTools::seed/$1');

$routes->get('page', 'Page::index');

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
$routes->get('dashboard', 'Dashboard::index');
$routes->get('profile', 'Dashboard::profile');
$routes->get('profile/edit/(:num)', 'Dashboard::edit_profile_view/$1');
$routes->post('admin/user/update/(:num)', 'Dashboard::update_user/$1');
$routes->get('profile_id/(:num)', 'Dashboard::profile_id/$1');
$routes->get('restrict/(:num)', 'Dashboard::restrict/$1');


$routes->get('calendar', 'Dashboard::calendar');
$routes->get('calendar/events', 'Dashboard::events');
$routes->post('calendar/add', 'Dashboard::addEvent');
$routes->post('calendar/update', 'Dashboard::updateEvent');
$routes->post('calendar/delete', 'Dashboard::deleteEvent');

$routes->get('ad_teacher_list', 'Dashboard::teachers');
$routes->get('mark_given_teacher_list', 'Dashboard::teachers_mark_given');
$routes->post('admin/updatePosition/(:num)', 'Dashboard::updatePosition/$1');
$routes->get('ad_new_user', 'Dashboard::newUser');
$routes->get('teacher_management', 'Dashboard::teacher_management');

$routes->post('sub-update', 'Dashboard::teacherSubUpdate');
$routes->get('assignSubject/(:num)', 'Dashboard::assignSubject/$1');
$routes->get('marking_open', 'Dashboard::marking_open');
$routes->post('marking_open/process', 'Dashboard::processMarkingOpen');


$routes->post('ad-result', 'Dashboard::result');
$routes->get('exam_name/(:num)/(:num)', 'Dashboard::exam_name/$1/$2');
$routes->get('admin/exam_name_result_check/(:num)/(:num)', 'Dashboard::exam_name_result_check/$1/$2');
$routes->post('admin/resultCheck', 'Dashboard::ResultCheck');
$routes->post('results/submit', 'Dashboard::submitResults');

$routes->get('admin/tabulation_form', 'Dashboard::selectTabulationForm');
$routes->post('admin/mark/', 'Dashboard::Mark');
$routes->get('admin/tabulation/download', 'Dashboard::downloadCSV');
$routes->get('admin/select-marksheet', 'Dashboard::selectMarksheetForm');
$routes->get('admin/show-marksheet', 'Dashboard::showMarksheet');


$routes->get('admin/test_reselt', 'Dashboard::test_result');



$routes->get('admin/student', 'Dashboard::student');
$routes->get('admin/deletedStudent', 'Dashboard::deleted_student');
$routes->get('admin/students/view/(:num)', 'Dashboard::viewStudent/$1');
$routes->get('admin/students/edit/(:num)', 'Dashboard::editStudent/$1');
$routes->post('admin/students/update/(:num)', 'Dashboard::updateStudent/$1');
$routes->get('admin/students/edit-photo/(:num)', 'Dashboard::editStudentPhoto/$1');
$routes->post('admin/students/edit-photo/(:num)', 'Dashboard::updateStudentPhoto/$1');
$routes->post('admin/students/forth/(:num)', 'Dashboard::forthsub/$1');
$routes->get('admin/stAssaginSubView', 'Dashboard::stAssaginSubView');
$routes->post('admin/assignStudentsSubjects', 'Dashboard::assignStudentsSubjects');

$routes->group('admin', function ($routes) {
    $routes->get('student/create', 'Dashboard::createStudentForm');
    $routes->post('students/save', 'Dashboard::saveStudent');
});

$routes->get('admin/students/delete/(:num)', 'Dashboard::softDelete/$1');
$routes->get('admin/students/active/(:num)', 'Dashboard::softActive/$1');
$routes->get('admin/students/harddelete/(:num)', 'Dashboard::hardDelete/$1');

$routes->get('admin/notices', 'Dashboard::notices');
$routes->get('admin/noticeForm', 'Dashboard::noticeForm');
$routes->post('admin/saveNotice', 'Dashboard::saveNotice');
$routes->get('admin/editNotice/(:num)', 'Dashboard::editNotice/$1');
$routes->get('admin/deleteNotice/(:num)', 'Dashboard::deleteNotice/$1');
$routes->post('admin/updateNotice/(:num)', 'Dashboard::updateNotice/$1');


// Transaction routes
$routes->get('admin/transactions', 'Dashboard::transactionDashboard');
$routes->get('admin/tec_pay', 'Dashboard::tec_pay');
$routes->post('admin/reset_amount/(:num)', 'Dashboard::reset_amount/$1');
$routes->get('admin/std_pay', 'Dashboard::std_pay');
$routes->get('admin/pay_stat', 'Dashboard::pay_stat');
$routes->get('admin/set_fees', 'Dashboard::set_fees');
$routes->post('admin/save_fees', 'Dashboard::save_fees');
$routes->get('admin/pay_student_request/(:num)', 'Dashboard::payStudentRequest/$1');
$routes->post('admin/submitStudentPayment', 'Dashboard::submitStudentPayment');
$routes->get('admin/studentPaymentHistory/(:num)', 'Dashboard::studentPaymentHistory/$1');



$routes->get('/user_permit/(:num)', 'Dashboard::user_permit/$1');
$routes->get('/user_delete/(:num)', 'Dashboard::user_delete/$1');
$routes->get('generate-id-cards', 'IdCardGenerator::generate');

$routes->get('public-calendar', 'PublicCalendar::index');
$routes->get('public-calendar/events', 'PublicCalendar::events');


$routes->match(['get', 'post'], 'admin/attendance/calendar', 'Dashboard::attendanceCalendar');
$routes->post('admin/attendance/save', 'Dashboard::saveAttendance');

$routes->get('admin/teacher-attendance', 'Dashboard::teacherAttendance');




$routes->get('drug', 'Health::drugs');
$routes->get('prescription', 'Health::prescription');
$routes->get('search-drugs', 'Health::searchDrugs');


$routes->set404Override(function () {
    $controller = new \App\Controllers\ErrorController();
    return $controller->show404();
});