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

        // 🔐 Auth check
        if (!$this->session->get('isLoggedIn')) {
            redirect()->to('/login')->send();
            exit;
        }

        // Common UI data
        $this->data['navbarItems'] = [
            ['label' => 'Dashboard', 'url' => base_url('dashboard')],
            ['label' => 'Profile', 'url' => base_url('dashboard/profile')],
        ];

        $this->data['sidebarItems'] = [
            [
                'label' => 'Dashboard',
                'url'   => base_url('dashboard'),
                'icon'  => 'fas fa-tachometer-alt',
                'section' => 'dashboard'
            ],
            [
                'label' => 'Users',
                'url'   => base_url('dashboard/users'),
                'icon'  => 'fas fa-users',
                'section' => 'users'
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

        // Stats
        $this->data['total_users'] = $this->userModel->countAll();
        $this->data['active_users'] = $this->userModel
            ->where('account_status', 1)
            ->countAllResults();

        $this->data['inactive_users'] = $this->userModel
            ->where('account_status', 0)
            ->countAllResults();

        // return view('dashboard/index', $this->data);
    }

    // =========================
    // PROFILE (OWN)
    // =========================
    public function profile()
    {
        $this->data['title'] = 'Profile';
        $this->data['activeSection'] = 'dashboard';

        $userId = $this->session->get('user_id');

        $user = $this->userModel->find($userId);

        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("User not found");
        }

        $this->data['user'] = $user;

        // return view('dashboard/profile', $this->data);
    }

    // =========================
    // PROFILE BY ID (ADMIN)
    // =========================
    public function profile_id($id)
    {
        $this->data['title'] = 'Profile';
        $this->data['activeSection'] = 'dashboard';

        $user = $this->userModel->find($id);

        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("User not found");
        }

        $this->data['user'] = $user;

        // return view('dashboard/profile', $this->data);
    }

    // =========================
    // USERS LIST (OPTIONAL)
    // =========================
    public function users()
    {
        $this->data['title'] = 'Users';
        $this->data['activeSection'] = 'users';

        $this->data['users'] = $this->userModel->findAll();

        // return view('dashboard/users', $this->data);
    }
}