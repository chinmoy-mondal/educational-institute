<?php

namespace App\Controllers;

use App\Models\SubjectModel;
use App\Models\StudentModel;
use App\Models\UserModel;

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

		$faculty = $userModel->where('role','Teacher')->findAll();
		return view('public/staff',['faculty' => $faculty]);
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

		if (!$student) {
			echo "no result found";
		}

		$student['school_name'] = "MULGRAM SECONDARY SCHOOL";
		$student['eiin'] = "EIIN-115832";
		$student['school_name'] = "MULGRAM SECONDARY SCHOOL";
		$student['logo'] = base_url('public/assets/img/logo.jpg');
		$student['signature'] = base_url('public/assets/img/sign.png');

		return view('public/teacher_idcard', ['user' => $user]);
	}
}
