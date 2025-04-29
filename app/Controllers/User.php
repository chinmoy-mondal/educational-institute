<?php

namespace App\Controllers;
use Config\Database;

class User extends BaseController
{
    public function index()
    {
         $db = Database::connect();
        
        // Query the users table
        $query = $db->query('SELECT * FROM users');
        
        // Get results
        $users = $query->getResult();
        echo "<pre>";
        print_r($users);
        //return view('page', $data);
    }
}