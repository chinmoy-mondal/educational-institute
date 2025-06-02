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

        // Fetch real data
        $totalStudents = $studentModel->countAll();
        $totalTeachers = $userModel->where('role', 'teacher')->countAllResults();

        // Dummy values (replace with actual logic if available)
        $totalApplications = 10;
        $totalIncome = 1200;
        $totalExpenses = 300;
        $totalExams = 5;

        // Fetch all students for the table
        $students = $studentModel->findAll();

        return view('dashboard/index', [
            'title' => 'Admin Dashboard',
            'total_students' => $totalStudents,
            'total_teachers' => $totalTeachers,
            'total_applications' => $totalApplications,
            'total_income' => $totalIncome,
            'total_expenses' => $totalExpenses,
            'total_exams' => $totalExams,
            'students' => $students
        ]);
    }
}
