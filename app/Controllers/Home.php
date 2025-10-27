<?php

namespace App\Controllers;

use App\Models\SubjectModel;
use App\Models\StudentModel;
use App\Models\UserModel;
use App\Models\CalendarModel;
use App\Models\AttendanceModel;
use App\Models\NoticeModel;

class Home extends BaseController
{
	public function index()
	{
		return view('public/home');
	}

	public function welcome()
	{
		return view('public/welcome');
	}
	public function history()
	{
		return view('public/history');
	}

	public function mission()
	{
		return view('public/mission');
	}

	public function staff()
	{
		$userModel = new UserModel();

		$faculty = $userModel
			->where('account_status !=', 0)
			->orderBy('position', 'ASC')
			->findAll();
		return view('public/staff', ['faculty' => $faculty]);
	}

	public function userProfile()
	{
		$id = $this->request->getGet('q'); // read ?q=7
		$userModel = new UserModel();

		$user = $userModel
			->where('id', $id)
			->where('account_status !=', 0)
			->first();

		if (!$user) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("User not found");
		}
		// echo "<pre>";
		// print_r($user);
		return view('public/user_profile', ['user' => $user]);
	}

	public function subjects()
	{
		$model = new SubjectModel();  // ✅ Correct instantiation

		$subjects = $model
			->orderBy('CAST(class AS UNSIGNED)', 'ASC')
			->findAll();

		return view('public/subject', ['subjects' => $subjects]);
	}
	public function student()
	{
		$studentModel = new StudentModel();

		// Get filter inputs
		$q = $this->request->getGet('q');
		$class = $this->request->getGet('class');
		$section = $this->request->getGet('section');

		// Build query with filters
		$builder = $studentModel;

		$builder = $builder->where('permission', 0);

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
			->orderBy('CAST(class as UNSIGNED) ASC')
			->orderBy('CAST(roll as UNSIGNED)', 'ASC')
			->paginate($perPage, 'bootstrap');

		// For section dropdown
		$sections = $studentModel->select('section')
			->distinct()
			->orderBy('section')
			->findAll();

		// Load view
		return view('public/student_portal', [
			'students' => $students,
			'pager' => $studentModel->pager,
			'q' => $q,
			'class' => $class,
			'section' => $section,
			'sections' => $sections,
		]);
	}

	public function student_stat()
	{
		$studentModel = new StudentModel();
		$students = $studentModel
			->where('permission', 0)  // only students with permission = 0
			->findAll();

		$classSummary = [];

		foreach ($students as $student) {
			$class = $student['class'];
			$gender = $student['gender'];
			$religion = $student['religion'];
			$blood = $student['blood_group'];

			if (!isset($classSummary[$class])) {
				$classSummary[$class] = [
					'gender' => [],
					'religion' => [],
					'blood' => []
				];
			}

			// Gender
			if (!isset($classSummary[$class]['gender'][$gender])) {
				$classSummary[$class]['gender'][$gender] = 0;
			}
			$classSummary[$class]['gender'][$gender]++;

			// Religion
			if (!isset($classSummary[$class]['religion'][$religion])) {
				$classSummary[$class]['religion'][$religion] = 0;
			}
			$classSummary[$class]['religion'][$religion]++;

			// Blood
			if (!isset($classSummary[$class]['blood'][$blood])) {
				$classSummary[$class]['blood'][$blood] = 0;
			}
			$classSummary[$class]['blood'][$blood]++;
		}
		// Sort classes numerically
		ksort($classSummary);

		// Pass as array to view
		return view('public/student_stat', ['classSummary' => $classSummary]);
	}

	public function studentById()
	{
		$studentModel = new StudentModel();

		$q = $this->request->getGet('q');

		if (empty($q)) {
			return redirect()->back()->with('error', 'Student ID is required.');
		}

		$students = $studentModel
			->where('id', $q)
			->where('permission', 0)  // only students with permission = 0
			->findAll();

		return view('public/student_portal', [
			'students' => $students,
			'pager'    => null,
			'q'        => $q,
			'class'    => null,
			'section'  => null,
			'sections' => [],
		]);
	}

	public function idCard($id)
	{
		$studentModel = new StudentModel();
		$student = $studentModel
			->where('id', $id)
			->where('permission', 0)  // only if permission = 0
			->first();

		if (!$student) {
			echo "no result found";
		}

		$student['school_name'] = "MULGRAM SECONDARY SCHOOL";
		$student['eiin'] = "EIIN-115832";
		$student['school_name'] = "MULGRAM SECONDARY SCHOOL";
		$student['logo'] = base_url('public/assets/img/logo.jpg');
		$student['signature'] = base_url('public/assets/img/sign.png');

		return view('public/idCard', ['student' => $student]);
	}

	public function teacher_idcard($id)
	{
		$userModel = new UserModel();
		$user = $userModel->find($id);

		if (!$user) {
			echo "no result found";
		}

		$user['school_name'] = "MULGRAM SECONDARY SCHOOL";
		$user['eiin'] = "EIIN-115832";
		$user['school_name'] = "MULGRAM SECONDARY SCHOOL";
		$user['logo'] = base_url('public/assets/img/logo.jpg');
		$user['signature'] = base_url('public/assets/img/sign.png');

		return view('public/teacher_idcard', ['user' => $user]);
	}

	public function admit_print_view()
	{
		$studentModel = new StudentModel();
		$eventModel = new CalendarModel();

		return view('public/print_admit_card');
	}

	public function printAdmit()
	{
		$studentModel = new StudentModel();
		$eventModel   = new CalendarModel();
		$subject      = new SubjectModel();

		$class     = $this->request->getPost('class');
		$section   = $this->request->getPost('section');
		$year      = $this->request->getPost('year');
		$exam_name = $this->request->getPost('exam_name');



		$studentModel->where('class', $class)
			->where('permission', 0); // only students with permission = 0

		if (strtolower($section) === 'general') {
			// Exclude any section containing "Vocational"
			$studentModel->notLike('section', 'Vocational');
		} else {
			// Partial match for section
			$studentModel->like('section', $section);
		}

		$students = $studentModel->findAll();


		$allData = [];

		foreach ($students as $student) {
			// Get subject IDs for this student
			$subjectIds = array_map('trim', explode(',', $student['assign_sub']));

			// Fetch subjects
			$subjects = $subject->whereIn('id', $subjectIds)->findAll();

			// Fetch routines
			$routines = $eventModel
				->whereIn('subject', $subjectIds)
				->where('subcategory', $exam_name)
				->where('YEAR(start_date)', $year)   // extract year from start_date
				->findAll();

			// Combine into one array
			$allData[] = [
				'student' => $student,
				'subjects' => $subjects,
				'routines' => $routines,
				'year'     => $year,
				'exam'     =>  $exam_name
			];
		}

		return view('public/admit_crd', [
			'data' => $allData
		]);
	}

	public function attendance()
	{
		$studentModel = new \App\Models\StudentModel();
		$attendanceModel = new \App\Models\AttendanceModel();

		// ✅ GET filters
		$selectedClass   = $this->request->getGet('class');
		$selectedMonth   = $this->request->getGet('month') ?? date('Y-m');
		$selectedSection = $this->request->getGet('section'); // <-- renamed for clarity

		// ✅ Base query: only active students (permission = 0)
		$builder = $studentModel->where('permission', 0);

		// ✅ Filter by class (if selected)
		if (!empty($selectedClass)) {
			$builder->where('class', $selectedClass);
		}

		// ✅ Filter by section (General / Vocational)
		if (!empty($selectedSection)) {
			if (strtolower($selectedSection) === 'vocational') {
				// Show all where section includes the word "Vocational"
				$builder->like('section', 'Vocational');
			} else {
				// Show all where section does NOT include "Vocational"
				$builder->notLike('section', 'Vocational');
			}
		}

		// ✅ Fetch filtered students
		$students = $builder
			->orderBy('class', 'ASC')
			->orderBy('section', 'ASC')
			->orderBy('CAST(roll AS UNSIGNED)', 'ASC')
			->findAll();

		// ✅ Distinct classes for dropdown
		$classes = $studentModel
			->select('class')
			->distinct()
			->orderBy('CAST(class AS UNSIGNED)', 'ASC')
			->findAll();

		// ✅ Build days in selected month
		$daysInMonth = [];
		$numDays = date('t', strtotime($selectedMonth . '-01'));
		for ($d = 1; $d <= $numDays; $d++) {
			$date = date('Y-m-d', strtotime($selectedMonth . '-' . sprintf("%02d", $d)));
			$daysInMonth[] = [
				'date' => $date,
				'day'  => date('D', strtotime($date))
			];
		}

		// ✅ Fetch attendance records for the month
		$attendanceData = $attendanceModel
			->where('created_at >=', $selectedMonth . '-01 00:00:00')
			->where('created_at <=', $selectedMonth . '-' . $numDays . ' 23:59:59')
			->findAll();

		// ✅ Map attendance by student and date
		$attendanceMap = [];
		foreach ($attendanceData as $record) {
			$studentId = $record['student_id'];
			$date = date('Y-m-d', strtotime($record['created_at']));
			if (!isset($attendanceMap[$studentId][$date])) {
				$attendanceMap[$studentId][$date] = [
					'arrival' => null,
					'leave' => null,
					'remarks' => []
				];
			}
			if ($record['remark'] === 'A') {
				$attendanceMap[$studentId][$date]['arrival'] = $record['created_at'];
			} elseif ($record['remark'] === 'L') {
				$attendanceMap[$studentId][$date]['leave'] = $record['created_at'];
			}
			$attendanceMap[$studentId][$date]['remarks'][] = $record['remark'];
		}

		// ✅ Pass everything to the view
		$data = [
			'students'        => $students,
			'classes'         => $classes,
			'selectedClass'   => $selectedClass,
			'selectedMonth'   => $selectedMonth,
			'selectedSection' => $selectedSection, // <-- renamed variable
			'daysInMonth'     => $daysInMonth,
			'attendanceMap'   => $attendanceMap
		];

		return view('public/attendance_list', $data);
	}

	public function notice()
	{
		$noticeModel = new NoticeModel();

		// Fetch active notices only, latest first
		$data['notices'] = $noticeModel
			->where('status', 1)
			->orderBy('notice_date', 'DESC')
			->findAll();

		$data['title'] = 'School Notices';

		return view('public/notice', $data);
	}

	public function attendanceStats()
	{
		$studentModel = new \App\Models\StudentModel();
		$attendanceModel = new \App\Models\AttendanceModel();

		// Filters
		$selectedClass = $this->request->getGet('class');
		$selectedMonth = $this->request->getGet('month') ?? date('Y-m');

		// Get days of the selected month
		$numDays = date('t', strtotime($selectedMonth . '-01'));
		$days = [];
		for ($d = 1; $d <= $numDays; $d++) {
			$days[] = $selectedMonth . '-' . sprintf("%02d", $d);
		}

		// Fetch students (filtered by class if provided)
		$studentQuery = $studentModel->where('permission', 0);
		if ($selectedClass) {
			$studentQuery->where('class', $selectedClass);
		}
		$students = $studentQuery->findAll();

		// If no students found, show blank data
		if (empty($students)) {
			$data = [
				'selectedClass' => $selectedClass,
				'selectedMonth' => $selectedMonth,
				'classes' => $studentModel->select('class')->distinct()->orderBy('CAST(class AS UNSIGNED)', 'ASC')->findAll(),
				'days' => $days,
				'stats' => []
			];
			return view('public/attendance_stats', $data);
		}

		// Separate student IDs by gender
		$boyIds = [];
		$girlIds = [];
		foreach ($students as $s) {
			$gender = strtolower(trim($s['gender'] ?? ''));
			if ($gender === 'female' || $gender === 'girl') {
				$girlIds[] = $s['id'];
			} else {
				$boyIds[] = $s['id'];
			}
		}

		// Get all attendance records in the month
		$attendanceData = $attendanceModel
			->where('created_at >=', $selectedMonth . '-01 00:00:00')
			->where('created_at <=', $selectedMonth . '-' . $numDays . ' 23:59:59')
			->findAll();

		// Map attendance per student/date
		$attendanceMap = [];
		foreach ($attendanceData as $row) {
			$sid = $row['student_id'];
			$date = date('Y-m-d', strtotime($row['created_at']));
			$attendanceMap[$sid][$date][] = $row['remark'];
		}

		// Initialize stats array
		$stats = [];
		foreach ($days as $date) {
			$stats[$date] = [
				'boys_present' => 0,
				'girls_present' => 0,
				'boys_absent' => 0,
				'girls_absent' => 0,
				'total_present' => 0,
				'total_absent' => 0,
			];
		}

		// Count daily stats
		foreach ($days as $date) {
			foreach ($students as $stu) {
				$id = $stu['id'];
				$gender = strtolower(trim($stu['gender'] ?? 'male'));
				$attendance = $attendanceMap[$id][$date] ?? [];

				$isPresent = false;
				foreach ($attendance as $remark) {
					if (in_array($remark, ['P', 'L', 'E', 'L/E'])) { // Present or partial presence
						$isPresent = true;
						break;
					}
				}

				if ($isPresent) {
					if ($gender === 'female' || $gender === 'girl') {
						$stats[$date]['girls_present']++;
					} else {
						$stats[$date]['boys_present']++;
					}
					$stats[$date]['total_present']++;
				} else {
					if ($gender === 'female' || $gender === 'girl') {
						$stats[$date]['girls_absent']++;
					} else {
						$stats[$date]['boys_absent']++;
					}
					$stats[$date]['total_absent']++;
				}
			}
		}

		// Class list for dropdown
		$classes = $studentModel->select('class')->distinct()->orderBy('CAST(class AS UNSIGNED)', 'ASC')->findAll();

		$data = [
			'selectedClass' => $selectedClass,
			'selectedMonth' => $selectedMonth,
			'classes' => $classes,
			'days' => $days,
			'stats' => $stats,
		];

		return view('public/attendance_stats', $data);
	}
}
