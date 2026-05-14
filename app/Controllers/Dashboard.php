<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PatientModel;

class Dashboard extends BaseController
{
    protected $userModel;
    protected $patientModel;
    protected $session;
    protected $data = [];

    public function __construct()
    {
        $this->userModel    = new UserModel();
        $this->patientModel = new PatientModel();
        $this->session      = session();

        // Auth check
        if (!$this->session->get('isLoggedIn')) {
            redirect()->to('/login')->send();
            exit;
        }

        // 🌟 ONLY CATEGORIES (GLOBAL)
        $this->data['sidebarCategories'] = [
            [
                'label' => 'Dashboard',
                'icon'  => 'fas fa-home',
                'type'  => 'single',
                'url'   => 'dashboard',
                'section' => 'dashboard'
            ],
            [
                'label' => 'User Management',
                'icon'  => 'fas fa-users',
                'type'  => 'category'
            ],
            [
                'label' => 'Clinic',
                'icon'  => 'fas fa-hospital',
                'type'  => 'category'
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

        // 🌟 ONLY SUBCATEGORIES (PAGE SPECIFIC)
        $this->data['sidebarSubItems'] = [
            'User Management' => [
                [
                    'label' => 'All Users',
                    'url'   => 'dashboard/users',
                    'section' => 'users'
                ],
                [
                    'label' => 'Add User',
                    'url'   => 'dashboard/users/create',
                    'section' => 'users_create'
                ],
            ],

            'Clinic' => [
                [
                    'label' => 'Patients',
                    'url'   => 'dashboard/patients',
                    'section' => 'patients'
                ],
                [
                    'label' => 'Doctors',
                    'url'   => 'dashboard/doctors',
                    'section' => 'doctors'
                ],
            ]
        ];

        // Stats
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


    // =========================
    // patients
    // =========================

    public function patients()
    {
        $this->data['title'] = 'Patients';
        $this->data['activeSection'] = 'patients';

        $phone = $this->request->getGet('phone');

        $builder = $this->patientModel;

        if (!empty($phone)) {

            $phone = trim($phone);

            if (!preg_match('/^[0-9]{11}$/', $phone)) {

                return redirect()->back()
                    ->with('error', 'Phone number must be exactly 11 digits.');
            }

            $builder = $builder->like('phone', $phone);
        }

        $patients = $builder->findAll();

        // Redirect only if searched and no patient found
        if (!empty($phone) && empty($patients)) {

            return redirect()->to('dashboard/patients/create')
                ->with('error', 'No patient found. Please add new patient.');
        }

        $this->data['patients'] = $patients;

        return view('dashboard/patients', $this->data);
    }
    
    public function createPatient()
    {
        $this->data['title'] = 'Add Patient';
        $this->data['activeSection'] = 'patients';

        return view('dashboard/patient_create', $this->data);
    }

    public function storePatient()
    {
        $data = [
            'name'    => $this->request->getPost('name'),
            'phone'   => $this->request->getPost('phone'),
            'age'     => $this->request->getPost('age'),
            'gender'  => $this->request->getPost('gender'),
            'address' => $this->request->getPost('address'),
        ];

        $this->patientModel->insert($data);

        return redirect()->to('/dashboard/patients')
            ->with('success', 'Patient added successfully');
    }
    
}