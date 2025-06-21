<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\StudentModel;
use App\Models\CalendarModel;

class AdmitCard extends BaseController
{
    public function index()
    {
        $studentModel = new StudentModel();
        $eventModel = new CalendarModel();

        $students = $studentModel->findAll();
        $events = $eventModel->findAll();

        return view('admit_card', [
            'students' => $students,
            'events' => $events
        ]);
    }
}
