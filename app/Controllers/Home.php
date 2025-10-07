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
		$students = $studentModel->findAll();

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
		$student = $studentModel->find($id);

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



		$studentModel->where('class', $class);

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
    $attendanceModel = new \App\Models\AttendanceModel();
    $studentModel = new \App\Models\StudentModel();

    // Fetch attendance data
    $records = $attendanceModel
        ->orderBy('created_at', 'ASC')
        ->findAll();

    if (empty($records)) {
        return view('public/attendance_list', ['attendances' => []]);
    }

    // Collect student IDs
    $studentIds = array_unique(array_column($records, 'student_id'));

    // Get student info
    $students = $studentModel->whereIn('id', $studentIds)->findAll();
    $studentDetails = [];
    foreach ($students as $st) {
        $studentDetails[$st['id']] = [
            'name' => $st['student_name'],
            'roll' => $st['roll'],
            'class' => $st['class'],
        ];
    }

    // Group attendance by date
    $attendances = [];
    foreach ($records as $rec) {
        $date = substr($rec['created_at'], 0, 10);
        $attendances[$date][] = [
            'student_id' => $rec['student_id'],
            'remark' => $rec['remark'], // P or A
            'time' => substr($rec['created_at'], 11, 8)
        ];
    }

    // Sort dates descending
    krsort($attendances);

    return view('public/attendance_list', [
        'attendances' => $attendances,
        'students' => $studentDetails
    ]);
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
}
