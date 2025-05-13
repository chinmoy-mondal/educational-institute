<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class RegisterController extends BaseController
{
    public function index()
    {
        return view('register'); // the registration view
    }

    public function register()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'name'              => 'required|min_length[3]',
            'role'              => 'required',
            'phone'             => 'required|numeric|min_length[10]',
            'email'             => 'required|valid_email|is_unique[users.email]',
            'password'          => 'required|min_length[6]',
            'confirm_password'  => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $model = new UserModel();

        $data = [
            'name'         => $this->request->getPost('name'),
            'role'         => $this->request->getPost('role'),
            'designation'  => $this->request->getPost('designation'),
            'subject'      => $this->request->getPost('subject'),
            'gender'       => $this->request->getPost('gender'),
            'phone'        => $this->request->getPost('phone'),
            'email'        => $this->request->getPost('email'),
            'password'     => $this->request->getPost('password'), // password hashed by model
            'is_active'    => 1
        ];

        $model->save($data);

        return redirect()->to('/login')->with('success', 'Registration successful! Please log in.');
    }
}