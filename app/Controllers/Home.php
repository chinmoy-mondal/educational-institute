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

		$builder = $studentModel;

		if (!empty($q)) {
			$builder = $builder->groupStart()
				->like('student_name', $q)
				->orLike('roll', $q)
				->orLike('id', $q)
				->groupEnd();
		}

		if (!empty($class)) {
			$builder = $builder->where('class', $class);
		}

		if (!empty($section)) {
			$builder = $builder->where('section', $section);
		}

		$students = $builder->orderBy('class', 'ASC')->orderBy('roll', 'ASC')->paginate(10);
		$pager    = $studentModel->pager;

		// Get all unique section values for dropdown
		$sections = $studentModel
			->select('section')
			->distinct()
			->where('section IS NOT NULL')
			->where('section !=', '')
			->orderBy('section', 'ASC')
			->findAll();

		return view('public/student_portal', [
				'students' => $students,
				'pager'    => $pager,
				'q'        => $q,
				'class'    => $class,
				'section'  => $section,
				'sections' => array_column($sections, 'section'),
		]);
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
