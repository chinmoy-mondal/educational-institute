<?php

namespace App\Controllers;

use App\Models\StudentModel;
use App\Models\UserModel;
use CodeIgniter\Controller;
use App\Models\CalendarModel;

class Dashboard extends Controller
{
    public function index()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $studentModel = new StudentModel();
        $userModel = new UserModel();

        $total_students = $studentModel->countAll();
        $total_teachers = $userModel->where('role', 'teacher')->countAllResults();

        $total_applications = 10;
        $total_exams = 5;
        $total_income = 150000.00;
        $total_cost = 42000.00;

        $students = $studentModel
            ->select('id, student_name, roll, class, phone')
            ->orderBy('id', 'DESC')
            ->findAll();

        return view('dashboard/index', [
            'title' => 'Admin Dashboard',
            'total_students' => $total_students,
            'total_teachers' => $total_teachers,
            'total_applications' => $total_applications,
            'total_exams' => $total_exams,
            'total_income' => $total_income,
            'total_cost' => $total_cost,
            'students' => $students
        ]);
    }

    public function profile()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $user = [
            'name' => $session->get('name'),
            'email' => $session->get('email'),
            'phone' => $session->get('phone'),
            'role' => $session->get('role')
        ];

        return view('dashboard/profile', ['user' => $user]);
    }
	public function calendar()
	{
	    $session = session();
	    if (!$session->get('isLoggedIn')) {
		return redirect()->to(base_url('login'));
	    }

	    $user = [
		'name' => $session->get('name'),
		'email' => $session->get('email'),
		'phone' => $session->get('phone'),
		'role' => $session->get('role')
	    ];

	    return view('dashboard/calendar', ['user' => $user]);
	}

	public function events()
	{

	    $model = new CalendarModel();
	    $events = $model->findAll();

	    $data = array_map(function ($event) {
		// Determine if end_date has time part (T separator)
		$hasTime = strpos($event['end_date'], 'T') !== false;

		// If end_date is date only, add +1 day to make FullCalendar inclusive
		$endDate = $hasTime
		    ? $event['end_date']
		    : date('Y-m-d', strtotime($event['end_date'] . ' +1 day'));

		return [
		    'id'          => $event['id'],
		    'title'       => $event['title'],
		    'start'       => $event['start_date'],
		    'end'         => $endDate,
		    'color'       => $event['color'],
		    'description' => $event['description'],
		    'allDay'      => true // important for date-only events
		];
	    }, $events);

	    return $this->response->setJSON($data);
	}

	public function addEvent()
	{
	    $model = new CalendarModel();
	    $model->save([
		'title' => $this->request->getPost('title'),
		'description' => $this->request->getPost('description'),
		'start_date' => $this->request->getPost('start'),
		'end_date' => $this->request->getPost('end'),
		'color' => $this->request->getPost('color') ?? '#007bff'
	    ]);

	    return $this->response->setJSON(['status' => 'success']);
	}

	public function updateEvent()
	{
	    $model = new CalendarModel();

	    $model->update($this->request->getPost('id'), [
		'title'       => $this->request->getPost('title'),
		'description' => $this->request->getPost('description'),
		'start_date'  => $this->request->getPost('start'),
		'end_date'    => $this->request->getPost('end'),
		'color'       => $this->request->getPost('color')
	    ]);

	    return $this->response->setJSON(['status' => 'success']);
	}

	public function deleteEvent()
	{
	    $model = new CalendarModel();
	    $model->delete($this->request->getPost('id'));

	    return $this->response->setJSON(['status' => 'success']);
	}

	public function teachers()
	{
	    $teacherModel = new UserModel();
	    $teachers = $teacherModel->findAll();

	    $session = session();
	    if (!$session->get('isLoggedIn')) {
		return redirect()->to(base_url('login'));
	    }

	    $user = [
		'name' => $session->get('name'),
		'email' => $session->get('email'),
		'phone' => $session->get('phone'),
		'role' => $session->get('role')
	    ];
	    return view('dashboard/ad_teacher_list', ['teachers' => $teachers]);
	}

	public function result()
	{
	    $studentModel = new StudentModel();

	    $session = session();
	    if (!$session->get('isLoggedIn')) {
		return redirect()->to(base_url('login'));
	    }
	    $students = $studentModel	->orderBy('roll', 'ASC')
					->where('class',10)
					->findAll();

	    return view('dashboard/ad_result', ['students' => $students]);
	}
}
