<?php

namespace App\Controllers;

use App\Models\SubjectModel;
use App\Models\StudentModel;
use App\Models\UserModel;
use App\Models\CalendarModel;
use App\Models\AttendanceModel;
use App\Models\NoticeModel;

class Home extends BaseController
{
	public function index()
	{
		return view('public/home');
	}
}