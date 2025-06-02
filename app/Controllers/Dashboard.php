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

        // Fetch total counts
        $totalStudents = $studentModel->countAll();
        $totalTeachers = $userModel->where('role', 'teacher')->countAllResults();
        $totalApplications = 10; // Replace with actual logic
        $totalIncome = 1200;     // Replace with actual logic
        $totalExpenses = 300;    // Replace with actual logic

        // Fetch all students
        $students = $studentModel->findAll();

        return view('dashboard/index', [
            'title' => 'Admin Dashboard',
            'total_students' => $totalStudents,
            'total_teachers' => $totalTeachers,
            'total_applications' => $totalApplications,
            'total_income' => $totalIncome,
            'total_expenses' => $totalExpenses,
            'students' => $students
        ]);
    }
}
