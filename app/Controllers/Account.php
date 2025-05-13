<?php

namespace App\Controllers;

class Account extends BaseController
{
    public function Register()
    {
        return view('register');
    }
    public function Login()
    {
        return view('login');
    }

}