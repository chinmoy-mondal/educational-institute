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
		helper('text');

		$studentModel = new \App\Models\StudentModel();

		// Get query parameters
		$q       = $this->request->getGet('q');
		$class   = $this->request->getGet('class');
		$section = $this->request->getGet('section');

		// Build query
		$studentModel
			->select('*')
			->orderBy('class', 'ASC')
			->orderBy('roll', 'ASC');

		if (!empty($q)) {
			$studentModel->groupStart()
				->like('student_name', $q)
				->orLike('roll', $q)
				->orLike('id', $q)
				->groupEnd();
		}

		if (!empty($class)) {
			$studentModel->where('class', $class);
		}

		if (!empty($section)) {
			$studentModel->where('section', $section);
		}

		// Pagination
		$perPage = 10;
		$students = $studentModel->paginate($perPage, 'default');

		// Get distinct sections for the dropdown
		$sections = $studentModel->select('section')
			->distinct()
			->where('section !=', '')
			->orderBy('section', 'ASC')
			->findAll();

		return view('public/student_portal', [
				'students' => $students,
				'pager'    => $studentModel->pager,
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
