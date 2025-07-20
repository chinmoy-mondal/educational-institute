<?php

namespace App\Controllers;

use App\Models\StudentModel;
use App\Models\UserModel;
use CodeIgniter\Controller;
use App\Models\CalendarModel;
use App\Models\SubjectModel;
use App\Models\ResultModel;

class Dashboard extends Controller
{
	protected $userModel;
	protected $subjectModel;
	protected $studentModel;
	protected $session;
	protected $data;

	public function __construct()
	{
		$this->userModel     = new UserModel();
		$this->subjectModel  = new SubjectModel();
		$this->studentModel  = new StudentModel();
		$this->session       = session();
		$this->data          = [];

		if (!$this->session->get('isLoggedIn')) {
			redirect()->to(base_url('login'))->send();
			exit;
		}

		$this->data['navbarItems'] = [
			['label' => 'Dashboard', 'url' => base_url('dashboard')],
			['label' => 'Calendar', 'url' => base_url('calendar')],
			['label' => 'Result', 'url' => base_url('ad-result')],
			['label' => 'Accounts', 'url' => base_url('accounts')],
		];
			$this->data['sidebarItems'] = [
				[
					'label' => 'Dashboard', 
				'url' => base_url('dashboard'), 
				'icon' => 'fas fa-tachometer-alt', 
				'section' => 'dashboard'
				],
				[
					'label' => 'Teacher Management', 
				'url' => base_url('teacher_management'), 
				'icon' => 'fas fa-chalkboard-teacher', 
				'section' => 'teacher'
				],
				[
					'label' => 'Student Management', 
				'url' => base_url('ad-student'), 
				'icon' => 'fas fa-user-graduate', 
				'section' => 'student'
				],
				[
					'label' => 'Calendar', 
				'url' => base_url('calendar'), 
				'icon' => 'fas fa-calendar-alt', 
				'section' => 'calendar'
				],
				];
	}

	public function index()
	{
		$studentModel = new StudentModel();
		$userModel = new UserModel();

		// Dashboard specific values
		$this->data['title'] = 'Dashboard';
		$this->data['activeSection'] = 'dashboard';

		// Common navbar and sidebar for all views

		$this->data['navbarItems'] = [
			['label' => 'Dashboard', 'url' => base_url('dashboard')],
			['label' => 'Calendar', 'url' => base_url('calendar')],
			['label' => 'Result', 'url' => base_url('ad-result')],
			['label' => 'Accounts', 'url' => base_url('accounts')],
		];

			$this->data['total_students'] = $studentModel->countAll();
			$this->data['total_users'] = $userModel->where('account_status !=', 0)->countAllResults();
			$this->data['total_new_users'] = $userModel->where('account_status', 0)->countAllResults();

			$this->data['total_applications'] = 10;
			$this->data['total_exams'] = 5;
			$this->data['total_income'] = 150000.00;
			$this->data['total_cost'] = 42000.00;

			return view('dashboard/index', $this->data);
	}

	public function profile()
	{

		$this->data['title'] = 'Profile';
		$this->data['activeSection'] = 'dashboard';

		// Common navbar and sidebar for all views
		$this->data['navbarItems'] = [
			['label' => 'Dashboard', 'url' => base_url('dashboard')],
			['label' => 'Calendar', 'url' => base_url('calendar')],
			['label' => 'Result', 'url' => base_url('ad-result')],
			['label' => 'Accounts', 'url' => base_url('accounts')],
		];

			$user = [
				'name' => $this->session->get('name'),
				'email' => $this->session->get('email'),
				'phone' => $this->session->get('phone'),
				'role' => $this->session->get('role')
			];

			$this->data['title'] = 'Dashboard';
			$this->data['activeSection'] = 'dashboard';
			$this->data['user'] = $user;
			//echo '<pre>';
			//print_r($this->data);
			//exit;
			return view('dashboard/profile', $this->data);
	}

	public function calendar()
	{
		$this->data['title'] = 'Calendar';
		$this->data['activeSection'] = 'calendar';

		// Common navbar and sidebar for all views
		$this->data['navbarItems'] = [
			['label' => 'Dashboard', 'url' => base_url('dashboard')],
			['label' => 'Calendar', 'url' => base_url('calendar')],
		];

			$user = [
				'name' => $this->session->get('name'),
				'email' => $this->session->get('email'),
				'phone' => $this->session->get('phone'),
				'role' => $this->session->get('role')
			];

			$this->data['user'] = $user;
			//echo '<pre>';
			//print_r($this->data);
			return view('dashboard/calendar', $this->data);
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

		$this->data['title'] = 'Teacher Management';
		$this->data['activeSection'] = 'teacher';

		// Common navbar and sidebar for all views
		$this->data['navbarItems'] = [
			['label' => 'Dashboard', 'url' => base_url('dashboard')],
			['label' => 'Calendar', 'url' => base_url('calendar')],
		];

			$userModel = new UserModel();

			$newUsers = $userModel->where('account_status', 0)->findAll();
			$totalNewUsers = count($newUsers);

			$users = $userModel->where('account_status !=', 0)->findAll();
			$totalUsers = count($users);

			// Assign to $this->data
			$this->data['newUsers'] = $newUsers;
			$this->data['total_newUsers'] = $totalNewUsers;
			$this->data['users'] = $users;
			$this->data['total_users'] = $totalUsers;

			return view('dashboard/ad_teacher_list', $this->data);
	}

	public function newUser()
	{
		$newUsers = $this->userModel
			->where('account_status', 0)
			->findAll();

		$this->data['activeSection'] = 'teacher'; // for menu highlight
		$this->data['newUsers'] = $newUsers;
		$this->data['total_newUsers'] = count($newUsers);

		return view('dashboard/ad_new_user', $this->data);
	}

	public function user_permit($id)
	{
		$userModel = new UserModel();


		$permitBy = $session->get('user_id');

		$updated = $userModel->update($id,[
				'account_status' => 1,
				'permit_by'	=>$permitBy,
		]);

		if ($updated) {
			return redirect()->back()->with('success', 'User approved successfully.');
		} else {
			return redirect()->back()->with('error', 'Failed to approve user.');
		}
	}

	public function user_delete($id)
	{
		$session = session();
		if (!$session->get('isLoggedIn')) {
			return redirect()->to(base_url('login'));
		}
	}


	public function teacher_management()
	{
		$subjectModel = new SubjectModel();
		$userModel    = new UserModel();

		$subjects = $subjectModel->orderBy('id')->findAll();
		$users    = $userModel->where('account_status !=', 0)->findAll();

		// Use $this->data which already has navbarItems, sidebarItems
		$this->data['title'] = 'Teacher Management';
		$this->data['activeSection'] = 'teacher';
		$this->data['navbarItems'] = [
			['label' => 'Teacher List', 'url' => base_url('teacher_management')],
			['label' => 'Add Teacher', 'url' => base_url('add_teacher')],
			['label' => 'Assign Subject', 'url' => base_url('assign_subject')],
		];
			$this->data['users'] = $users;
			$this->data['subjects'] = $subjects;

			return view('dashboard/teacher_management', $this->data);
	}

	public function teacherSubUpdate()
	{



		$id         = $this->request->getPost('id');
		$name       = $this->request->getPost('name');
		$assign_sub = $this->request->getPost('assign_sub'); // e.g., "4,7,9"

		$userModel = new UserModel();

		$data = [
			'assagin_sub' => $assign_sub,  // store CSV in DB
		];

		$userModel->update($id, $data);

		return redirect()->back()->with('success', 'Teacher updated with new subjects!');
	}


	public function assignSubject($id)
	{
		$userModel    = new UserModel();
		$subjectModel = new SubjectModel();

		$user = $userModel->find($id);
		if (!$user) {
			return redirect()->back()->with('error', 'No records found.');
		}

		$subjectIds = array_filter(
				array_map('intval', explode(',', $user['assagin_sub'] ?? ''))
				);

		$subjects = [];
		if (!empty($subjectIds)) {
			$subjects = $subjectModel
				->whereIn('id', $subjectIds)
				->orderBy('class', 'ASC')
				->findAll();
		}

		// Use $this->data to avoid repeating common layout data
		$this->data['title']         = 'Assign Subject';
		$this->data['activeSection'] = 'teacher';
		$this->data['navbarItems']   = [
			['label' => 'Teacher List', 'url' => base_url('teacher_management')],
			['label' => 'Assign Subject', 'url' => base_url('assign_subject')],
		];
			$this->data['user']          = $user;
			$this->data['subjects']      = $subjects;

			return view('dashboard/assign_subject', $this->data);
	}

	public function student()
	{
		$studentModel = new StudentModel();

		// Get filter inputs
		$q       = $this->request->getGet('q');
		$class   = $this->request->getGet('class');
		$section = $this->request->getGet('section');

		// Build query
		$builder = $studentModel;
		if ($q) {
			$builder = $builder->groupStart()
				->like('student_name', $q)
				->orLike('roll', $q)
				->orLike('id', $q)
				->groupEnd();
		}
		if ($class) {
			$builder = $builder->where('class', $class);
		}
		if ($section) {
			$builder = $builder->where('section', $section);
		}

		$perPage  = 20;
		$students = $builder->orderBy('CAST(class as UNSIGNED) ASC')
			->paginate($perPage, 'bootstrap');

		$sections = $studentModel->select('section')->distinct()->orderBy('section')->findAll();

		$this->data['title']         = 'Student Management';
		$this->data['activeSection'] = 'student';
		$this->data['navbarItems']   = [
			['label' => 'Student List', 'url' => base_url('ad-student')],
			['label' => 'Add Student', 'url' => base_url('student_create')],
			['label' => 'Assagin Subject', 'url' => base_url('admin/stAssaginSubView')],
		];
			$this->data['students']      = $students;
			$this->data['pager']         = $studentModel->pager;
			$this->data['q']             = $q;
			$this->data['class']         = $class;
			$this->data['section']       = $section;
			$this->data['sections']      = $sections;

			return view('dashboard/student', $this->data);
	}

	public function stAssaginSubView()
	{
		$studentModel = new StudentModel();

		// Get filter inputs
		$q       = $this->request->getGet('q');
		$class   = $this->request->getGet('class');
		$section = $this->request->getGet('section');

		// Build query
		$builder = $studentModel;
		if ($q) {
			$builder = $builder->groupStart()
				->like('student_name', $q)
				->orLike('roll', $q)
				->orLike('id', $q)
				->groupEnd();
		}
		if ($class) {
			$builder = $builder->where('class', $class);
		}
		if ($section) {
			$builder = $builder->where('section', $section);
		}


		$students = $builder
		    ->orderBy('CAST(roll as UNSIGNED)', 'ASC')
		    ->orderBy('CAST(class as UNSIGNED)', 'ASC')
		    ->get()
		    ->getResultArray();

		$sections = $studentModel->select('section')->distinct()->orderBy('section')->findAll();

		$this->data['title']         = 'Student Subject Management';
		$this->data['activeSection'] = 'student';
		$this->data['navbarItems']   = [
			['label' => 'Student List', 'url' => base_url('ad-student')],
			['label' => 'Add Student', 'url' => base_url('student_create')],
			['label' => 'Assagin Subject', 'url' => base_url('admin/stAssaginSubView')],
		];
			$this->data['students']      = $students;
			$this->data['pager']         = $studentModel->pager;
			$this->data['q']             = $q;
			$this->data['class']         = $class;
			$this->data['section']       = $section;
			$this->data['sections']      = $sections;

			return view('dashboard/stSubAssaginment', $this->data);
	}

	public function result($userId, $subjectId)
	{

		$user    = $this->userModel->find($userId);
		$subject = $this->subjectModel->find($subjectId);

		if (!$user || !$subject) {
			$routes   = \Config\Services::routes();
			$override = $routes->get404Override();
			return is_callable($override) ? $override() : show_404();
		}

		$students = $this->studentModel
			->where('class', $subject['class'])
			->groupStart()
			->where('section', $subject['section'])   // exact match
			->orWhere('section', 'n/a')               // match all sections
			->orWhere('section', null)                // NULL-safe
			->orLike('section', $subject['section'])  // substring match
			->groupEnd()
			->orderBy('roll', 'ASC')
			->findAll();

		$this->data['title']         = 'Result Entry';
		$this->data['activeSection'] = 'result';
		$this->data['navbarItems']   = [
			['label' => 'Result Entry', 'url' => base_url('ad-result')],
			['label' => 'Result Sheet', 'url' => base_url('result_sheet')],
		];
			$this->data['user']     = $user;
			$this->data['subject']  = $subject;
			$this->data['students'] = $students;

			return view('dashboard/ad_result', $this->data);
	}

	public function submitResults()
	{		

		$resultModel = new ResultModel();

		$students  = $this->request->getPost('students');
		$exam      = $this->request->getPost('exam');
		$year      = $this->request->getPost('year');
		$subjectId = $this->request->getPost('subject_id');

		if (!$students || !$exam || !$year || !$subjectId) {
			return redirect()->back()->with('error', 'Missing data.');
		}

		foreach ($students as $student) {
			$total = isset($student['total']) ? (int) $student['total'] : 0;

			// Check if result already exists
			$existing = $resultModel->where('student_id', $student['id'])
				->where('subject_id', $subjectId)
				->where('exam', $exam)
				->where('year', $year)
				->first();

			$data = [
				'student_id' => $student['id'],
				'subject_id' => $subjectId,
				'exam'       => $exam,
				'year'       => $year,
				'total'      => $total,
				'updated_at' => date('Y-m-d H:i:s'),
			];

				if ($existing) {
					$resultModel->update($existing['id'], $data);
				} else {
					$data['created_at'] = date('Y-m-d H:i:s');
					$resultModel->insert($data);
				}
		}

		return redirect()->back()->with('message', 'Results submitted successfully.');
	}

	public function ResultCheck()
	{
		$resultModel   = new ResultModel();
		$studentModel  = new StudentModel();
		$subjectModel  = new SubjectModel();
		$userModel     = new UserModel();

		$user = $userModel -> find(1);
		echo '<pre>';
		print_r($user);
		echo '</pre>';
		// return view('dashboard/resultCheck', ['results' => $results]);
	}

	public function viewStudent($id)
	{
		$this->studentModel = new StudentModel();
		$student = $this->studentModel->find($id);

		if (!$student) {
			return redirect()->back()->with('error', 'No data found');
		}

		$this->data['title'] = 'Student Details';
		$this->data['activeSection'] = 'student';
		$this->data['navbarItems'] = [
			['label' => 'Student List', 'url' => base_url('ad-student')],
			['label' => 'Add Student', 'url' => base_url('student_create')],
			['label' => 'View Student', 'url' => current_url()],
		];
			$this->data['student'] = $student;

			return view('dashboard/student_view', $this->data);
	}

	public function editStudent($id)
	{

		$this->studentModel = new StudentModel();
		$student = $this->studentModel->find($id);

		if (!$student) {
			return redirect()->to('ad-student')->with('error', 'Student not found.');
		}

		$this->data['title'] = 'Edit Student';
		$this->data['activeSection'] = 'student';
		$this->data['navbarItems'] = [
			['label' => 'Student List', 'url' => base_url('ad-student')],
			['label' => 'Add Student', 'url' => base_url('student_create')],
			['label' => 'Edit Student', 'url' => current_url()],
		];
			$this->data['student'] = $student;

			return view('dashboard/student_edit', $this->data);
	}
	public function updateStudent($id)
	{
		$this->studentModel = new StudentModel();
		$student = $this->studentModel->find($id);

		if (!$student) {
			return redirect()->to('ad-student')->with('error', 'Student not found.');
		}

		$data = $this->request->getPost([
				'student_name', 'roll', 'class', 'section', 'esif', 'father_name',
				'mother_name', 'dob', 'gender', 'phone', 'birth_registration_number',
				'father_nid_number', 'mother_nid_number', 'religion', 'blood_group'
		]);

		$this->studentModel->update($id, $data);

		return redirect()->to('admin/students/view/' . $id)->with('message', 'Student updated successfully.');
	}
	public function editStudentPhoto($id)
	{
		$this->studentModel = new StudentModel();
		$student = $this->studentModel->find($id);

		if (!$student) {
			return redirect()->to('admin/students')->with('error', 'Student not found.');
		}

		$this->data = [
			'title' => 'Edit Photo',
			'activeSection' => 'student',
			'navbarItems' => [
				['label' => 'Student List', 'url' => base_url('ad-student')],
				['label' => 'Edit Photo', 'url' => current_url()],
			],
			'student' => $student
		];

			return view('dashboard/edit_photo', $this->data);
	}

	public function updateStudentPhoto($id)
	{
		$this->studentModel = new StudentModel();
		$student = $this->studentModel->find($id);

		if (!$student) {
			return redirect()->to('admin/students')->with('error', 'Student not found.');
		}

		$file = $this->request->getFile('student_pic');

		if ($file && $file->isValid() && !$file->hasMoved()) {
			$newName = $file->getRandomName();
			$file->move(FCPATH . 'uploads/students', $newName);

			// Delete old photo if it exists and is not default
			if (!empty($student['student_pic']) && file_exists(FCPATH . $student['student_pic'])) {
				unlink(FCPATH . $student['student_pic']);
			}

			// Update DB
			$this->studentModel->update($id, [
					'student_pic' => 'uploads/students/' . $newName,
			]);

			return redirect()->to('admin/students/view/' . $id)->with('message', 'Photo updated successfully.');
		}

		return redirect()->back()->with('error', 'Photo upload failed.');
	}
}
