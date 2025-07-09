<?php

namespace App\Controllers;

use App\Models\SubjectModel;
use App\Models\StudentModel;

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
		return view('public/staff');
	}
	public function subjects()
	{
		$model = new SubjectModel();  // ✅ Correct instantiation

		$subjects = $model->findAll();
		return view('public/subject', ['subjects' => $subjects]);
	}
	public function student()
	{
		$studentModel = new StudentModel();

		$q        = $this->request->getGet('q');
		$class    = $this->request->getGet('class');
		$section  = $this->request->getGet('section');

		$builder = $studentModel;

		if ($q) {
			$builder->like('student_name', $q)
				->orLike('roll', $q)
				->orLike('id', $q);
		}

		if ($class) {
			$builder->where('class', $class);
		}

		if ($section) {
			$builder->where('section', $section);
		}

		$students = $builder
			->orderBy('class', 'ASC')
			->orderBy('roll', 'ASC')
			->paginate(10, 'default');

		$pager = $studentModel->pager;

		// Get unique sections from DB
		$db = \Config\Database::connect();
		$sections = $db->table('students')->select('section')->distinct()->get()->getResultArray();

		return view('public/student_portal', [
				'students' => $students,
				'pager'    => $pager,
				'q'        => $q,
				'class'    => $class,
				'section'  => $section,
				'sections' => array_column($sections, 'section'),
		]);
	}

}
