<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            // return redirect()->to('/login');
            echo "session is not working";
        }
	
	$studentModel = new StudentModel();

	$data['students'] = $studentModel->findAll();

        return view('dashboard/index',[
		'title'=> 'Admin Dashboard',
		'students' =>$students
	]);
    }
}
