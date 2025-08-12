<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\UserModel;
use App\Models\StudentModel;
use App\Models\SubjectModel;
use App\Models\ResultModel;
use App\Models\CalendarModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Dashboard extends Controller
{
	protected $userModel;
	protected $subjectModel;
	protected $studentModel;
	protected $resultModel;
	protected $calendarModel;
	protected $session;
	protected $data;

	public function __construct()
	{
		$this->userModel     = new UserModel();
		$this->subjectModel  = new SubjectModel();
		$this->studentModel  = new StudentModel();
		$this->resultModel   = new ResultModel();
		$this->calendarModel   = new CalendarModel();


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
				'url' => base_url('admin/student'),
				'icon' => 'fas fa-user-graduate',
				'section' => 'student'
			],
			[
				'label' => 'Calendar',
				'url' => base_url('calendar'),
				'icon' => 'fas fa-calendar-alt',
				'section' => 'calendar'
			],
			[
				'label' => 'Result',
				'url' => base_url('admin/tabulation_form'),
				'icon' => 'fas fa-chart-bar',
				'section' => 'result'
			],
		];
	}

	public function index()
	{

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
		$this->data['total_students'] = $this->studentModel->countAll();
		$this->data['total_users'] = $this->userModel->where('account_status !=', 0)->countAllResults();
		$this->data['total_new_users'] = $this->userModel->where('account_status', 0)->countAllResults();

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

		$this->data['navbarItems'] = [
			['label' => 'Dashboard', 'url' => base_url('dashboard')],
			['label' => 'Calendar', 'url' => base_url('calendar')],
			['label' => 'Result', 'url' => base_url('ad-result')],
			['label' => 'Accounts', 'url' => base_url('accounts')],
		];

		$userId = $this->session->get('user_id');
		// Load model and get teacher data
		$teacher = $this->userModel->find($userId);

		if (!$teacher) {
			// handle case where teacher not found
			throw new \CodeIgniter\Exceptions\PageNotFoundException("Teacher not found");
		}

		$this->data['user'] = $teacher;

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

		$events = $this->calendarModel->findAll();

		$data = array_map(function ($event) {
			$hasTime = strpos($event['end_date'], 'T') !== false;

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

		$this->calendarModel->save([
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


		$this->calendarModel->update($this->request->getPost('id'), [
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

		$this->calendarModel->delete($this->request->getPost('id'));

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



		$newUsers = $this->userModel->where('account_status', 0)->findAll();
		$totalNewUsers = count($newUsers);

		$users = $this->userModel->where('account_status !=', 0)->findAll();
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

		$this->data['title'] = 'Teacher Management';
		$this->data['activeSection'] = 'teacher';

		// Common navbar and sidebar for all views
		$this->data['navbarItems'] = [
			['label' => 'Dashboard', 'url' => base_url('dashboard')],
			['label' => 'Calendar', 'url' => base_url('calendar')],
			['label' => 'demo', 'url' => base_url('demo')],
		];
		$newUsers = $this->userModel
			->where('account_status', 0)
			->findAll();

		$this->data['newUse'] = $newUsers;
		$this->data['total_newUse'] = count($newUsers);
		return view('dashboard/ad_new_user', $this->data);
	}

	public function user_permit($id)
	{
		$userModel = new UserModel();


		$permitBy = $this->session->get('user_id');

		$updated = $this->userModel->update($id, [
			'account_status' => 1,
			'permit_by'	=> $permitBy,
		]);

		if ($updated) {
			return redirect()->back()->with('success', 'User approved successfully.');
		} else {
			return redirect()->back()->with('error', 'Failed to approve user.');
		}
	}

	public function user_delete($id)
	{
		if (!$this->session->get('isLoggedIn')) {
			return redirect()->to(base_url('login'));
		}
	}


	public function teacher_management()
	{


		$subjects = $this->subjectModel->orderBy('id')->findAll();
		$users    = $this->userModel->where('account_status !=', 0)->findAll();

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



		$data = [
			'assagin_sub' => $assign_sub,  // store CSV in DB
		];

		$this->userModel->update($id, $data);

		return redirect()->back()->with('success', 'Teacher updated with new subjects!');
	}


	public function assignSubject($id)
	{


		$user = $this->userModel->find($id);
		if (!$user) {
			return redirect()->back()->with('error', 'No records found.');
		}

		$subjectIds = array_filter(
			array_map('intval', explode(',', $user['assagin_sub'] ?? ''))
		);

		$subjects = [];
		if (!empty($subjectIds)) {
			$subjects = $this->subjectModel
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





	public function createStudentForm()
	{
		$this->data['title'] = 'Register Student';
		$this->data['activeSection'] = 'student';
		$this->data['navbarItems']   = [
			['label' => 'Student List', 'url' => base_url('admin/student')],
			['label' => 'Add Student', 'url' => base_url('admin/student/create')],
			['label' => 'Assagin Subject', 'url' => base_url('admin/stAssaginSubView')],
		];
		return view('dashboard/student_form', $this->data);
	}

	public function saveStudent()
	{
		helper(['form']);

		$rules = [
			'student_name' => 'required',
			'roll'         => 'required|numeric',
			'class'        => 'required',
			'section'      => 'permit_empty',
			'esif'         => 'required',
			'father_name'  => 'required',
			'mother_name'  => 'required',
			'dob'          => 'required|valid_date',
			'gender'       => 'required',
			'phone'        => 'required',
			'student_pic'  => 'uploaded[student_pic]|is_image[student_pic]',
			'birth_registration_number' => 'required',
			'father_nid_number'         => 'required',
			'mother_nid_number'         => 'required',
		];

		if (!$this->validate($rules)) {
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}

		// Handle student picture
		$file = $this->request->getFile('student_pic');

		if ($file && $file->isValid() && !$file->hasMoved()) {
			$fileName = $file->getRandomName();
			$file->move('uploads/students', $fileName);
		} else {
			return redirect()->back()->withInput()->with('errors', ['student_pic' => 'File upload failed.']);
		}

		// Prepare student data
		$data = [
			'student_name' => $this->request->getPost('student_name'),
			'roll'         => $this->request->getPost('roll'),
			'class'        => $this->request->getPost('class'),
			'section'      => $this->request->getPost('section'),
			'esif'         => $this->request->getPost('esif'),
			'father_name'  => $this->request->getPost('father_name'),
			'mother_name'  => $this->request->getPost('mother_name'),
			'dob'          => $this->request->getPost('dob'),
			'gender'       => $this->request->getPost('gender'),
			'phone'        => $this->request->getPost('phone'),
			'student_pic'  => $fileName,
			'birth_registration_number' => $this->request->getPost('birth_registration_number'),
			'father_nid_number'         => $this->request->getPost('father_nid_number'),
			'mother_nid_number'         => $this->request->getPost('mother_nid_number'),
		];

		// Save to DB
		$this->studentModel->insert($data);

		return redirect()->to(site_url('admin/students'))->with('success', 'Student registered successfully!');
	}

	public function student()
	{


		// Get filter inputs
		$q       = $this->request->getGet('q');
		$class   = $this->request->getGet('class');
		$section = $this->request->getGet('section');
		$religion = $this->request->getGet('religion');
		$religions = $this->studentModel
			->select('religion')
			->distinct()
			->where('religion IS NOT NULL')
			->orderBy('religion')
			->findAll();
		// Build query
		$builder = $this->studentModel;
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
		if ($religion) {
			if ($religion === '__NULL__') {
				$builder = $builder->where('religion IS NULL'); // ✅ Matches "Not Set"
			} else {
				$builder = $builder->where('religion', $religion);
			}
		}
		$total = $builder->countAllResults(false);
		$perPage  = 20;
		$students = $builder
			->orderBy('CAST(class as UNSIGNED) ASC')
			->orderBy('CAST(roll as UNSIGNED) ASC')
			->paginate($perPage, 'bootstrap');

		$sections = $this->studentModel->select('section')->distinct()->orderBy('section')->findAll();

		$this->data['title']         = 'Student Management';
		$this->data['activeSection'] = 'student';
		$this->data['navbarItems']   = [
			['label' => 'Student List', 'url' => base_url('admin/student')],
			['label' => 'Add Student', 'url' => base_url('admin/student/create')],
			['label' => 'Assagin Subject', 'url' => base_url('admin/stAssaginSubView')],
		];
		$this->data['students']      = $students;
		$this->data['pager']         = $this->studentModel->pager;
		$this->data['q']             = $q;
		$this->data['class']         = $class;
		$this->data['section']       = $section;
		$this->data['sections']      = $sections;
		$this->data['religion']   = $religion;
		$this->data['religions']  = $religions;
		$this->data['total']  = $total;



		return view('dashboard/student', $this->data);
	}

	public function stAssaginSubView()
	{


		// Get filter inputs
		$q       = $this->request->getGet('q');
		$class   = $this->request->getGet('class');
		$section = $this->request->getGet('section');
		$religion = $this->request->getGet('religion');

		// Build query
		$builder = $this->studentModel;
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
		if ($religion) {
			$builder = $builder->where('religion', $religion);
		}

		$students = $builder
			->orderBy('CAST(class as UNSIGNED)', 'ASC')
			->orderBy('CAST(roll as UNSIGNED)', 'ASC')
			->get()
			->getResultArray();

		$sections = $this->studentModel->select('section')->distinct()->orderBy('section')->findAll();
		$religions = $this->studentModel->select('religion')->distinct()->where('religion IS NOT NULL')->orderBy('religion')->findAll();
		$subjectBuilder = $this->subjectModel;

		if ($class) {
			$subjectBuilder = $subjectBuilder->where('class', $class);
		}

		if (stripos($section, 'Vocational') !== false) {
			$filteredSection = 'Vocational';
		} else {
			$filteredSection = 'General';
		}

		if ($filteredSection) {
			$subjectBuilder = $subjectBuilder->where('section', $filteredSection);
		}

		$subjects = $subjectBuilder->findAll();

		$this->data['title']         = 'Student Subject Management';
		$this->data['activeSection'] = 'student';
		$this->data['navbarItems']   = [
			['label' => 'Student List', 'url' => base_url('admin/student')],
			['label' => 'Add Student', 'url' => base_url('admin/student/create')],
			['label' => 'Assagin Subject', 'url' => base_url('admin/stAssaginSubView')],
		];
		$this->data['students']      = $students;
		$this->data['subjects']      = $subjects;
		$this->data['pager']         = $this->studentModel->pager;
		$this->data['q']             = $q;
		$this->data['class']         = $class;
		$this->data['section']       = $section;
		$this->data['sections']      = $sections;
		$this->data['religion']      = $religion;
		$this->data['religions']     = $religions;

		return view('dashboard/stSubAssaginment', $this->data);
	}

	public function assignStudentsSubjects()
	{
		$students = $this->request->getPost('left_select');
		$subjects = $this->request->getPost('right_select');

		if (!empty($students) && !empty($subjects)) {
			$subjectCodes = implode(',', $subjects);
			$studentModel = new StudentModel();

			foreach ($students as $studentId) {
				$studentModel->update($studentId, ['assign_sub' => $subjectCodes]);
			}
			return redirect()->back()->with('success', 'Subjects assigned successfully.');
		}
		return redirect()->back()->with('error', 'Please select at least one student and one subject.');
	}


	public function result($userId, $subjectId)
	{
		$user    = $this->userModel->find($userId);
		$subject = $this->subjectModel->find($subjectId);

		if (!$user || !$subject) {
			$routes   = \Config\Services::routes();
			$override = $routes->get404Override();
			return is_callable($override) ? $override() : throw PageNotFoundException::forPageNotFound();
		}

		$students = $this->studentModel
			->where("FIND_IN_SET(" . (int)$subjectId . ", assign_sub) >", 0, false)
			->orderBy('CAST(roll AS UNSIGNED)', 'ASC', false)
			->findAll();

		// 🔄 Load existing results for this teacher and subject
		$results = $this->resultModel
			->where('teacher_id', $userId)
			->where('subject_id', $subjectId)
			->where('year', date('Y')) // optional filter
			->findAll();

		// 🔃 Index results by student_id for quick lookup
		$indexedResults = [];
		foreach ($results as $r) {
			$indexedResults[$r['student_id']] = $r;
		}

		$this->data['title']           = 'Result Entry';
		$this->data['activeSection']   = 'teacher';
		$this->data['navbarItems']     = [
			['label' => 'Result Entry', 'url' => base_url('ad-result')],
			['label' => 'Result Sheet', 'url' => base_url('result_sheet')],
		];
		$this->data['user']            = $user;
		$this->data['subject']         = $subject;
		$this->data['students']        = $students;
		$this->data['existingResults'] = $indexedResults;

		return view('dashboard/ad_result', $this->data);
	}

	public function submitResults()
	{
		$students   = $this->request->getPost('students');
		$exam       = $this->request->getPost('exam');
		$year       = $this->request->getPost('year');
		$subjectId  = $this->request->getPost('subject_id');
		$teacherId  = $this->request->getPost('teacher_id');
		$class     = $this->request->getPost('class');

		if (!$students || !$exam || !$year || !$subjectId  || !$teacherId || !$class) {
			return redirect()->back()->with('error', 'Missing data.');
		}

		foreach ($students as $student) {
			$written   = isset($student['written']) ? (int)$student['written'] : 0;
			$mcq       = isset($student['mcq'])     ? (int)$student['mcq']     : 0;
			$practical = isset($student['practical']) ? (int)$student['practical'] : 0;
			$total     = $written + $mcq + $practical;

			$existing = $this->resultModel
				->where('student_id', $student['id'])
				->where('subject_id', $subjectId)
				->where('exam', $exam)
				->where('year', $year)
				->first();

			$data = [
				'student_id' => $student['id'],
				'subject_id' => $subjectId,
				'exam'       => $exam,
				'year'       => $year,
				'class'      => $class,
				'written'    => $written,
				'mcq'        => $mcq,
				'practical'  => $practical,
				'total'      => $total,
				'teacher_id' => $teacherId,
				'updated_at' => date('Y-m-d H:i:s'),
			];

			if ($existing) {
				$this->resultModel->update($existing['id'], $data);
			} else {
				$data['created_at'] = date('Y-m-d H:i:s');
				$this->resultModel->insert($data);
			}
		}

		return redirect()->back()->with('message', 'Results submitted successfully.');
	}

	public function ResultCheck($userId, $subjectId)
	{

		$subject = $this->subjectModel->find($subjectId);

		$users	= $this->userModel->find($userId);

		$result = $this->resultModel
			->select('results.*, students.student_name, students.roll, students.class')
			->join('students', 'students.id = results.student_id')
			->where('results.subject_id', $subjectId)
			->where('results.teacher_id', $userId)
			->orderBy('CAST(students.roll AS UNSIGNED)', 'ASC', false)
			->findAll();


		$this->data['title'] = 'Student Details';
		$this->data['activeSection'] = 'teacher';
		$this->data['navbarItems'] = [
			['label' => 'Student List', 'url' => base_url('ad-student')],
			['label' => 'Add Student', 'url' => base_url('student_create')],
			['label' => 'View Student', 'url' => current_url()],
		];
		$this->data['subject'] = $subject;
		$this->data['users'] = $users;
		$this->data['result'] = $result;

		return view('dashboard/resultCheck', $this->data);
	}

	public function selectTabulationForm()
	{


		// ✅ Distinct class list from students
		$classes = $this->studentModel->distinct()->select('class')->orderBy('class', 'ASC')->findAll();

		$rawSections = $this->studentModel
			->distinct()
			->select('section')
			->orderBy('section', 'ASC')
			->findAll();

		$sections = [
			['section' => 'General'],
			['section' => 'Vocational'],
			['section' => 'Science'],
			['section' => 'arts'],
		];


		// ✅ Distinct exam names and years from results
		$exams = $this->resultModel->distinct()->select('exam')->orderBy('exam', 'ASC')->findAll();
		$years = $this->resultModel->distinct()->select('year')->orderBy('year', 'DESC')->findAll();
		// Send to view
		$this->data['title']    = 'Select Tabulation Info';
		$this->data['activeSection'] = 'result';
		$this->data['navbarItems'] = [
			['label' => 'Tabulation Sheet', 'url' => base_url('admin/tabulation_form')],
			['label' => 'Marksheet', 'url' => base_url('admin/select-marksheet')],
		];
		$this->data['classes']  = $classes;
		$this->data['sections'] = $sections;
		$this->data['exams']    = $exams;
		$this->data['years']    = $years;

		return view('dashboard/select_exam_info', $this->data);
	}

	public function mark()
	{
		// Pass data to the view
		$this->data['title']     = 'Tabulation Sheet';
		$this->data['activeSection'] = 'result';
		$this->data['navbarItems'] = [
			['label' => 'Tabulation Sheet', 'url' => base_url('admin/tabulation_form')],
			['label' => 'Marksheet', 'url' => base_url('admin/select-marksheet')],
			['label' => 'Marksheet', 'url' => base_url('admin/tabulation/download')],
		];


		$class   = $this->request->getPost('class');
		$section = $this->request->getPost('section');
		$exam    = $this->request->getPost('exam');
		$year    = $this->request->getPost('year');

		$studentModel = new StudentModel();
		$resultModel  = new ResultModel();
		$subjectModel = new SubjectModel();

		$builder = $this->studentModel->where('class', $class);

		// If class is NOT 6 to 8, add section filter
		if (!in_array($class, ['6', '7', '8'])) {
			$builder->like('section', $section);
		}

		$students = $builder
			->orderBy('CAST(roll AS UNSIGNED)', 'ASC', false)
			->findAll();

		$finalData = [];

		foreach ($students as $student) {
			$studentId = $student['id'];

			// Step 2: Get results for this student, exam, and year
			$results = $resultModel
				->where('student_id', $studentId)
				->where('exam', $exam)
				->where('year', $year)
				->findAll();

			// Step 3: Build subject-wise results array
			$subjectResults = [];
			foreach ($results as $res) {
				$subjectName = $subjectModel
					->select('subject')
					->where('id', $res['subject_id'])
					->first()['subject'] ?? 'Unknown';

				$subjectResults[] = [
					'subject_id' => $res['subject_id'],
					'subject'   => $subjectName,
					'written'   => $res['written'] ?? 0,
					'mcq'       => $res['mcq'] ?? 0,
					'practical' => $res['practical'] ?? 0,
					'total'     => $res['total'] ?? 0,
				];
			}

			usort($subjectResults, function ($a, $b) {
				return $a['subject_id'] <=> $b['subject_id'];
			});

			// Step 4: Append student data with their results
			$finalData[] = [
				'student_id' => $student['id'],
				'name'       => $student['student_name'] ?? 'Unknown',
				'roll'       => $student['roll'],
				'exam'       => $exam,
				'year'       => $year,
				'results'    => $subjectResults,
			];
		}
		$this->data['finalData'] = $finalData;
		$this->data['class']     = $class;
		$this->data['exam']      = $exam;
		$this->data['year']      = $year;
		// echo '<pre>';
		// print_r($finalData);
		// echo '</pre>';
		return view('dashboard/mark', $this->data);
	}
	private function getTabulationData(): array
	{
		// Use your actual data fetching logic here
		$class = $this->request->getGet('class') ?? '9';
		$exam  = $this->request->getGet('exam') ?? 'Half Yearly';
		$year  = $this->request->getGet('year') ?? date('Y');

		$studentModel = new \App\Models\StudentModel();
		$resultModel = new \App\Models\ResultModel();

		$students = $studentModel
			->select('id, roll, student_name') // include 'name' here
			->where('class', $class)
			->orderBy('CAST(roll AS UNSIGNED)', 'ASC', false)
			->findAll();

		$finalData = [];

		foreach ($students as $student) {
			$results = $resultModel
				->where('student_id', $student['id'])
				->where('exam', $exam)
				->where('year', $year)
				->findAll();

			$finalData[] = [
				'roll' => $student['roll'],
				'name' => $student['student_name'],
				'results' => $results
			];
		}

		return $finalData;
	}
	public function downloadCSV()
	{
		helper('text');

		// Example: load your finalData array from your model or session
		$finalData = $this->getTabulationData(); // <-- Replace with actual data fetch logic
		$subjectList = [];

		// Get unique subject names
		foreach ($finalData as $student) {
			foreach ($student['results'] as $res) {
				if (!in_array($res['subject'], $subjectList)) {
					$subjectList[] = $res['subject'];
				}
			}
		}

		// Set CSV headers
		$headers = ['Roll', 'Name'];
		foreach ($subjectList as $subject) {
			$headers[] = "$subject - W";
			$headers[] = "$subject - MCQ";
			$headers[] = "$subject - Prac";
			$headers[] = "$subject - Total";
		}
		$headers[] = 'Total Marks';

		// Set headers for CSV download
		$filename = 'tabulation_sheet_' . date('Ymd_His') . '.csv';

		// Start streaming the CSV
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename=$filename");
		header("Content-Type: application/csv");

		$file = fopen('php://output', 'w');

		// Write header row
		fputcsv($file, $headers);

		// Write each student's result row
		foreach ($finalData as $student) {
			$row = [];
			$row[] = $student['roll'];
			$row[] = $student['name'];

			$subjectMap = [];
			foreach ($student['results'] as $res) {
				$subjectMap[$res['subject']] = $res;
			}

			$totalMarks = 0;

			foreach ($subjectList as $subject) {
				$written = $subjectMap[$subject]['written'] ?? '';
				$mcq = $subjectMap[$subject]['mcq'] ?? '';
				$practical = $subjectMap[$subject]['practical'] ?? '';
				$total = $subjectMap[$subject]['total'] ?? '';

				$row[] = $written;
				$row[] = $mcq;
				$row[] = $practical;
				$row[] = $total;

				if (is_numeric($total)) {
					$totalMarks += $total;
				}
			}

			$row[] = $totalMarks;

			fputcsv($file, $row);
		}

		fclose($file);
		exit;
	}

	public function selectMarksheetForm()
	{

		$classes = $this->studentModel->distinct()->select('class')->orderBy('class', 'ASC')->findAll();
		$sections = [
			['section' => 'general'],
			['section' => 'vocational'],
		];
		$exams = $this->resultModel->distinct()->select('exam')->orderBy('exam', 'ASC')->findAll();
		$years = $this->resultModel->distinct()->select('year')->orderBy('year', 'DESC')->findAll();

		$this->data['title']         = 'Select Marksheet Info';
		$this->data['activeSection'] = 'result';
		$this->data['navbarItems'] = [
			['label' => 'Tabulation Sheet', 'url' => base_url('admin/tabulation_form')],
			['label' => 'Marksheet', 'url' => base_url('admin/select-marksheet')],
		];
		$this->data['classes']       = $classes;
		$this->data['sections']      = $sections;
		$this->data['exams']         = $exams;
		$this->data['years']         = $years;

		return view('dashboard/select_marksheet_info', $this->data);
	}

	public function showMarksheet()
	{
		$this->data['title'] = 'Marksheet';
		$this->data['activeSection'] = 'result';
		$this->data['navbarItems'] = [
			['label' => 'Tabulation Sheet', 'url' => base_url('admin/tabulation_form')],
			['label' => 'Marksheet', 'url' => base_url('admin/select-marksheet')],
		];

		$request = service('request');
		$searchType = $request->getGet('search_type');

		if ($searchType === 'id') {
			$studentId = $request->getGet('student_id');
			$exam      = $request->getGet('exam');
			$year      = $request->getGet('year');

			if (!$studentId) {
				return redirect()->back()->with('error', 'Please enter a Student ID.');
			}

			$student = $this->studentModel->find($studentId);

			if (!$student) {
				return redirect()->back()->with('error', 'Student not found.');
			}

			// Fetch results with subject name
			$marksheet = $this->resultModel
				->select('results.*, subjects.subject, subjects.full_mark')
				->join('subjects', 'subjects.id = results.subject_id')
				->where([
					'results.student_id' => $studentId,
					'results.exam'       => $exam,
					'results.year'       => $year,
				])
				->findAll();

			// Sort based on assigned subjects
			$assigned = explode(',', $student['assign_sub'] ?? '');
			$orderMap = array_flip($assigned);

			usort($marksheet, function ($a, $b) use ($orderMap) {
				$posA = $orderMap[$a['subject_id']] ?? PHP_INT_MAX;
				$posB = $orderMap[$b['subject_id']] ?? PHP_INT_MAX;
				return $posA <=> $posB;
			});

			$this->data['examName'] = $exam;
			$this->data['examYear'] = $year;
			$this->data['student'] = $student;
			$this->data['marksheet'] = $marksheet;

			return view('dashboard/marksheet_view', $this->data);
		} elseif ($searchType === 'roll') {
			$class   = $request->getGet('class');
			$section = $request->getGet('section');
			$roll    = $request->getGet('roll');
			$exam    = $request->getGet('exam');
			$year    = $request->getGet('year');

			if (!$class || !$section || !$roll || !$exam || !$year) {
				return redirect()->back()->with('error', 'Please fill in all fields.');
			}

			$builder = $this->studentModel
				->where('class', $class)
				->where('roll', $roll);

			if ($section === 'vocational') {
				$builder->like('section', 'vocational');
			} else {
				$builder->groupStart()
					->like('section', 'n/a')
					->orLike('section', 'general')
					->groupEnd();
			}

			$student = $builder->first();

			if (!$student) {
				return redirect()->back()->with('error', 'Student not found for given Class/Roll.');
			}

			// Fetch marksheet with subject join
			$marksheet = $this->resultModel
				->select('results.*, subjects.subject, subjects.full_mark')
				->join('subjects', 'subjects.id = results.subject_id')
				->where([
					'results.student_id' => $student['id'],
					'results.exam'       => $exam,
					'results.year'       => $year,
				])
				->findAll();

			// Sort by assigned subjects
			$assignRaw = explode(',', $student['assign_sub']);
			$starredId = null;
			$ordered = [];

			// Separate normal and starred
			foreach ($assignRaw as $id) {
				if (str_ends_with($id, '*')) {
					$starredId = rtrim($id, '*');
				} else {
					$ordered[] = $id;
				}
			}

			usort($marksheet, function ($a, $b) use ($ordered, $starredId) {
				// If either subject is the starred one
				if ($a['subject_id'] == $starredId) return 1;
				if ($b['subject_id'] == $starredId) return -1;

				// Compare position in ordered list
				$posA = array_search($a['subject_id'], $ordered);
				$posB = array_search($b['subject_id'], $ordered);
				return $posA <=> $posB;
			});

			$this->data['examName'] = $exam;
			$this->data['examYear'] = $year;
			$this->data['student'] = $student;
			$this->data['marksheet'] = $marksheet;
			// echo '<pre>';
			// print_r($marksheet);
			// echo '</pre>';

			return view('dashboard/marksheet_view', $this->data);
		}

		return redirect()->back()->with('error', 'Invalid search method.');
	}

	public function viewStudent($id)
	{
		$this->studentModel = new StudentModel();
		$this->subjectModel = new SubjectModel();

		$student = $this->studentModel->find($id);

		if (!$student) {
			return redirect()->back()->with('error', 'No data found');
		}

		// ✅ Step 1: Parse subject IDs and extract 4th subject
		$subject_str_id = $student['assign_sub'];
		$rawIds = explode(',', $subject_str_id); // e.g. ['12', '13', '14*', '15']

		$subjectIds = [];
		$fourthSubjectId = null;

		foreach ($rawIds as $idEntry) {
			if (str_contains($idEntry, '*')) {
				$fourthSubjectId = str_replace('*', '', $idEntry);
				$subjectIds[] = $fourthSubjectId;
			} else {
				$subjectIds[] = $idEntry;
			}
		}

		$subjects = $this->subjectModel
			->whereIn('id', $subjectIds)
			->findAll();

		$fourthSubjectName = null;
		if ($fourthSubjectId) {
			$fourth = $this->subjectModel->find($fourthSubjectId);
			if ($fourth) {
				$fourthSubjectName = $fourth['subject'];
			}
		}

		// ✅ Step 4: Pass to view
		$this->data['title'] = 'Student Details';
		$this->data['activeSection'] = 'student';
		$this->data['navbarItems'] = [
			['label' => 'Student List', 'url' => base_url('ad-student')],
			['label' => 'Add Student', 'url' => base_url('student_create')],
			['label' => 'View Student', 'url' => current_url()],
		];
		$this->data['student'] = $student;
		$this->data['subjectsStr'] = $subject_str_id;
		$this->data['subjects'] = $subjects;
		$this->data['forthSubject'] = $fourthSubjectName;

		return view('dashboard/student_view', $this->data);
	}

	public function forthsub($id)
	{
		$subjectId = $this->request->getPost('subject_id');

		$subjectId = str_replace('*', '', $subjectId);

		$selectId  = $this->request->getPost('selectid');
		$className = $this->request->getPost('subject_class');



		if (in_array($className, [6, 7, 8])) {
			return redirect()->back()->with('error', 'Sorry Class 6, 7, 8 does not have 4th subject.');
		}
		if (!$selectId) {
			return redirect()->back()->with('error', 'Sir, No subject is selected.');
		} else {
			$subject = $this->subjectModel->find($selectId);
			$subjectNames = array_map('trim', explode(',', $subject['subject']));
			$subjectText = implode(', ', $subjectNames);
			$subjectText = preg_replace('/\s+/', ' ', $subjectText);
		}
		
		if ($subjectText == 'Agriculture Studies') {

			return redirect()->back()->with('error', 'yes');
		} else {

			return redirect()->back()->with('error', 'No');
		}

		if (!in_array($subjectText, ['Higher Mathematics', 'Biology', 'Agriculture Studies', 'Agriculture Studies-1', 'Agriculture Studies-2'])) {
			return redirect()->back()->with('error', 'Sorry sir, (' . $subjectText . ') is not a 4th subject.');
		} else {
			$replace = $selectId . "*";
			$updated = str_replace($selectId, $replace, $subjectId);

			$updatedResult = $this->studentModel->update($id, [
				'assign_sub' => $updated,
			]);

			if ($updatedResult) {
				return redirect()->back()->with('success', $subjectText . ' is selected as 4th subject updated successfully to ID ' . $id);
			} else {
				$dbError = $this->studentModel->db->error();
				$errorMsg = $dbError['message'] ?? 'Unknown error occurred.';

				return redirect()->back()->with('error', 'Update failed: ' . $errorMsg);
			}
		}
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
			'student_name',
			'roll',
			'class',
			'section',
			'esif',
			'father_name',
			'mother_name',
			'dob',
			'gender',
			'phone',
			'birth_registration_number',
			'father_nid_number',
			'mother_nid_number',
			'religion',
			'blood_group'
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
