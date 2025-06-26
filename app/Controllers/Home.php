<?php

namespace App\Controllers;
use App\Models\SubjectModel;
class Home extends BaseController
{
	public function index()
	{
		return view('home');
	}

	public function welcome()
	{
		return view('welcome');
	}
	public function history()
	{
		return view('history');
	}

	public function mission()
	{
		return view('mission');
	}

	public function staff()
	{
		return view('staff');
	}
	public function subjects()
	{
		$model = new SubjectModel();  // ✅ Correct instantiation

		$subjects = $subjectModel->findAll();
		return view('p_subject', ['subjects' => $subjects]);
	}
}
