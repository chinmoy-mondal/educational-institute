<?php

namespace App\Controllers;

use App\Models\StudentModel;
use App\Models\UserModel;

public function __construct()
{
    $this->studentModel = new StudentModel();
    $this->userModel    = new UserModel();
    // Add others as needed: LeaveModel, ExamModel, IncomeModel, CostModel
}

public function index()
{
    $totalStudents = $this->studentModel->countAll();

    $totalTeachers = $this->userModel
        ->where('role', 'teacher')
        ->countAllResults();

    return view('dashboard/index', [
        'title'          => 'Admin Dashboard',
        'total_students' => $totalStudents,
        'total_teachers' => $totalTeachers,
        // You can add these when the tables are ready:
        // 'total_applications' => $this->leaveModel->countAll(),
        // 'total_exams'        => $this->examModel->countAll(),
        // 'total_income'       => $this->incomeModel->getTotal(),
        // 'total_cost'         => $this->costModel->getTotal(),
        'students'       => $this->studentModel->findAll()
    ]);
}
