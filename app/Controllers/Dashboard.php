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

        return view('dashboard/index');
    }
}