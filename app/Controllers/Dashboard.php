<?php

namespace App\Controllers;

use App\Models\StudentModel;
use App\Models\UserModel;
use CodeIgniter\Controller;

class Dashboard extends Controller
{
    public function index()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $studentModel = new StudentModel();
        $userModel = new UserModel();

        $total_students = $studentModel->countAll();
        $total_teachers = $userModel->where('role', 'teacher')->countAllResults();

        $total_applications = 10;
        $total_exams = 5;
        $total_income = 150000.00;
        $total_cost = 42000.00;

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

    public function profile()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $user = [
            'name' => $session->get('name'),
            'email' => $session->get('email'),
            'phone' => $session->get('phone'),
            'role' => $session->get('role')
        ];

        return view('dashboard/profile', ['user' => $user]);
    }
}
