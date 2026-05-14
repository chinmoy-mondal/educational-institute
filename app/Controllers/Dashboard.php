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

        // AUTH CHECK
        if (!$this->session->get('isLoggedIn')) {
            redirect()->to('/login')->send();
            exit;
        }

        // =========================
        // SIDEBAR CATEGORIES
        // =========================
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

        // =========================
        // SIDEBAR SUB ITEMS
        // =========================
        $this->data['sidebarSubItems'] = [
            'User Management' => [
                [
                    'label' => 'All Users',
                    'url'   => 'dashboard/users',
                    'section' => 'users'
                ],
                [
                    'label' => 'Profile',
                    'url'   => 'dashboard/profile',
                    'section' => 'profile'
                ],
            ],

            'Clinic' => [
                [
                    'label' => 'Patients',
                    'url'   => 'dashboard/patients',
                    'section' => 'patients'
                ],
                [
                    'label' => 'Add Patient',
                    'url'   => 'dashboard/patients/create',
                    'section' => 'patients_create'
                ],
                [
                    'label' => 'Doctors',
                    'url'   => 'dashboard/doctors',
                    'section' => 'doctors'
                ],
            ]
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

    // =========================
    // PATIENTS LIST
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

        $this->data['patients'] = $patients;

        return view('dashboard/patients', $this->data);
    }

    // =========================
    // CREATE PATIENT
    // =========================
    public function createPatient()
    {
        $this->data['title'] = 'Add Patient';
        $this->data['activeSection'] = 'patients_create';

        $phone = $this->request->getGet('phone');

        // ❌ BLOCK if phone is missing OR not exactly 11 digits
        if (empty($phone) || !preg_match('/^[0-9]{11}$/', trim($phone))) {

            return redirect()->to('/dashboard/patients')
                ->with('error', 'Please enter a valid 11-digit phone number first.');
        }

        // ✅ valid phone only comes here
        $this->data['phone'] = trim($phone);

        return view('dashboard/patient_create', $this->data);
    }

    // =========================
    // STORE PATIENT
    // =========================
    public function storePatient()
    {
        $phone = $this->request->getPost('phone');

        // VALIDATION
        if (!preg_match('/^[0-9]{11}$/', $phone)) {
            return redirect()->back()
                ->with('error', 'Phone number must be exactly 11 digits.');
        }

        $data = [
            'name'    => $this->request->getPost('name'),
            'phone'   => $phone,
            'age'     => $this->request->getPost('age'),
            'gender'  => $this->request->getPost('gender'),
            'address' => $this->request->getPost('address'),
        ];

        $this->patientModel->insert($data);

        return redirect()->to('/dashboard/patients')
            ->with('success', 'Patient added successfully');
    }
}