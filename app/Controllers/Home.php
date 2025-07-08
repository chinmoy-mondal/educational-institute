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

		// Get filter inputs
		$q       = $this->request->getGet('q');
		$class   = $this->request->getGet('class');
		$section = $this->request->getGet('section');

		// Base query
		$builder = $studentModel;

		// Apply search
		if ($q) {
			$builder = $builder->groupStart()
				->like('student_name', $q)
				->orLike('roll', $q)
				->orLike('id', $q)
				->groupEnd();
		}

		// Filter class
		if ($class) {
			$builder = $builder->where('class', $class);
		}

		// Filter section
		if ($section) {
			$builder = $builder->where('section', $section);
		}

		// Sort by class ASC then roll ASC
		$builder = $builder->orderBy('class ASC')->orderBy('roll ASC');

		// Paginate 10 results per page
		$students = $builder->paginate(10);
		$pager    = $builder->pager;

		// Get distinct section list
		$sections = $studentModel
			->select('section')
			->distinct()
			->where('section !=', '')
			->orderBy('section', 'ASC')
			->findColumn('section');

		// Pass data to view
		return view('public/student_portal', [
				'students' => $students,
				'pager'    => $pager,
				'q'        => $q,
				'class'    => $class,
				'section'  => $section,
				'sections' => $sections,
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
