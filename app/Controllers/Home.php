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

		studentModel = new StudentModel();
		$q     = $this->request->getGet('q');
		$class = $this->request->getGet('class');
		$group = $this->request->getGet('group');
		$perPage = 10;

		if ($q) {
		    $studentModel->groupStart()
			->like('student_name', $q)
			->orLike('roll', $q)
			->orLike('id', $q)
			->groupEnd();
		}

		if ($class) {
		    $studentModel->where('class', $class);
		}

		if ($group) {
		    $studentModel->where('group', $group);
		}

		$students = $studentModel->orderBy('class, roll')
		    ->paginate($perPage, 'default', null, ['query' => $_GET]);

		$pager = $studentModel->pager;

		return view('public/student_portal', [
		    'students' => $students,
		    'pager'    => $pager,
		    'q'        => $q,
		    'class'    => $class,
		    'group'    => $group,
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
