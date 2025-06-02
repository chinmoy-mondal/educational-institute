<?php

namespace App\Controllers;

use App\Models\StudentModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $studentModel = new StudentModel();
        $userModel = new UserModel();

        // Total students
        $total_students = $studentModel->countAll();

        // Total teachers
        $total_teachers = $userModel->where('role', 'teacher')->countAllResults();

        // Dummy values (you can replace them with model logic later)
        $total_applications = 10;
        $total_exams = 5;
        $total_income = 150000.00;
        $total_cost = 42000.00;

        // All students data for the table
        $students = $studentModel
            ->select('id, student_name, roll, class, phone')
            ->orderBy('id', 'DESC')
            ->findAll();

        return view('dashboard/index', [
            'title' => 'Admin Dashboard',
            'total_students' => $total_students,
            'total_teachers' => $total_teachers,
            'total_applications' => $total_applications,
            'total_exams' => $total_exams,
            'total_income' => $total_income,
            'total_cost' => $total_cost,
            'students' => $students
        ]);
    }
}
