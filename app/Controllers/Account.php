<?php

namespace App\Controllers;

use App\Models\UserModel;

class Account extends BaseController
{
    public function register()
    {
        return view('register');
    }

    public function store()
    {
        helper(['form']);

        $rules = [
            'name'              => 'required|min_length[3]',
            'role'              => 'required',
            'designation'       => 'permit_empty',
            'subject'           => 'permit_empty',
            'gender'            => 'required',
            'phone'             => 'required|min_length[10]',
            'email'             => 'required|valid_email|is_unique[users.email]',
            'password'          => 'required|min_length[6]',
            'confirm_password'  => 'required|matches[password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $userModel->save([
            'name'        => $this->request->getPost('name'),
            'role'        => $this->request->getPost('role'),
            'designation' => $this->request->getPost('designation'),
            'subject'     => $this->request->getPost('subject'),
            'gender'      => $this->request->getPost('gender'),
            'phone'       => $this->request->getPost('phone'),
            'email'       => $this->request->getPost('email'),
            'password'    => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ]);

        return redirect()->to('/login')->with('success', 'Registration successful!');
    }
}