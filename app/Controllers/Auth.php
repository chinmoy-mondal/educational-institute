<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PasswordResetModel;
use CodeIgniter\Controller;

class Auth extends BaseController
{
    public function register()
    {
        helper(['form']);

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name' => 'required|min_length[3]',
                'role' => 'required',
                'gender' => 'required',
                'phone' => 'required|numeric',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[6]',
                'confirm_password' => 'matches[password]'
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $userModel = new UserModel();
            $userModel->save([
                'name' => $this->request->getPost('name'),
                'role' => $this->request->getPost('role'),
                'designation' => $this->request->getPost('designation'),
                'subject' => $this->request->getPost('subject'),
                'gender' => $this->request->getPost('gender'),
                'phone' => $this->request->getPost('phone'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
            ]);

            return redirect()->to('/login')->with('success', 'Registration successful!');
        }

        return view('auth/register'); // your registration view
    }

    public function login()
    {
        helper(['form']);

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'email' => 'required|valid_email',
                'password' => 'required'
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $userModel = new UserModel();
            $user = $userModel->where('email', $this->request->getPost('email'))->first();

            if ($user && password_verify($this->request->getPost('password'), $user['password'])) {
                // Set user session
                session()->set([
                    'user_id' => $user['id'],
                    'name'    => $user['name'],
                    'email'   => $user['email'],
                    'isLoggedIn' => true
                ]);

                return redirect()->to('/dashboard');
            } else {
                return redirect()->back()->withInput()->with('errors', ['Invalid login credentials.']);
            }
        }

        return view('auth/login'); // your login view
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    // password reset method 
    // Show forgot password form
    public function forgotPassword()
    {
        return view('auth/forgot_password');
    }

    // Handle request for reset link
    public function sendResetLink()
    {
        $email = $this->request->getPost('email');
        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Email not found.');
        }

        // Generate token
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', time() + 120); // 2 min expiry

        $resetModel = new PasswordResetModel();
        $resetModel->insert([
            'email'      => $email,
            'token'      => $token,
            'expires_at' => $expires,
            'used'       => 0
        ]);

        $resetLink = base_url("/reset-password/$token");

        // TODO: send via Email
        return redirect()->back()->with('success', "Reset link (valid 2 mins): <a href='$resetLink'>$resetLink</a>");
    }

    // Show reset form
    public function resetPassword($token = null)
    {
        $resetModel = new PasswordResetModel();
        $record = $resetModel->where('token', $token)->where('used', 0)->first();

        if (!$record || strtotime($record['expires_at']) < time()) {
            return redirect()->to('/login')->with('error', 'Token expired or invalid.');
        }

        return view('auth/reset_password', ['token' => $token]);
    }

    // Handle new password save
    public function updatePassword()
    {
        $token = $this->request->getPost('token');
        $password = $this->request->getPost('password');

        $resetModel = new PasswordResetModel();
        $record = $resetModel->where('token', $token)->where('used', 0)->first();

        if (!$record || strtotime($record['expires_at']) < time()) {
            return redirect()->to('/login')->with('error', 'Token expired or invalid.');
        }

        $userModel = new UserModel();
        $userModel->where('email', $record['email'])
                  ->set(['password' => password_hash($password, PASSWORD_DEFAULT)])
                  ->update();

        // Mark token as used
        $resetModel->update($record['id'], ['used' => 1]);

        return redirect()->to('/login')->with('success', 'Password updated. You can now login.');
    }
}

