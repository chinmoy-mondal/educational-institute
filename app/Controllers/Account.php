<?php

namespace App\Controllers;
use App\Models\AccountModel;
use CodeIgniter\Controller;

class Account extends BaseController
{
    public function register()
    {
        helper(['form']);

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name'              => 'required|min_length[3]',
                'role'              => 'required',
                'gender'            => 'required',
                'phone'             => 'required|numeric',
                'email'             => 'required|valid_email|is_unique[users.email]',
                'password'          => 'required|min_length[6]',
                'confirm_password'  => 'required|matches[password]',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $model = new AccountModel();

            $data = [
                'name'          => $this->request->getPost('name'),
                'role'          => $this->request->getPost('role'),
                'designation'   => $this->request->getPost('designation'),
                'subject'       => $this->request->getPost('subject'),
                'gender'        => $this->request->getPost('gender'),
                'phone'         => $this->request->getPost('phone'),
                'email'         => $this->request->getPost('email'),
                'password'      => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
            ];

            $model->save($data);

            return redirect()->to('/login')->with('success', 'Registration successful. Please login.');
        }

        return view('auth/register');
    }

    public function login()
    {
        helper(['form']);

        if ($this->request->getMethod() === 'post') {
            $model = new AccountModel();
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $user = $model->where('email', $email)->first();

            if ($user && password_verify($password, $user['password'])) {
                $this->setUserSession($user);
                return redirect()->to('/dashboard'); // Change this path as needed
            } else {
                return redirect()->back()->withInput()->with('error', 'Invalid email or password.');
            }
        }

        return view('auth/login');
    }

    private function setUserSession($user)
    {
        $data = [
            'id'        => $user['id'],
            'name'      => $user['name'],
            'email'     => $user['email'],
            'role'      => $user['role'],
            'isLoggedIn'=> true
        ];

        session()->set($data);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}