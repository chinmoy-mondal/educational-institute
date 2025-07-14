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
	public function index()
	{
		$session = session();
		if (!$session->get('isLoggedIn')) {
			return redirect()->to(base_url('login'));
		}

		$studentModel = new StudentModel();
		$userModel = new UserModel();

		$total_students = $studentModel->countAll();
		$total_users = $userModel
			->where('account_status !=', 0)
			->countAllResults();

		$total_new_users = $userModel
			->where('account_status=', 0)
			->countAllResults();

		$total_applications = 10;
		$total_exams = 5;
		$total_income = 150000.00;
		$total_cost = 42000.00;


		return view('dashboard/index', [
				'title' => 'Admin Dashboard',
				'total_students' => $total_students,
				'total_users' => $total_users,
				'total_new_users' => $total_new_users,
				'total_applications' => $total_applications,
				'total_exams' => $total_exams,
				'total_income' => $total_income,
				'total_cost' => $total_cost
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
		$session = session();
		if (!$session->get('isLoggedIn')) {
			return redirect()->to(base_url('login'));
		}
		$userModel = new UserModel();

		$newUsers = $userModel
			->where('account_status=',0)
			->findAll();
		$totalNewUsers = count($newUsers);

		$users = $userModel
			->where('account_status !=',0)
			->findAll();
		$totalUsers = count($users);
		return view('dashboard/ad_teacher_list', [
				'title' => 'Admin Dashboard',
				'newUsers' => $newUsers,
				'total_newUsers' => $totalNewUsers,
				'users'=>$users,
				'total_users'=>$totalUsers
		]);

	}

	public function newUser()
	{
		$session = session();
		if (!$session->get('isLoggedIn')) {
			return redirect()->to(base_url('login'));
		}
		$userModel = new UserModel();

		$newUsers = $userModel
			->where('account_status=',0)
			->findAll();
		$totalNewUsers = count($newUsers);

		return view('dashboard/ad_new_user', [
				'title' => 'Admin Dashboard',
				'newUsers' => $newUsers,
				'total_newUsers' => $totalNewUsers
		]);

	}

	public function user_permit($id)
	{
		$userModel = new UserModel();

		$session = session();
		if (!$session->get('isLoggedIn')) {
			return redirect()->to(base_url('login'));
		}

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
		$session = session();
		if (!$session->get('isLoggedIn')) {
			return redirect()->to(base_url('login'));
		}

		$subjectModel = new SubjectModel();
		$userModel    = new UserModel();

		$subjects = $subjectModel->orderBy('id')->findAll(); // ✅ fixed line
		$users    = $userModel->where('account_status !=', 0)->findAll();

		return view('dashboard/teacher_management', [
				'title'    => 'Teacher Management',
				'users'    => $users,
				'subjects' => $subjects, // ✅ must match what your view expects
		]);
	}

	public function teacherSubUpdate()
	{
		$session = session();
		if (!$session->get('isLoggedIn')) {
			return redirect()->to(base_url('login'));
		}



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
		$session = session();
		if (!$session->get('isLoggedIn')) {
			return redirect()->to(base_url('login'));
		}


		$userModel = new UserModel();
		$subjectModel = new SubjectModel();

		$user = $userModel->find($id);


		if (!$user) {
			return redirect()->back()->with('error', 'no records founds');
		}

		$subjectIds = array_filter(
				array_map('intval', explode(',', $user['assagin_sub'] ?? ''))
				);

		$subjects = [];
		if ($subjectIds) {
			$subjects = $subjectModel
				->whereIn('id', $subjectIds)
				->orderBy('class ASC')
				->findAll();
		}
		return view('dashboard/assign_subject', [
				'user'     => $user,
				'subjects' => $subjects,
		]);



	}


	public function student()
	{

		$session = session();
		if (!$session->get('isLoggedIn')) {
			return redirect()->to(base_url('login'));
		}
		$studentModel = new StudentModel();

		// Get filter inputs
		$q = $this->request->getGet('q');
		$class = $this->request->getGet('class');
		$section = $this->request->getGet('section');

		// Build query with filters
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
		$perPage = 20;
		// Sort and paginate
		$students = $builder
			->orderBy('class ASC, roll ASC')
			->paginate($perPage, 'bootstrap');

		// For section dropdown
		$sections = $studentModel->select('section')
			->distinct()
			->orderBy('section')
			->findAll();

		// Load view
		return view('dashboard/student', [
				'students' => $students,
				'pager' => $studentModel->pager,
				'q' => $q,
				'class' => $class,
				'section' => $section,
				'sections' => $sections,
		]);
	}


	public function result($userId, $subjectId)
	{
		$userModel     = new UserModel();
		$subjectModel  = new SubjectModel();
		$studentModel  = new StudentModel();   // ⬅ new

		// ── Fetch teacher and subject ─────────────────────────────
		$user    = $userModel->find($userId);
		$subject = $subjectModel->find($subjectId);

		// custom 404 if either is missing
		if (!$user || !$subject) {
			$routes   = \Config\Services::routes();
			$override = $routes->get404Override();
			return is_callable($override) ? $override() : null;
		}

		// ── Pull students in the same class & section ─────────────
		$students = $studentModel
			->where('class', $subject['class'])
			->groupStart()                       // ( ... )
			->where('section', $subject['section'])   // exact match
			->orWhere('section', 'n/a')                 // empty string ⇒ “all sections”
			->orWhere('section', null)               // NULL safety (if you use NULLs)
			->orLike('section', $subject['section']) // partial / substring match
			->groupEnd()                        // )
			->orderBy('roll', 'ASC')
			->findAll();
		// ── Send everything to the view ───────────────────────────
		return view('dashboard/ad_result', [
				'user'     => $user,
				'subject'  => $subject,
				'students' => $students,
		]);
	}


	public function submitResults()
	{		
		$session = session();
		if (!$session->get('isLoggedIn')) {
			return redirect()->to(base_url('login'));
		}

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
		$session = session();
		if (!$session->get('isLoggedIn')) {
			return redirect()->to(base_url('login'));
		}
		$studentModel = new StudentModel();

		$student = $studentModel->find($id);

		if (!$student) {
			return redirect()->back()->with('error', 'No data found');
		}

		return view('dashboard/student_view', [
				'student' => $student
		]);
	}
	public function editStudent($id)
	{
		$model = new StudentModel();
		$student = $model->find($id);

		if (!$student) {
			return redirect()->to('ad-student')->with('error', 'Student not found.');
		}

		return view('dashboard/student_edit', ['student' => $student]);
	}

	public function updateStudent($id)
	{
		$model = new StudentModel();
		$student = $model->find($id);

		if (!$student) {
			return redirect()->to('ad-student')->with('error', 'Student not found.');
		}

		$data = $this->request->getPost([
				'student_name', 'roll', 'class', 'section', 'esif', 'father_name',
				'mother_name', 'dob', 'gender', 'phone', 'birth_registration_number',
				'father_nid_number', 'mother_nid_number', 'religion', 'blood_group'
		]);

		$model->update($id, $data);

		return redirect()->to('admin/students/view/' . $id)->with('message', 'Student updated successfully.');
	}

	public function editStudentPhoto($id)
	{
		$model = new StudentModel();
		$student = $model->find($id);

		if (!$student) {
			return redirect()->to('admin/students')->with('error', 'Student not found.');
		}

		return view('dashboard/edit_photo', ['student' => $student]);
	}


	function updateStudentPhoto($id)
	{
		$model = new StudentModel();
		$student = $model->find($id);

		if (!$student) {
			return redirect()->to('admin/students')->with('error', 'Student not found.');
		}

		$file = $this->request->getFile('student_pic');

		if ($file && $file->isValid() && !$file->hasMoved()) {
			$newName = $file->getRandomName();
			$file->move('uploads/students', $newName);

			// ✅ Delete old file (if not default and it exists)
			$oldPath = FCPATH . $student['student_pic'];

			if (!empty($student['student_pic']) && file_exists($oldPath)) {
				unlink($oldPath);
			}

			// ✅ Save new file path to DB
			$model->update($id, [
					'student_pic' => 'uploads/students/' . $newName,
			]);

			return redirect()->to('admin/students/view/' . $id)->with('message', 'Photo updated.');
		}

		return redirect()->back()->with('error', 'Photo upload failed.');
	}
}
