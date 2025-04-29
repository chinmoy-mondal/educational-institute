<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('home');
    }
    
    public function welcome()
    {
        return view('welcome');
    }
    public function history()
    {
        return view('history');
    }
    
    public function mission()
    {
        return view('mission');
    }
    
    public function staff()
    {
        return view('staff');
    }
}