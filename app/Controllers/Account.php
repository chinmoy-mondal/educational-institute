<?php

namespace App\Controllers;

use App\Models\UserModel;

class Account extends BaseController
{
	public function showRegisterForm()
	{
		return view('auth/register');
	}

	public function processRegister()
	{
		// Validation rules
		$validationRules = [
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

			// Validate input
			if (!$this->validate($validationRules)) {
				return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
			}

			// Prepare data for insertion
			$data = [
				'name'           => $this->request->getPost('name'),
				'role'           => $this->request->getPost('role'),
				'designation'    => $this->request->getPost('designation'),
				'subject'        => $this->request->getPost('subject') ?? null,
				'gender'         => $this->request->getPost('gender'),
				'phone'          => $this->request->getPost('phone'),
				'email'          => $this->request->getPost('email'),
				'password'       => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
				'account_status' => 0,
				'created_at'     => date('Y-m-d H:i:s'),
				'updated_at'     => date('Y-m-d H:i:s'),
			];

			// Insert user into database
			$userModel = new UserModel();
			$userModel->insert($data);

			// Redirect to login with success message
			return redirect()->to('/login')->with('success', 'Registration successful.');
	}

	public function showLoginForm()
	{
		return view('auth/login');
	}

	public function processLogin()
	{
		$session    = session();
		$userModel  = new UserModel();

		$email      = $this->request->getPost('email');
		$password   = $this->request->getPost('password');

		// 1.  Look up the user
		$user = $userModel->where('email', $email)->first();

		if (! $user) {
			return redirect()->back()->withInput()
				->with('error', 'Email not found.');
		}

		// 2.  Is the account allowed to log in?
		//     0 = disabled / blocked
		//     1 = normal user
		//     2 = super-admin
		if ($user['account_status'] === '0') {
			return redirect()->back()->withInput()
				->with('error', 'Your account is inactive. Please contact the administrator.');
		}

		// 3.  Check the password
		if (! password_verify($password, $user['password'])) {
			return redirect()->back()->withInput()
				->with('error', 'Invalid password.');
		}

		// 4.  Success — build the session payload
		$session->set([
				'user_id'        => $user['id'],
				'user_name'      => $user['name'],
				'user_email'     => $user['email'],
				'user_role'      => $user['role'],
				'designation'    => $user['designation'],
				'subject'        => $user['subject'],
				'gender'         => $user['gender'],
				'phone'          => $user['phone'],
				'account_status' => $user['account_status'],
				'created_at'     => $user['created_at'],
				'updated_at'     => $user['updated_at'],
				'isLoggedIn'     => true,
		]);
		return redirect()->to('/dashboard');
	}
	public function logout()
	{
		session()->destroy();
		return redirect()->to('/login')->with('success', 'You are logged out.');
	}
}
