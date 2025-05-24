<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Account extends BaseController
{
    public function showRegisterForm()
    {
        helper(['form']);
        return view('auth/register');
    }

    public function processRegister()
    {
        helper(['form']);

        $rules = [
            'name'             => 'required|min_length[3]',
            'role'             => 'required|in_list[Teacher,Staff]',
            'designation'      => 'required',
            'gender'           => 'required|in_list[Male,Female,Others]',
            'phone'            => 'required|min_length[6]|max_length[20]',
            'email'            => 'required|valid_email|is_unique[users.email]',
            'password'         => 'required|min_length[6]',
            'confirm_password' => 'matches[password]',
        ];

        if ($this->request->getPost('role') === 'Teacher') {
            $rules['subject'] = 'required';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();

        $userModel->save([
            'name'        => $this->request->getPost('name'),
            'role'        => $this->request->getPost('role'),
            'designation' => $this->request->getPost('designation'),
            'subject'     => $this->request->getPost('role') === 'Teacher' ? $this->request->getPost('subject') : null,
            'gender'      => $this->request->getPost('gender'),
            'phone'       => $this->request->getPost('phone'),
            'email'       => $this->request->getPost('email'),
            'password'    => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ]);

        return redirect()->to('login')->with('success', 'Registration successful!');
    }
}
