<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\StudentModel;
use App\Models\CalendarModel;

class AdmitCard extends BaseController
{
	public function index($class = null)
	{
		$studentModel = new StudentModel();
		$eventModel = new CalendarModel();

		return view('public/print_admit_card');
	}
	public function print($class = null)
	{
		$studentModel = new StudentModel();
		$eventModel = new CalendarModel();

		if ($class !== null) {
			$students = $studentModel
				->where('class', $class)
				->orderBy('roll', 'ASC')
				->findAll();
			$events = $eventModel->findAll();
		} else {
			$students = $studentModel
				->where('class !=', '10')
				->orderBy('class', 'ASC')
				->findAll();
			$events = $eventModel->findAll();
		}
		return view('public/admit_card', [
			'students' => $students,
			'events' => $events
		]);
	}
}
