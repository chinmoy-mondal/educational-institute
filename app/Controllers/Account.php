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
	    'name' => [
		'label' => 'Full Name',
		'rules' => 'required|min_length[3]'
	    ],
	    'role' => [
		'label' => 'Role',
		'rules' => 'required|in_list[Teacher,Staff]'
	    ],
	    'designation' => [
		'label' => 'Designation',
		'rules' => 'required'
	    ],
	    'gender' => [
		'label' => 'Gender',
		'rules' => 'required|in_list[Male,Female,Others]'
	    ],
	    'phone' => [
		'label' => 'Phone Number',
		'rules' => 'required|regex_match[/^(013|014|015|016|017|018|019)\d{8}$/]',
		'errors' => [
		    'regex_match' => 'The {field} must be 11 digits and start with a valid prefix (013, 014, 015, 016, 017, 018, 019).'
		]
	    ],
	    'email' => [
		'label' => 'Email',
		'rules' => 'required|valid_email|is_unique[users.email]'
	    ],
	    'password' => [
		'label' => 'Password',
		'rules' => 'required|min_length[6]'
	    ],
	    'confirm_password' => [
		'label' => 'Confirm Password',
		'rules' => 'required|matches[password]'
	    ],
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
