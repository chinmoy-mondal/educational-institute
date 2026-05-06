<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PasswordResetModel;

class Auth extends BaseController
{
	// =========================
	// REGISTER
	// =========================

	public function showRegisterForm()
	{
		return view('auth/register');
	}

	public function processRegister()
	{
		$rules = [
			'name' => 'required|min_length[3]',
			'role' => 'required|in_list[Super Admin,Admin]',
			'gender' => 'permit_empty|in_list[Male,Female,Others]',
			'phone' => 'permit_empty|regex_match[/^(013|014|015|016|017|018|019)\d{8}$/]',
			'email' => 'required|valid_email|is_unique[users.email]',
			'password' => 'required|min_length[6]',
			'confirm_password' => 'required|matches[password]',
		];

		if (!$this->validate($rules)) {
			return redirect()->back()
				->withInput()
				->with('errors', $this->validator->getErrors());
		}

		$userModel = new UserModel();

		$userModel->insert([
			'name'           => $this->request->getPost('name'),
			'role'           => $this->request->getPost('role'),
			'gender'         => $this->request->getPost('gender'),
			'phone'          => $this->request->getPost('phone'),
			'email'          => $this->request->getPost('email'),
			'password'       => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
			'account_status' => 0, // pending approval
		]);

		return redirect()->to('/login')
			->with('success', 'Registration successful.');
	}

	// =========================
	// LOGIN
	// =========================

	public function showLoginForm()
	{
		return view('auth/login');
	}

	public function processLogin()
	{
		$session   = session();
		$userModel = new UserModel();

		$email    = $this->request->getPost('email');
		$password = $this->request->getPost('password');

		$user = $userModel->where('email', $email)->first();

		if (!$user) {
			return redirect()->back()
				->withInput()
				->with('error', 'Email not found.');
		}

		// Blocked check
		if ((int)$user['account_status'] === 0) {
			return redirect()->back()
				->withInput()
				->with('error', 'Your account is inactive. Contact admin.');
		}

		if (!password_verify($password, $user['password'])) {
			return redirect()->back()
				->withInput()
				->with('error', 'Invalid password.');
		}

		$session->set([
			'user_id'    => $user['id'],
			'user_name'  => $user['name'],
			'user_email' => $user['email'],
			'user_role'  => $user['role'],
			'isLoggedIn' => true,
		]);

		return redirect()->to('/dashboard');
	}

	// =========================
	// LOGOUT
	// =========================

	public function logout()
	{
		session()->destroy();

		return redirect()->to('/login')
			->with('success', 'You are logged out.');
	}

	// =========================
	// FORGOT PASSWORD
	// =========================

	public function forgotPassword()
	{
		return view('auth/forgot_password');
	}

	public function sendResetLink()
	{
		$email = $this->request->getPost('email');

		$userModel = new UserModel();
		$user = $userModel->where('email', $email)->first();

		if (!$user) {
			return redirect()->back()->with('error', 'Email not found.');
		}

		$token   = bin2hex(random_bytes(32));
		$expires = date('Y-m-d H:i:s', time() + 300); // 5 min

		$resetModel = new PasswordResetModel();

		$resetModel->insert([
			'email'      => $email,
			'token'      => $token,
			'expires_at' => $expires,
			'used'       => 0
		]);

		$resetLink = base_url("/reset-password/$token");

		$subject = "Password Reset Request";

		$message = "
        <h3>Password Reset</h3>
        <p>Click below link (valid 5 minutes)</p>
        <a href='$resetLink'>Reset Password</a>
        ";

		mail($email, $subject, $message);

		return redirect()->back()->with('success', 'Reset link sent.');
	}

	// =========================
	// RESET PASSWORD
	// =========================

	public function resetPassword($token)
	{
		$resetModel = new PasswordResetModel();

		$record = $resetModel->where('token', $token)
			->where('used', 0)
			->first();

		if (!$record || strtotime($record['expires_at']) < time()) {
			return redirect()->to('/login')
				->with('error', 'Token expired or invalid.');
		}

		return view('auth/reset_password', ['token' => $token]);
	}

	public function updatePassword()
	{
		$token = $this->request->getPost('token');
		$password = $this->request->getPost('password');
		$confirm  = $this->request->getPost('password_confirm');

		if ($password !== $confirm) {
			return redirect()->back()->with('error', 'Passwords do not match.');
		}

		$resetModel = new PasswordResetModel();

		$record = $resetModel->where('token', $token)
			->where('used', 0)
			->first();

		if (!$record || strtotime($record['expires_at']) < time()) {
			return redirect()->to('/login')
				->with('error', 'Token expired or invalid.');
		}

		$userModel = new UserModel();
		$user = $userModel->where('email', $record['email'])->first();

		if ($user) {
			$userModel->update($user['id'], [
				'password' => password_hash($password, PASSWORD_DEFAULT)
			]);

			$resetModel->update($record['id'], ['used' => 1]);

			return redirect()->to('/login')
				->with('success', 'Password updated successfully.');
		}

		return redirect()->to('/login')->with('error', 'User not found.');
	}
}