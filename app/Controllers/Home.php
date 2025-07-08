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


	public function student()
	{
		$studentModel = new StudentModel();
		$q       = $this->request->getGet('q');
		$class   = $this->request->getGet('class');
		$section = $this->request->getGet('section');

		$builder = $studentModel->orderBy('class', 'ASC')->orderBy('roll', 'ASC');

		if ($q) {
			$builder->groupStart()
				->like('student_name', $q)
				->orLike('roll', $q)
				->orLike('id', $q)
				->groupEnd();
		}

		if ($class) {
			$builder->where('class', $class);
		}

		if ($section) {
			$builder->where('section', $section);
		}

		$data = [
			'students' => $builder->paginate(10, 'default'),
			'pager'    => $studentModel->pager,
			'q'        => $q,
			'class'    => $class,
			'section'  => $section,
		];

		return view('public/student_portal', $data);
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
}
