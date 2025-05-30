<?php

namespace App\Controllers;

use App\Models\StudentModel; // ✅ Import the model

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            // return redirect()->to('/login');
            echo "session is not working";
            return;
        }

        $studentModel = new StudentModel();
        $students = $studentModel->findAll(); // ✅ Correct variable name

        return view('dashboard/index', [
            'title' => 'Admin Dashboard',
            'students' => $students // ✅ Now this works
        ]);
    }
}
