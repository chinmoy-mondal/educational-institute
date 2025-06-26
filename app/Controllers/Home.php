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
		$model = SubjectModel();	
		$builder = $db->table('subjects');
		$builder->whereIn('class', [6, 7, 8, 9]); // includes 9
		$builder->orderBy('class', 'ASC');
		$builder->orderBy('section', 'ASC');
		$builder->orderBy('subject', 'ASC');
		$subjects = $builder->get()->getResultArray();

		return view('p_subject', ['subjects' => $subjects]);
	}
}
