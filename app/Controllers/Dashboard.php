<?php

namespace App\Controllers;

use App\Models\UserModel;

class Dashboard extends BaseController
{
    protected $userModel;
    protected $session;
    protected $data = [];

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session   = session();

        // Auth check (simple safe version)
        if (!$this->session->get('isLoggedIn')) {
            redirect()->to('/login')->send();
            exit;
        }

        // Sidebar data (dynamic)
        $this->data['sidebarItems'] = [
            [
                'label' => 'Dashboard',
                'url'   => 'dashboard',
                'icon'  => 'fas fa-tachometer-alt',
                'section' => 'dashboard'
            ],
            [
                'label' => 'Users',
                'url'   => 'dashboard/users',
                'icon'  => 'fas fa-users',
                'section' => 'users'
            ],
            [
                'label' => 'Profile',
                'url'   => 'dashboard/profile',
                'icon'  => 'fas fa-user',
                'section' => 'profile'
            ],
        ];
    }

    // =========================
    // DASHBOARD HOME
    // =========================
    public function index()
    {
        $this->data['title'] = 'Dashboard';
        $this->data['activeSection'] = 'dashboard';

        $this->data['total_users'] = $this->userModel->countAll();
        $this->data['active_users'] = $this->userModel
            ->where('account_status', 1)
            ->countAllResults();

        $this->data['inactive_users'] = $this->userModel
            ->where('account_status', 0)
            ->countAllResults();

        return view('dashboard/index', $this->data);
    }

    // =========================
    // USERS
    // =========================
    public function users()
    {
        $this->data['title'] = 'Users';
        $this->data['activeSection'] = 'users';

        $this->data['users'] = $this->userModel->findAll();

        return view('dashboard/users', $this->data);
    }

    // =========================
    // PROFILE
    // =========================
    public function profile()
    {
        $this->data['title'] = 'Profile';
        $this->data['activeSection'] = 'profile';

        $userId = $this->session->get('user_id');
        $this->data['user'] = $this->userModel->find($userId);

        return view('dashboard/profile', $this->data);
    }
}