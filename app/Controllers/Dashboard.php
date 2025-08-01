<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\UserModel;
use App\Models\StudentModel;
use App\Models\SubjectModel;
use App\Models\ResultModel;
use App\Models\CalendarModel;

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
		if (!$this->session->get('isLoggedIn')) {
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
		$religion = $this->request->getGet('religion');
		$religions = $studentModel
			->select('religion')
			->distinct()
			->where('religion IS NOT NULL')
			->orderBy('religion')
			->findAll();
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
		if ($religion) {
			if ($religion === '__NULL__') {
				$builder = $builder->where('religion IS NULL'); // ✅ Matches "Not Set"
			} else {
				$builder = $builder->where('religion', $religion);
			}
		}
		$perPage  = 20;
		$students = $builder
			->orderBy('CAST(class as UNSIGNED) ASC')
			->orderBy('CAST(roll as UNSIGNED) ASC')
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
			$this->data['religion']   = $religion;   
			$this->data['religions']  = $religions;  

			return view('dashboard/student', $this->data);
	}

	public function stAssaginSubView()
	{
		$studentModel = new StudentModel();
		$subjectModel = new SubjectModel();

		// Get filter inputs
		$q       = $this->request->getGet('q');
		$class   = $this->request->getGet('class');
		$section = $this->request->getGet('section');
		$religion = $this->request->getGet('religion'); 

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
		if ($religion) {
			$builder = $builder->where('religion', $religion);
		}

		$students = $builder
		    ->orderBy('CAST(class as UNSIGNED)', 'ASC')
		    ->orderBy('CAST(roll as UNSIGNED)', 'ASC')
		    ->get()
		    ->getResultArray();

		$sections = $studentModel->select('section')->distinct()->orderBy('section')->findAll();
		$religions = $studentModel->select('religion')->distinct()->where('religion IS NOT NULL')->orderBy('religion')->findAll();
		$subjectBuilder = $subjectModel;

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
			['label' => 'Student List', 'url' => base_url('ad-student')],
			['label' => 'Add Student', 'url' => base_url('student_create')],
			['label' => 'Assagin Subject', 'url' => base_url('admin/stAssaginSubView')],
		];
			$this->data['students']      = $students;
			$this->data['subjects']      = $subjects;
			$this->data['pager']         = $studentModel->pager;
			$this->data['q']             = $q;
			$this->data['class']         = $class;
			$this->data['section']       = $section;
			$this->data['sections']      = $sections;
			$this->data['religion']      = $religion;
			$this->data['religions']     = $religions;

			return view('dashboard/stSubAssaginment', $this->data);
	}

	public function assignStudentsSubjects(){
		$students = $this->request->getPost('left_select');
		$subjects = $this->request->getPost('right_select');

		if(!empty($students) && !empty($subjects)) {
			$subjectCodes = implode(',', $subjects);
			$studentModel = new StudentModel();

			foreach($students as $studentId) {
				$studentModel->update($studentId,['assign_sub' => $subjectCodes]);

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
			return is_callable($override) ? $override() : show_404();
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

	public function ResultCheck($userId,$subjectId)
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
		$studentModel = new StudentModel();
		$resultModel  = new ResultModel();

		// ✅ Distinct class list from students
		$classes = $studentModel->distinct()->select('class')->orderBy('class', 'ASC')->findAll();

		// ✅ Distinct sections
		$sections = $studentModel->distinct()->select('section')->orderBy('section', 'ASC')->findAll();

		// ✅ Distinct exam names and years from results
		$exams = $resultModel->distinct()->select('exam')->orderBy('exam', 'ASC')->findAll();
		$years = $resultModel->distinct()->select('year')->orderBy('year', 'DESC')->findAll();
		// Send to view
		$this->data['title']    = 'Select Tabulation Info';
		$this->data['activeSection'] = 'result';
		$this->data['navbarItems'] = [
			['label' => 'Student List', 'url' => base_url('ad-student')],
			['label' => 'Add Student', 'url' => base_url('student_create')],
			['label' => 'View Student', 'url' => current_url()],
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
			['label' => 'Result', 'url' =>  current_url()],
			['label' => 'Marksheet', 'url' => base_url('student_create')],
			['label' => 'Tablation Sheet', 'url' => base_url('admin/mark')],
		];


			$class   = $this->request->getPost('class');
			$section = $this->request->getPost('section');
			$exam    = $this->request->getPost('exam');
			$year    = $this->request->getPost('year');

			$studentModel = new StudentModel();
			$resultModel  = new ResultModel();
			$subjectModel = new SubjectModel();

			// Step 1: Get all students from class 6, section 'n/a'
			$students = $studentModel
				->where('class', $class)
				->like('section', $section)
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

			return view('dashboard/mark', $this->data);
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
