<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\StudentModel;
use App\Models\SubjectModel;
use App\Models\ResultModel;
use App\Models\CalendarModel;
use App\Models\MarkingOpenModel;
use App\Models\NoticeModel;
use App\Models\AttendanceModel;
use App\Models\FeesModel;
use App\Models\FeesAmountModel;
use App\Models\TransactionModel;
use App\Models\TeacherAttendanceModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Dashboard extends Controller
{
    protected $userModel;
    protected $subjectModel;
    protected $studentModel;
    protected $resultModel;
    protected $calendarModel;
    protected $noticeModel;
    protected $markingModel;
    protected $attendanceModel;
    protected $feesModel;
    protected $feesAmountModel;
    protected $transactionModel;
    protected $welcomeModel;
    protected $teacherAttendanceModel;

    protected $session;
    protected $data;

    public function __construct()
    {
        $this->userModel        = new UserModel();
        $this->subjectModel     = new SubjectModel();
        $this->studentModel     = new StudentModel();
        $this->resultModel      = new ResultModel();
        $this->calendarModel    = new CalendarModel();
        $this->noticeModel      = new NoticeModel();
        $this->markingModel     = new MarkingOpenModel();
        $this->attendanceModel  = new AttendanceModel();
        $this->feesModel        = new FeesModel();
        $this->feesAmountModel  = new FeesAmountModel();
        $this->transactionModel = new TransactionModel();
        $this->teacherAttendanceModel = new TeacherAttendanceModel();


        $this->session       = session();
        $this->data          = [];

        if (!$this->session->get('isLoggedIn')) {
            redirect()->to(base_url('login'))->send();
            exit;
        }

        $this->data['navbarItems'] = [
            ['label' => 'Dashboard', 'url' => base_url('dashboard')],
            ['label' => 'Calendar', 'url' => base_url('calendar')],
            ['label' => 'Result', 'url' => base_url('ad-result')],
            ['label' => 'Accounts', 'url' => base_url('accounts')],
        ];
        $this->data['sidebarItems'] = [
            [
                'label' => 'Dashboard',
                'url' => base_url('dashboard'),
                'icon' => 'fas fa-tachometer-alt',
                'section' => 'dashboard'
            ],
            [
                'label' => 'Teacher Management',
                'url' => base_url('teacher_management'),
                'icon' => 'fas fa-chalkboard-teacher',
                'section' => 'teacher'
            ],
            [
                'label' => 'Student Management',
                'url' => base_url('admin/student'),
                'icon' => 'fas fa-user-graduate',
                'section' => 'student'
            ],
            [
                'label'   => 'Accounts',
                'url'     => base_url('admin/transactions'),
                'icon'    => 'fa-solid fa-sack-dollar',
                'section' => 'accounts'
            ],
            [
                'label' => 'Attendance',
                'url' => base_url('admin/attendance/calendar'),
                'icon' => 'fas fa-clock',
                'section' => 'attendance'
            ],
            [
                'label' => 'Calendar',
                'url' => base_url('calendar'),
                'icon' => 'fas fa-calendar-alt',
                'section' => 'calendar'
            ],
            [
                'label' => 'Notice',
                'url' => base_url('admin/notices'),
                'icon' => 'fas fa-bullhorn',
                'section' => 'notice'
            ],
            [
                'label' => 'Result',
                'url' => base_url('admin/tabulation_form'),
                'icon' => 'fas fa-chart-bar',
                'section' => 'result'
            ],
            [
                'label' => 'Welcome Message',
                'url' => base_url('admin/welcome-message'),
                'icon' => 'fas fa-user-tie',
                'section' => 'welcome_message'
            ],
            [
                'label' => 'Teacher Attendance',
                'url' => base_url('admin/teacher-attendance'),
                'icon' => 'fas fa-user-tie',
                'section' => 'teacher_attendance'
            ],
        ];
    }

    public function index()
    {

        // Dashboard specific values
        $this->data['title'] = 'Dashboard';
        $this->data['activeSection'] = 'dashboard';

        // Common navbar and sidebar for all views

        $this->data['navbarItems'] = [
            ['label' => 'Dashboard', 'url' => base_url('dashboard')],
            ['label' => 'Calendar', 'url' => base_url('calendar')],
            ['label' => 'Result', 'url' => base_url('ad-result')],
            ['label' => 'Accounts', 'url' => base_url('accounts')],
        ];
        $this->data['total_students'] = $this->studentModel->where('account_status', 0)->countAll();
        $this->data['total_users'] = $this->userModel->where('account_status !=', 0)->countAllResults();
        $this->data['total_new_users'] = $this->userModel->where('account_status', 0)->countAllResults();

        $this->data['total_applications'] = 10;

        $openExams = $this->markingModel
            ->where('status', 'open')
            ->findAll();

        if (!empty($openExams)) {
            // Extract exam names
            $examNames = array_column($openExams, 'exam_name');

            // Get unique teacher IDs from results
            $given_subjects = $this->resultModel
                ->distinct()
                ->select('subject_id')
                ->whereIn('exam', $examNames)
                ->findAll();

            $total_subjects = $this->calendarModel
                ->whereIn('subcategory', $examNames)
                ->where('category', 'Exam')
                ->findAll();
        } else {
            $given_subjects = []; // No open exams → no teachers
            $total_subjects = []; // No open exams → no teachers
        }

        // Count teachers safely
        $this->data['givenSubjects'] = count($given_subjects);
        $this->data['totalSubjects'] = count($total_subjects);
        // ✅ Total Income (status = 1 means approved or received)
        $totalIncome = $this->transactionModel
            ->selectSum('amount')
            ->where('status', 0)
            ->get()
            ->getRow()
            ->amount ?? 0;

        // ✅ Total Cost (status = 0 means pending or expense)
        $totalCost = $this->transactionModel
            ->selectSum('amount')
            ->where('status', 1)
            ->get()
            ->getRow()
            ->amount ?? 0;

        // ✅ Assign to $this->data for the view
        $this->data['total_income'] = (float) $totalIncome;
        $this->data['total_cost']   = (float) $totalCost;

        return view('dashboard/index', $this->data);
    }

    public function profile()
    {
        $this->data['title'] = 'Profile';
        $this->data['activeSection'] = 'dashboard';

        $this->data['navbarItems'] = [
            ['label' => 'Dashboard', 'url' => base_url('dashboard')],
            ['label' => 'Calendar', 'url' => base_url('calendar')],
            ['label' => 'Result', 'url' => base_url('ad-result')],
            ['label' => 'Accounts', 'url' => base_url('accounts')],
        ];

        $userId = $this->session->get('user_id');
        // Load model and get teacher data
        $teacher = $this->userModel->find($userId);

        if (!$teacher) {
            // handle case where teacher not found
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Teacher not found");
        }

        // Convert assigned subject IDs to subject names as an array
        $assignedSubjects = [];
        if (!empty($teacher['assagin_sub'])) {
            $subjectModel = new \App\Models\SubjectModel();

            // Handle multiple subjects (comma-separated IDs)
            $subjectIds = explode(',', $teacher['assagin_sub']);

            foreach ($subjectIds as $subId) {
                $sub = $subjectModel->where('id', trim($subId))->first();
                if ($sub) {
                    $assignedSubjects[] = $sub['subject'];
                }
            }
        }

        $teacher['assagin_sub_list'] = $assignedSubjects; // store as array
        $this->data['user'] = $teacher;

        return view('dashboard/profile', $this->data);
    }

    public function profile_id($id)
    {
        $this->data['title'] = 'Profile';
        $this->data['activeSection'] = 'dashboard';

        $this->data['navbarItems'] = [
            ['label' => 'Dashboard', 'url' => base_url('dashboard')],
            ['label' => 'Calendar', 'url' => base_url('calendar')],
            ['label' => 'Result', 'url' => base_url('ad-result')],
            ['label' => 'Accounts', 'url' => base_url('accounts')],
        ];

        $teacher = $this->userModel->find($id);

        if (!$teacher) {
            // handle case where teacher not found
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Teacher not found");
        }

        // Convert assigned subject IDs to subject names as an array
        $assignedSubjects = [];
        if (!empty($teacher['assagin_sub'])) {
            $subjectModel = new \App\Models\SubjectModel();

            // Handle multiple subjects (comma-separated IDs)
            $subjectIds = explode(',', $teacher['assagin_sub']);

            foreach ($subjectIds as $subId) {
                $sub = $subjectModel->where('id', trim($subId))->first();
                if ($sub) {
                    $assignedSubjects[] = $sub['subject'];
                }
            }
        }

        $teacher['assagin_sub_list'] = $assignedSubjects; // store as array
        $this->data['user'] = $teacher;

        return view('dashboard/profile', $this->data);
    }

    public function restrict($id)
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $accountStatus = $this->session->get('account_status');
        if ($accountStatus != 2) {
            return redirect()->back()
                ->with('error', 'You are not a supper admin.');
        } else {
            // restrict user (soft delete by updating account_status to 0)
            if ($this->userModel->update($id, ['account_status' => 0])) {
                return redirect()->back()
                    ->with('success', 'User restricted successfully.');
            } else {
                return redirect()->back()
                    ->with('error', 'Failed to restrict user.');
            }
        }
    }

    public function edit_profile_view($id)
    {
        $this->data['title'] = 'Profile edit';
        $this->data['activeSection'] = 'dashboard';

        $this->data['navbarItems'] = [
            ['label' => 'Dashboard', 'url' => base_url('dashboard')],
            ['label' => 'Calendar', 'url' => base_url('calendar')],
            ['label' => 'Result', 'url' => base_url('ad-result')],
            ['label' => 'Accounts', 'url' => base_url('accounts')],
        ];

        $teacher = $this->userModel->find($id);

        if (!$teacher) {
            // handle case where teacher not found
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Teacher not found");
        }

        $this->data['user'] = $teacher;

        return view('dashboard/edit_profile', $this->data);
    }

    public function update_user($id)
    {

        $socialType    = $this->request->getPost('social_type');
        $socialProfile = $this->request->getPost('social_profile');

        // Add prefix if Facebook
        switch ($socialType) {
            case 'facebook':
                $socialProfile = 'f:' . $socialProfile;
                break;
            case 'youtube':
                $socialProfile = 'y:' . $socialProfile;
                break;
            case 'linkedin':
                $socialProfile = 'l:' . $socialProfile;
                break;
        }

        // Get POST data
        $data = [
            'name'           => $this->request->getPost('name'),
            'subject'        => $this->request->getPost('subject'),
            'gender'         => $this->request->getPost('gender'),
            'phone'          => $this->request->getPost('phone'),
            'email'          => $this->request->getPost('email'),
            'social_profile' => $socialProfile,
            'index_number'     => $this->request->getPost('index_number'),
            'dob'            => $this->request->getPost('dob'),
            'joining_date'    => $this->request->getPost('joining_date'),
            'mpo_date'        => $this->request->getPost('mpo_date'),
            'religion'        => $this->request->getPost('religion'),
            'blood_group'    => $this->request->getPost('blood_group'),
            'bio'              => $this->request->getPost('bio'),
        ];

        $photo = $this->request->getFile('photo');

        $userId = $this->session->get('user_id');
        if ($userId == $id) {
            if ($photo && $photo->isValid() && !$photo->hasMoved()) {
                $newName = $photo->getRandomName();
                $uploadPath = FCPATH . 'uploads/users/';

                // Make sure folder exists
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                // Delete old photo first
                $user = $this->userModel->find($id);
                if ($user && !empty($user['picture'])) {
                    $oldFile = FCPATH . $user['picture'];
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }

                // Move new file
                $photo->move($uploadPath, $newName);
                $data['picture'] = 'uploads/users/' . $newName;
            }


            // Update user
            $this->userModel->update($id, $data);

            // Redirect back with success message
            return redirect()->to(base_url('profile'))
                ->with('success', 'User info updated successfully.');
        } else {
            return redirect()->to(base_url('profile'))
                ->with('error', 'You are not able to update this profile.');
        }
    }

    public function calendar()
    {
        $this->data['title'] = 'Calendar';
        $this->data['activeSection'] = 'calendar';

        // Common navbar and sidebar for all views
        $this->data['navbarItems'] = [
            ['label' => 'Dashboard', 'url' => base_url('dashboard')],
            ['label' => 'Calendar', 'url' => base_url('calendar')],
        ];

        $user = [
            'name' => $this->session->get('name'),
            'email' => $this->session->get('email'),
            'phone' => $this->session->get('phone'),
            'role' => $this->session->get('role')
        ];

        $subjects = $this->subjectModel->findAll();

        $this->data['user'] = $user;
        $this->data['subjects'] = $subjects;

        return view('dashboard/calendar', $this->data);
    }

    public function events()
    {
        $events = $this->calendarModel->findAll();

        $data = array_map(function ($event) {
            $hasTime = strpos($event['end_date'], 'T') !== false;

            $endDate = $hasTime
                ? $event['end_date']
                : date('Y-m-d', strtotime($event['end_date'] . ' +1 day'));

            return [
                'id'          => $event['id'],
                'title'       => $event['title'],
                'start'       => $event['start_date'],
                'end'         => $endDate,
                'color'       => $event['color'],
                'description' => $event['description'],
                'category'    => $event['category'],     // ✅ added
                'subcategory' => $event['subcategory'],  // ✅ added
                'class'       => $event['class'],        // ✅ added
                'subject'     => $event['subject'],      // ✅ added
                'allDay'      => true
            ];
        }, $events);

        return $this->response->setJSON($data);
    }

    public function addEvent()
    {
        $data = [
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'start_date'  => $this->request->getPost('start_date'),
            'start_time'  => $this->request->getPost('start_time'),
            'end_date'    => $this->request->getPost('end_date'),
            'end_time'    => $this->request->getPost('end_time'),
            'color'       => $this->request->getPost('color') ?? '#007bff',
            'category'    => $this->request->getPost('category'),
            'subcategory' => $this->request->getPost('subcategory'),
            'class'       => $this->request->getPost('class'),
            'subject'     => $this->request->getPost('subject')
        ];

        $this->calendarModel->save($data);
        return $this->response->setJSON(['status' => 'success']);
    }

    public function updateEvent()
    {
        $id = $this->request->getPost('id');

        $data = [
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'start_date'  => $this->request->getPost('start_date'),
            'start_time'  => $this->request->getPost('start_time'),
            'end_date'    => $this->request->getPost('end_date'),
            'end_time'    => $this->request->getPost('end_time'),
            'color'       => $this->request->getPost('color') ?? '#007bff',
            'category'    => $this->request->getPost('category'),
            'subcategory' => $this->request->getPost('subcategory'),
            'class'       => $this->request->getPost('class'),
            'subject'     => $this->request->getPost('subject')
        ];

        $this->calendarModel->update($id, $data);
        return $this->response->setJSON(['status' => 'success']);
    }

    public function deleteEvent()
    {

        $this->calendarModel->delete($this->request->getPost('id'));

        return $this->response->setJSON(['status' => 'success']);
    }

    public function teachers()
    {

        $this->data['title'] = 'Teacher Management';
        $this->data['activeSection'] = 'teacher';

        // Common navbar and sidebar for all views
        $this->data['navbarItems'] = [
            ['label' => 'Teacher List', 'url' => base_url('teacher_management')],
            ['label' => 'Marking Action', 'url' => base_url('marking_open')],
        ];



        $users = $this->userModel
            ->where('account_status !=', 0)
            ->orderBy('position', 'ASC')
            ->findAll();
        $totalUsers = count($users);

        // Assign to $this->data
        $this->data['users'] = $users;
        $this->data['total_users'] = $totalUsers;

        return view('dashboard/ad_teacher_list', $this->data);
    }

    public function teachers_mark_given()
    {
        $this->data['title'] = 'Teacher Management';
        $this->data['activeSection'] = 'teacher';

        $this->data['navbarItems'] = [
            ['label' => 'Teacher List', 'url' => base_url('teacher_management')],
            ['label' => 'Marking Action', 'url' => base_url('marking_open')],
        ];

        $openExams = $this->markingModel->where('status', 'open')->findAll();

        $joint_data = [];

        if (!empty($openExams)) {
            $examNames = array_column($openExams, 'exam_name');
            $currentYear = date('Y');

            // Get all events/subjects
            $builder = $this->calendarModel->db->table('events e');
            $builder->select('e.class, YEAR(e.start_date) AS year, e.subcategory, s.subject, s.id AS subject_id');
            $builder->join('subjects s', 'e.subject = s.id');
            $builder->whereIn('e.subcategory', $examNames);
            $builder->where('YEAR(e.start_date)', $currentYear);
            $builder->orderBy('s.id', 'ASC');

            $calendarSubjects = $builder->get()->getResultArray();

            if (!empty($calendarSubjects)) {
                $subjectIds = array_column($calendarSubjects, 'subject_id');

                // Get all teachers for these subjects
                $builder = $this->userModel->select('id AS user_id, name, subject, phone, position, assagin_sub, picture');
                $builder->groupStart();
                foreach ($subjectIds as $subjectId) {
                    $builder->orWhere("FIND_IN_SET($subjectId, assagin_sub) >", 0, false);
                }
                $builder->groupEnd();

                $teachers = $builder->findAll();

                // Map teachers to subjects
                $teachersBySubject = [];
                foreach ($teachers as $teacher) {
                    $assignedSubjects = explode(',', $teacher['assagin_sub']);
                    foreach ($assignedSubjects as $subId) {
                        $subId = trim($subId);
                        if (!isset($teachersBySubject[$subId])) {
                            $teachersBySubject[$subId] = [];
                        }
                        $teachersBySubject[$subId][] = $teacher;
                    }
                }

                // Merge teachers and calculate progress
                foreach ($calendarSubjects as $event) {
                    $subId = $event['subject_id'];
                    $teachersList = $teachersBySubject[$subId] ?? [['user_id' => null, 'name' => 'No teacher assign', 'phone' => '', 'picture' => '']];

                    foreach ($teachersList as $teacher) {
                        // Count total students & marks entered
                        if ($teacher['user_id'] === null) {
                            $marks_entered = 0;
                            $total_rows = 0;
                            $progress = 0;
                        } else {
                            $results = $this->resultModel
                                ->where('teacher_id', $teacher['user_id'])
                                ->where('subject_id', $subId)
                                ->where('class', $event['class'])
                                ->where('year', $event['year'])
                                ->whereIn('exam', $examNames)
                                ->findAll();

                            $total_rows = count($results);
                            $marks_entered = count(array_filter($results, fn($r) => !is_null($r['total'])));
                            $progress = $total_rows > 0 ? round(($marks_entered / $total_rows) * 100) : 0;
                        }

                        $joint_data[] = [
                            'subject' => $event,
                            'teacher' => $teacher,
                            'total_rows' => $total_rows,
                            'marks_entered' => $marks_entered,
                            'progress' => $progress,
                            'exam'          => $event['subcategory'],
                        ];
                    }
                }
            }
        }
        // echo "<pre>";
        // print_r($joint_data);
        // echo "</pre>";
        $this->data['joint_data'] = $joint_data;
        return view('dashboard/mark_given_teacher_list', $this->data);
    }

    public function updatePosition($id)
    {
        $position = $this->request->getPost('position');

        if ($position === null) {
            return redirect()->back()->with('error', 'Please select a position.');
        }

        $this->userModel->update($id, ['position' => $position]);

        return redirect()->back()->with('success', 'Position updated successfully.');
    }

    public function newUser()
    {

        $this->data['title'] = 'Teacher Management';
        $this->data['activeSection'] = 'teacher';

        // Common navbar and sidebar for all views
        $this->data['navbarItems'] = [
            ['label' => 'Teacher List', 'url' => base_url('teacher_management')],
            ['label' => 'Marking Action', 'url' => base_url('marking_open')],
        ];
        $newUsers = $this->userModel
            ->where('account_status', 0)
            ->findAll();

        $this->data['newUse'] = $newUsers;
        $this->data['total_newUse'] = count($newUsers);
        return view('dashboard/ad_new_user', $this->data);
    }

    public function user_permit($id)
    {
        $permitBy = $this->session->get('user_id');

        $updated = $this->userModel->update($id, [
            'account_status' => 1,
            'permit_by'    => $permitBy,
        ]);

        if ($updated) {
            return redirect()->back()->with('success', 'User approved successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to approve user.');
        }
    }

    public function user_delete($id)
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        // delete user where id = $id
        if ($this->userModel->delete($id)) {
            // success message
            return redirect()->back()
                ->with('success', 'User deleted successfully.');
        } else {
            // fail message
            return redirect()->back()
                ->with('error', 'Failed to delete user.');
        }
    }

    public function teacher_management()
    {
        $subjects = $this->subjectModel->orderBy('id')->findAll();
        $users    = $this->userModel
            ->where('account_status !=', 0)
            ->orderBy('position', 'ASC')
            ->findAll();

        // Use $this->data which already has navbarItems, sidebarItems
        $this->data['title'] = 'Teacher Management';
        $this->data['activeSection'] = 'teacher';
        $this->data['navbarItems'] = [
            ['label' => 'Teacher List', 'url' => base_url('teacher_management')],
            ['label' => 'Marking Action', 'url' => base_url('marking_open')],
        ];
        $this->data['users'] = $users;
        $this->data['subjects'] = $subjects;

        return view('dashboard/teacher_management', $this->data);
    }

    public function teacherSubUpdate()
    {
        $id         = $this->request->getPost('id');
        $name       = $this->request->getPost('name');
        $assign_sub = $this->request->getPost('assign_sub'); // e.g., "4,7,9"



        $data = [
            'assagin_sub' => $assign_sub,  // store CSV in DB
        ];

        $this->userModel->update($id, $data);

        return redirect()->back()->with('success', 'Teacher updated with new subjects!');
    }


    public function assignSubject($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'No records found.');
        }

        $subjectIds = array_filter(
            array_map('intval', explode(',', $user['assagin_sub'] ?? ''))
        );

        $subjects = [];
        if (!empty($subjectIds)) {
            $subjects = $this->subjectModel
                ->whereIn('id', $subjectIds)
                ->orderBy('class', 'ASC')
                ->findAll();
        }

        // Use $this->data to avoid repeating common layout data
        $this->data['title']         = 'Assign Subject';
        $this->data['activeSection'] = 'teacher';
        $this->data['navbarItems']   = [
            ['label' => 'Teacher List', 'url' => base_url('teacher_management')],
            ['label' => 'Marking Action', 'url' => base_url('marking_open')],
        ];
        $this->data['user']          = $user;
        $this->data['subjects']      = $subjects;

        return view('dashboard/assign_subject', $this->data);
    }


    public function marking_open()
    {
        $this->data['title'] = 'Teacher Management';
        $this->data['activeSection'] = 'teacher';

        // Navbar
        $this->data['navbarItems'] = [
            ['label' => 'Teacher List', 'url' => base_url('teacher_management')],
            ['label' => 'Marking Action', 'url' => base_url('marking_open')],
        ];

        // 1️⃣ Get all distinct exam names from calendar
        $examNames = $this->calendarModel
            ->select('subcategory')
            ->distinct()
            ->orderBy('subcategory', 'ASC')
            ->findAll();

        // 2️⃣ Check status (open/closed) for each exam
        $examStatus = [];
        foreach ($examNames as $exam) {
            $examName = $exam['subcategory'];

            // Get status from markingModel
            $mark = $this->markingModel
                ->select('status')
                ->where('exam_name', $examName)
                ->first();

            $examStatus[] = [
                'exam_name' => $examName,
                'status'    => $mark['status'] ?? 'closed'  // default to closed
            ];
        }

        // Pass to view
        $this->data['exam_name'] = $examStatus;

        return view('dashboard/marking_open', $this->data);
    }

    public function processMarkingOpen()
    {
        $examNames = $this->request->getPost('exam_name'); // array of selected exams
        $status    = $this->request->getPost('status');    // single status for all

        if (empty($examNames)) {
            return redirect()->back()->with('error', 'Please select at least one exam!');
        }

        $markingModel = new MarkingOpenModel();

        foreach ($examNames as $examName) {
            $exists = $markingModel->where('exam_name', $examName)->first();
            if ($exists) {
                $markingModel->update($exists['id'], ['status' => $status]);
            } else {
                $markingModel->insert([
                    'exam_name' => $examName,
                    'status'    => $status
                ]);
            }
        }

        return redirect()->to(base_url('marking_open'))
            ->with('success', 'Selected exams saved successfully.');
    }

    public function createStudentForm()
    {
        $this->data['title'] = 'Register Student';
        $this->data['activeSection'] = 'student';
        $this->data['navbarItems']   = [
            ['label' => 'Student List', 'url' => base_url('admin/student')],
            ['label' => 'Add Student', 'url' => base_url('admin/student/create')],
            ['label' => 'Assagin Subject', 'url' => base_url('admin/stAssaginSubView')],
            ['label' => 'Deleted Student', 'url' => base_url('admin/deletedStudent')],
        ];
        return view('dashboard/student_form', $this->data);
    }

    public function saveStudent()
    {
        helper(['form']);

        $rules = [
            'student_name' => 'required',
            'roll'         => 'required|numeric',
            'class'        => 'required',
            'section'      => 'permit_empty',
            'esif'         => 'required',
            'father_name'  => 'required',
            'mother_name'  => 'required',
            'dob'          => 'required|valid_date',
            'gender'       => 'required',
            'phone'        => 'required',
            'student_pic'  => 'uploaded[student_pic]|is_image[student_pic]',
            'birth_registration_number' => 'required',
            'father_nid_number'         => 'required',
            'mother_nid_number'         => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Handle student picture
        $file = $this->request->getFile('student_pic');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move('uploads/students', $fileName);
        } else {
            return redirect()->back()->withInput()->with('errors', ['student_pic' => 'File upload failed.']);
        }

        // Prepare student data
        $data = [
            'student_name' => $this->request->getPost('student_name'),
            'roll'         => $this->request->getPost('roll'),
            'class'        => $this->request->getPost('class'),
            'section'      => $this->request->getPost('section'),
            'esif'         => $this->request->getPost('esif'),
            'father_name'  => $this->request->getPost('father_name'),
            'mother_name'  => $this->request->getPost('mother_name'),
            'dob'          => $this->request->getPost('dob'),
            'gender'       => $this->request->getPost('gender'),
            'phone'        => $this->request->getPost('phone'),
            'student_pic'  => 'uploads/students/' . $fileName,
            'birth_registration_number' => $this->request->getPost('birth_registration_number'),
            'father_nid_number'         => $this->request->getPost('father_nid_number'),
            'mother_nid_number'         => $this->request->getPost('mother_nid_number'),
        ];

        // Save to DB
        $this->studentModel->insert($data);

        return redirect()->to(site_url('admin/student/create'))->with('success', 'Student registered successfully!');
    }

    public function student()
    {
        // Get filter inputs
        $q        = $this->request->getGet('q');
        $class    = $this->request->getGet('class');
        $section  = $this->request->getGet('section');
        $religion = $this->request->getGet('religion');
        $gender   = $this->request->getGet('gender'); // ✅ separate variable

        // Distinct religions
        $religions = $this->studentModel
            ->select('religion')
            ->distinct()
            ->where('religion IS NOT NULL')
            ->orderBy('religion')
            ->findAll();

        // Distinct genders
        $genders = $this->studentModel
            ->select('gender')
            ->distinct()
            ->where('gender IS NOT NULL')
            ->orderBy('gender')
            ->findAll();

        // Build query
        $builder = $this->studentModel;

        // Always apply permission filter
        $builder = $builder->where('permission', 0);

        if ($q) {
            $builder = $builder->groupStart()
                ->like('student_name', $q)
                ->orLike('roll', $q)
                ->orLike('id', $q)
                ->groupEnd();
        }
        if ($class) {
            $builder = $builder->where('class', $class);
        }
        if ($section) {
            $builder = $builder->where('section', $section);
        }
        if ($religion) {
            if ($religion === '__NULL__') {
                $builder = $builder->where('religion IS NULL'); // ✅ Matches "Not Set"
            } else {
                $builder = $builder->where('religion', $religion);
            }
        }
        if ($gender) {
            if ($gender === '__NULL__') {
                $builder = $builder->where('gender IS NULL'); // ✅ Matches "Not Set"
            } else {
                $builder = $builder->where('gender', $gender);
            }
        }

        $total = $builder->countAllResults(false);
        $perPage  = 20;
        $students = $builder
            ->orderBy('CAST(class as UNSIGNED) ASC')
            ->orderBy('CAST(roll as UNSIGNED) ASC')
            ->paginate($perPage, 'bootstrap');

        $sections = $this->studentModel->select('section')->distinct()->orderBy('section')->findAll();

        $this->data['title']         = 'Student Management';
        $this->data['activeSection'] = 'student';
        $this->data['navbarItems']   = [
            ['label' => 'Student List', 'url' => base_url('admin/student')],
            ['label' => 'Add Student', 'url' => base_url('admin/student/create')],
            ['label' => 'Assagin Subject', 'url' => base_url('admin/stAssaginSubView')],
            ['label' => 'Deleted Student', 'url' => base_url('admin/deletedStudent')],
        ];
        $this->data['students']   = $students;
        $this->data['pager']      = $this->studentModel->pager;
        $this->data['q']          = $q;
        $this->data['class']      = $class;
        $this->data['section']    = $section;
        $this->data['sections']   = $sections;
        $this->data['religion']   = $religion;
        $this->data['religions']  = $religions;
        $this->data['gender']     = $gender;   // ✅ new
        $this->data['genders']    = $genders;  // ✅ new
        $this->data['total']      = $total;

        return view('dashboard/student', $this->data);
    }

    public function softDelete($id)
    {

        // Get current student
        $student = $this->studentModel->find($id);

        if ($student) {

            // Update student
            $this->studentModel->update($id, ['permission' => 1]);

            return redirect()->back()->with('success', 'Permission updated successfully');
        }

        return redirect()->back()->with('error', 'Student not found');
    }

    public function hardDelete($id)
    {
        // Load student record
        $student = $this->studentModel->find($id);

        if ($student) {
            // Check if student has a photo
            if (!empty($student['student_pic'])) {
                // Build full path to the file
                $photoPath = FCPATH . $student['student_pic'];

                // If file exists, delete it
                if (file_exists($photoPath)) {
                    unlink($photoPath);
                }
            }

            // Delete student record from database
            $this->studentModel->delete($id);

            // Redirect with success message
            return redirect()->back()->with('success', 'Student and picture deleted successfully.');
        }

        // If student not found
        return redirect()->back()->with('error', 'Student not found.');
    }

    public function deleted_student()
    {


        // Get filter inputs
        $q       = $this->request->getGet('q');
        $class   = $this->request->getGet('class');
        $section = $this->request->getGet('section');
        $religion = $this->request->getGet('religion');
        $religions = $this->studentModel
            ->select('religion')
            ->distinct()
            ->where('religion IS NOT NULL')
            ->orderBy('religion')
            ->findAll();
        // Build query
        $builder = $this->studentModel;

        // Always apply permission filter
        $builder = $builder->where('permission', 1);

        if ($q) {
            $builder = $builder->groupStart()
                ->like('student_name', $q)
                ->orLike('roll', $q)
                ->orLike('id', $q)
                ->groupEnd();
        }
        if ($class) {
            $builder = $builder->where('class', $class);
        }
        if ($section) {
            $builder = $builder->where('section', $section);
        }
        if ($religion) {
            if ($religion === '__NULL__') {
                $builder = $builder->where('religion IS NULL'); // ✅ Matches "Not Set"
            } else {
                $builder = $builder->where('religion', $religion);
            }
        }
        $total = $builder->countAllResults(false);
        $perPage  = 20;
        $students = $builder
            ->orderBy('CAST(class as UNSIGNED) ASC')
            ->orderBy('CAST(roll as UNSIGNED) ASC')
            ->paginate($perPage, 'bootstrap');

        $sections = $this->studentModel->select('section')->distinct()->orderBy('section')->findAll();

        $this->data['title']         = 'Student Management';
        $this->data['activeSection'] = 'student';
        $this->data['navbarItems']   = [
            ['label' => 'Student List', 'url' => base_url('admin/student')],
            ['label' => 'Add Student', 'url' => base_url('admin/student/create')],
            ['label' => 'Assagin Subject', 'url' => base_url('admin/stAssaginSubView')],
            ['label' => 'Deleted Student', 'url' => base_url('admin/deletedStudent')],
        ];
        $this->data['students']      = $students;
        $this->data['pager']         = $this->studentModel->pager;
        $this->data['q']             = $q;
        $this->data['class']         = $class;
        $this->data['section']       = $section;
        $this->data['sections']      = $sections;
        $this->data['religion']   = $religion;
        $this->data['religions']  = $religions;
        $this->data['total']  = $total;



        return view('dashboard/deleted_student', $this->data);
    }

    public function softActive($id)
    {

        // Get current student
        $student = $this->studentModel->find($id);

        if ($student) {

            // Update student
            $this->studentModel->update($id, ['permission' => 0]);

            return redirect()->back()->with('success', 'Permission updated successfully');
        }

        return redirect()->back()->with('error', 'Student not found');
    }

    public function stAssaginSubView()
    {


        // Get filter inputs
        $q       = $this->request->getGet('q');
        $class   = $this->request->getGet('class');
        $section = $this->request->getGet('section');
        $religion = $this->request->getGet('religion');

        // Build query
        $builder = $this->studentModel;
        $builder = $builder->where('permission', 0);
        if ($q) {
            $builder = $builder->groupStart()
                ->like('student_name', $q)
                ->orLike('roll', $q)
                ->orLike('id', $q)
                ->groupEnd();
        }
        if ($class) {
            $builder = $builder->where('class', $class);
        }
        if ($section) {
            $builder = $builder->where('section', $section);
        }
        if ($religion) {
            $builder = $builder->where('religion', $religion);
        }

        $students = $builder
            ->orderBy('CAST(class as UNSIGNED)', 'ASC')
            ->orderBy('CAST(roll as UNSIGNED)', 'ASC')
            ->get()
            ->getResultArray();

        $sections = $this->studentModel->select('section')->distinct()->orderBy('section')->findAll();
        $religions = $this->studentModel->select('religion')->distinct()->where('religion IS NOT NULL')->orderBy('religion')->findAll();
        $subjectBuilder = $this->subjectModel;

        if ($class) {
            $subjectBuilder = $subjectBuilder->where('class', $class);
        }

        if (stripos($section, 'Vocational') !== false) {
            $filteredSection = 'Vocational';
        } else {
            $filteredSection = 'General';
        }

        if ($filteredSection) {
            $subjectBuilder = $subjectBuilder->where('section', $filteredSection);
        }

        $subjects = $subjectBuilder->findAll();

        $this->data['title']         = 'Student Subject Management';
        $this->data['activeSection'] = 'student';
        $this->data['navbarItems']   = [
            ['label' => 'Student List', 'url' => base_url('admin/student')],
            ['label' => 'Add Student', 'url' => base_url('admin/student/create')],
            ['label' => 'Assagin Subject', 'url' => base_url('admin/stAssaginSubView')],
            ['label' => 'Deleted Student', 'url' => base_url('admin/deletedStudent')],
        ];
        $this->data['students']      = $students;
        $this->data['subjects']      = $subjects;
        $this->data['pager']         = $this->studentModel->pager;
        $this->data['q']             = $q;
        $this->data['class']         = $class;
        $this->data['section']       = $section;
        $this->data['sections']      = $sections;
        $this->data['religion']      = $religion;
        $this->data['religions']     = $religions;

        return view('dashboard/stSubAssaginment', $this->data);
    }

    public function assignStudentsSubjects()
    {
        $students = $this->request->getPost('left_select');
        $subjects = $this->request->getPost('right_select');

        if (!empty($students) && !empty($subjects)) {
            $subjectCodes = implode(',', $subjects);
            $studentModel = new StudentModel();

            foreach ($students as $studentId) {
                $studentModel->update($studentId, ['assign_sub' => $subjectCodes]);
            }
            return redirect()->back()->with('success', 'Subjects assigned successfully.');
        }
        return redirect()->back()->with('error', 'Please select at least one student and one subject.');
    }

    public function exam_name($userId, $subjectId)
    {
        $this->data['title']         = 'Select Exam';
        $this->data['activeSection'] = 'teacher';
        $this->data['navbarItems']   = [
            ['label' => 'Teacher List', 'url' => base_url('teacher_management')],
            ['label' => 'Marking Action', 'url' => base_url('marking_open')],
        ];
        $this->data['user_id']    = $userId;
        $this->data['subject_id'] = $subjectId;

        // ✅ fetch all exams where status is open (id + exam_name only)
        $this->data['exams'] = $this->markingModel
            ->select('id, exam_name')
            ->where('status', 'open')
            ->findAll();

        return view('dashboard/exam_name', $this->data);
    }

    public function result()
    {
        $userId     = $this->request->getPost('user_id');
        $subjectId  = $this->request->getPost('subject_id');
        $exam_name  = $this->request->getPost('exam_name');


        $user    = $this->userModel->find($userId);
        $subject = $this->subjectModel->find($subjectId);
        $class = $subject['class'];

        if (!$user) {
            return redirect()->back()->with('error', 'User data is not Found.');
        } elseif (!$subject) {
            return redirect()->back()->with('error', 'Subject is not found.');
        } elseif (!$exam_name) {
            return redirect()->back()->with('error', 'No Exam is selected.');
        } elseif (($exam_name == 'Pre-Test Exam' || $exam_name == 'Test Exam') && $class != 10) {
            return redirect()->back()
                ->with('error', $exam_name . ' is not allowed for class ' . $class);
        }

        $students = $this->studentModel
            ->where("FIND_IN_SET(" . (int)$subjectId . ", assign_sub) >", 0, false)
            ->where('permission', 0)
            ->orderBy('CAST(roll AS UNSIGNED)', 'ASC', false)
            ->findAll();

        // 🔄 Load existing results for this teacher and subject
        $results = $this->resultModel
            ->where('teacher_id', $userId)
            ->where('subject_id', $subjectId)
            ->where('exam', $exam_name)
            ->where('year', date('Y')) // optional filter
            ->findAll();

        // 🔃 Index results by student_id for quick lookup
        $indexedResults = [];
        foreach ($results as $r) {
            $indexedResults[$r['student_id']] = $r;
        }

        $this->data['title']           = 'Result Entry';
        $this->data['activeSection']   = 'teacher';
        $this->data['navbarItems']     = [
            ['label' => 'Teacher List', 'url' => base_url('teacher_management')],
            ['label' => 'Marking Open', 'url' => base_url('marking_open')],
        ];
        $this->data['user']            = $user;
        $this->data['subject']         = $subject;
        $this->data['exam_name']         = $exam_name;
        $this->data['students']        = $students;
        $this->data['existingResults'] = $indexedResults;

        return view('dashboard/ad_result', $this->data);
    }

    public function submitResults()
    {
        $students   = $this->request->getPost('students');
        $exam       = $this->request->getPost('exam');
        $year       = $this->request->getPost('year');
        $subjectId  = $this->request->getPost('subject_id');
        $teacherId  = $this->request->getPost('teacher_id');
        $class     = $this->request->getPost('class');

        if (!$students || !$exam || !$year || !$subjectId  || !$teacherId || !$class) {
            return redirect()->back()->with('error', 'Missing data.');
        }

        foreach ($students as $student) {
            $written   = isset($student['written']) ? (int)$student['written'] : 0;
            $mcq       = isset($student['mcq']) ? (int)$student['mcq'] : 0;
            $practical = isset($student['practical']) ? (int)$student['practical'] : 0;
            $total     = $written + $mcq + $practical;

            $existing = $this->resultModel
                ->where('student_id', $student['id'])
                ->where('subject_id', $subjectId)
                ->where('exam', $exam)
                ->where('year', $year)
                ->first();

            $data = [
                'student_id' => $student['id'],
                'subject_id' => $subjectId,
                'exam'       => $exam,
                'year'       => $year,
                'class'      => $class,
                'written'    => $written,
                'mcq'        => $mcq,
                'practical'  => $practical,
                'total'      => $total,
                'teacher_id' => $teacherId,
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            if ($existing) {
                $this->resultModel->update($existing['id'], $data);
            } else {
                $data['created_at'] = date('Y-m-d H:i:s');
                $this->resultModel->insert($data);
            }
        }

        return redirect()->to(base_url('exam_name/' . $teacherId . '/' . $subjectId))
            ->with('success', 'Results submitted successfully.');
    }

    public function exam_name_result_check($userId, $subjectId)
    {
        $this->data['title']         = 'Select Exam';
        $this->data['activeSection'] = 'teacher';
        $this->data['navbarItems']   = [
            ['label' => 'Teacher List', 'url' => base_url('teacher_management')],
            ['label' => 'Marking Action', 'url' => base_url('marking_open')],
        ];
        $this->data['user_id']    = $userId;
        $this->data['subject_id'] = $subjectId;

        // ✅ fetch all exams where status is open (id + exam_name only)
        $this->data['exams'] = $this->markingModel
            ->select('id, exam_name')
            ->where('status', 'open')
            ->findAll();

        return view('dashboard/exam_name_result_check', $this->data);
    }

    public function ResultCheck()
    {
        $userId     = $this->request->getPost('user_id');
        $subjectId  = $this->request->getPost('subject_id');
        $exam_name  = $this->request->getPost('exam_name');

        $subject = $this->subjectModel->find($subjectId);
        $users    = $this->userModel->find($userId);

        $class = $subject['class'];

        if (!$users) {
            return redirect()->back()->with('error', 'User data is not Found.');
        } elseif (!$subject) {
            return redirect()->back()->with('error', 'Subject is not found.');
        } elseif (!$exam_name) {
            return redirect()->back()->with('error', 'No Exam is selected.');
        } elseif (($exam_name == 'Pre-Test Exam' || $exam_name == 'Test Exam') && $class != 10) {
            return redirect()->back()
                ->with('error', $exam_name . ' is not allowed for class ' . $class);
        }

        $result = $this->resultModel
            ->select('results.*, students.student_name, students.roll, students.class')
            ->join('students', 'students.id = results.student_id')
            ->where('results.subject_id', $subjectId)
            ->where('results.teacher_id', $userId)
            ->where('results.exam', $exam_name)
            ->orderBy('CAST(students.roll AS UNSIGNED)', 'ASC', false)
            ->findAll();


        $this->data['title'] = 'Student Details';
        $this->data['activeSection'] = 'teacher';
        $this->data['navbarItems'] = [
            ['label' => 'Teacher List', 'url' => base_url('teacher_management')],
            ['label' => 'Marking Action', 'url' => base_url('marking_open')],
        ];
        $this->data['subject'] = $subject;
        $this->data['users'] = $users;
        $this->data['result'] = $result;

        return view('dashboard/resultCheck', $this->data);
    }

    public function selectTabulationForm()
    {


        // ✅ Distinct class list from students
        $classes = $this->studentModel->distinct()->select('class')->orderBy('class', 'ASC')->findAll();

        $rawSections = $this->studentModel
            ->distinct()
            ->select('section')
            ->orderBy('section', 'ASC')
            ->findAll();

        $sections = [
            ['section' => 'General'],
            ['section' => 'Vocational'],
            ['section' => 'Science'],
            ['section' => 'arts'],
        ];


        // ✅ Distinct exam names and years from results
        $exams = $this->resultModel->distinct()->select('exam')->orderBy('exam', 'ASC')->findAll();
        $years = $this->resultModel->distinct()->select('year')->orderBy('year', 'DESC')->findAll();
        // Send to view
        $this->data['title']    = 'Select Tabulation Info';
        $this->data['activeSection'] = 'result';
        $this->data['navbarItems'] = [
            ['label' => 'Tabulation Sheet', 'url' => base_url('admin/tabulation_form')],
            ['label' => 'Marksheet', 'url' => base_url('admin/select-marksheet')],
        ];
        $this->data['classes']  = $classes;
        $this->data['sections'] = $sections;
        $this->data['exams']    = $exams;
        $this->data['years']    = $years;

        return view('dashboard/select_exam_info', $this->data);
    }

    public function mark()
    {
        // Pass data to the view
        $this->data['title']     = 'Tabulation Sheet';
        $this->data['activeSection'] = 'result';
        $this->data['navbarItems'] = [
            ['label' => 'Tabulation Sheet', 'url' => base_url('admin/tabulation_form')],
            ['label' => 'Marksheet', 'url' => base_url('admin/select-marksheet')],
            ['label' => 'Marksheet', 'url' => base_url('admin/tabulation/download')],
        ];


        $class   = $this->request->getPost('class');
        $section = $this->request->getPost('section');
        $exam    = $this->request->getPost('exam');
        $year    = $this->request->getPost('year');


        $builder = $this->studentModel->where('class', $class);

        // If class is NOT 6 to 8, add section filter
        if (!in_array($class, ['6', '7', '8'])) {
            $builder->like('section', $section);
        }

        $students = $builder
            ->orderBy('CAST(roll AS UNSIGNED)', 'ASC', false)
            ->where('permission', 0)
            ->findAll();

        $finalData = [];

        foreach ($students as $student) {
            $studentId = $student['id'];

            // Step 2: Get results for this student, exam, and year
            $results = $this->resultModel
                ->where('student_id', $studentId)
                ->where('exam', $exam)
                ->where('year', $year)
                ->findAll();

            // Step 3: Build subject-wise results array
            $subjectResults = [];
            foreach ($results as $res) {
                $subjectName = $this->subjectModel
                    ->select('subject')
                    ->where('id', $res['subject_id'])
                    ->first()['subject'] ?? 'Unknown';

                $subjectResults[] = [
                    'subject_id' => $res['subject_id'],
                    'subject'   => $subjectName,
                    'written'   => $res['written'] ?? 0,
                    'mcq'       => $res['mcq'] ?? 0,
                    'practical' => $res['practical'] ?? 0,
                    'total'     => $res['total'] ?? 0,
                ];
            }

            usort($subjectResults, function ($a, $b) {
                return $a['subject_id'] <=> $b['subject_id'];
            });

            // Step 4: Append student data with their results
            $finalData[] = [
                'student_id' => $student['id'],
                'name'       => $student['student_name'] ?? 'Unknown',
                'roll'       => $student['roll'],
                'group'      => $section ?? 'general',
                'exam'       => $exam,
                'year'       => $year,
                'results'    => $subjectResults,
            ];
        }
        $this->data['finalData'] = $finalData;
        $this->data['class']     = $class;
        $this->data['exam']      = $exam;
        $this->data['year']      = $year;
        // echo '<pre>';
        // print_r($finalData);
        // echo '</pre>';
        return view('dashboard/mark_copy', $this->data);
    }



    public function selectMarksheetForm()
    {

        $classes = $this->studentModel->distinct()->select('class')->orderBy('class', 'ASC')->findAll();
        $sections = [
            ['section' => 'general'],
            ['section' => 'vocational'],
        ];
        $exams = $this->resultModel->distinct()->select('exam')->orderBy('exam', 'ASC')->findAll();
        $years = $this->resultModel->distinct()->select('year')->orderBy('year', 'DESC')->findAll();

        $this->data['title']         = 'Select Marksheet Info';
        $this->data['activeSection'] = 'result';
        $this->data['navbarItems'] = [
            ['label' => 'Tabulation Sheet', 'url' => base_url('admin/tabulation_form')],
            ['label' => 'Marksheet', 'url' => base_url('admin/select-marksheet')],
        ];
        $this->data['classes']       = $classes;
        $this->data['sections']      = $sections;
        $this->data['exams']         = $exams;
        $this->data['years']         = $years;

        return view('dashboard/select_marksheet_info', $this->data);
    }


    public function markToGrade(float $percentage): array
    {
        if ($percentage >= 80) return ['grade' => 'A+', 'gp' => 5.00];
        if ($percentage >= 70) return ['grade' => 'A',  'gp' => 4.00];
        if ($percentage >= 60) return ['grade' => 'A-', 'gp' => 3.50];
        if ($percentage >= 50) return ['grade' => 'B',  'gp' => 3.00];
        if ($percentage >= 40) return ['grade' => 'C',  'gp' => 2.00];
        if ($percentage >= 33) return ['grade' => 'D',  'gp' => 1.00];
        return ['grade' => 'F', 'gp' => 0.00];
    }

    public function branchCheck($mark, $passMark)
    {
        return ($mark >= $passMark);
    }

    private function normalizeSubject(string $subject): string
    {
        $subject = strtolower(trim($subject));

        // ---- Core Subjects ----
        if (str_contains($subject, 'bangla')) return 'bangla';
        if (str_contains($subject, 'english')) return 'english';
        if (str_contains($subject, 'physics')) return 'physics';
        if (str_contains($subject, 'chemistry')) return 'chemistry';
        if (str_contains($subject, 'biology')) return 'biology';
        if (str_contains($subject, 'higher mathematics')) return 'higher_math';
        if (str_contains($subject, 'mathematics')) return 'math';
        if (str_contains($subject, 'ict')) return 'ict';

        // ---- Religion ----
        if (
            str_contains($subject, 'religion') ||
            str_contains($subject, 'islamic studies') ||
            str_contains($subject, 'hindu religion')
        ) {
            return 'religion';
        }

        // ---- Bangladesh & Global Studies ----
        if (
            str_contains($subject, 'bangladesh') ||
            str_contains($subject, 'global studies')
        ) {
            return 'bgs';
        }

        // ---- Vocational / Technical ----
        if (
            str_contains($subject, 'computer application')
        ) {
            return 'computer';
        }

        if (
            str_contains($subject, 'it support') ||
            str_contains($subject, 'iot')
        ) {
            return 'it_iot';
        }

        if (
            str_contains($subject, 'food processing')
        ) {
            return 'food_processing';
        }

        if (
            str_contains($subject, 'agriculture')
        ) {
            return 'agriculture';
        }

        // ---- Fallback ----
        return 'general';
    }

    public function resultManipulation($class, $section, $subject, $wri, $mcq, $pra, $mark)
    {
        echo $subject . "==<br>";
        $section = strtolower($section);
        $key     = $this->normalizeSubject($subject);
        echo $key . "<br>";

        // ---------------- CLASS 9–10 (GENERAL) ----------------
        if (in_array($class, [9, 10]) && strpos($section, 'vocational') === false) {

            // Bangla (1st + 2nd combined handled outside)
            if ($key === 'bangla') {
                return ($this->branchCheck($wri, 46) && $this->branchCheck($mcq, 20))
                    ? $this->markToGrade($mark)
                    : ['grade' => 'F', 'gp' => 0.00];
            }

            // English
            if ($key === 'english') {
                return $this->branchCheck($wri, 66)
                    ? $this->markToGrade($mark)
                    : ['grade' => 'F', 'gp' => 0.00];
            }

            // ICT
            if ($key === 'ict') {
                return ($this->branchCheck($wri + $mcq, 7) && $this->branchCheck($pra, 8))
                    ? $this->markToGrade($mark)
                    : ['grade' => 'F', 'gp' => 0.00];
            }

            // Science subjects
            if (in_array($key, ['physics', 'chemistry', 'biology', 'higher_math'])) {



                return ($this->branchCheck($wri, 17)
                    && $this->branchCheck($mcq, 8)
                    && $this->branchCheck($pra, 8))
                    ? $this->markToGrade($mark)
                    : ['grade' => 'F', 'gp' => 0.00];
            }

            // Other subjects
            return ($this->branchCheck($wri, 23) && $this->branchCheck($mcq, 10))
                ? $this->markToGrade($mark)
                : ['grade' => 'F', 'gp' => 0.00];
        } else {
            if (in_array($key, ['physics', 'chemistry', 'bgs'])) {
                return ($this->branchCheck($wri, 10))
                    ? $this->markToGrade($mark)
                    : ['grade' => 'F', 'gp' => 0.00];
            }
            if ($key === 'computer') {
                return ($this->branchCheck($pra, 17))
                    ? $this->markToGrade($mark)
                    : ['grade' => 'F', 'gp' => 0.00];
            }
            if ($key === 'agriculture') {
                return ($this->branchCheck($wri, 15))
                    ? $this->markToGrade($mark)
                    : ['grade' => 'F', 'gp' => 0.00];
            }

            // Other subjects
            return ($this->branchCheck($wri, 20))
                ? $this->markToGrade($mark)
                : ['grade' => 'F', 'gp' => 0.00];
        }

        // ---------------- CLASS 6–8 ----------------
        if (in_array($key, ['bangla', 'english'])) {
            return $this->branchCheck($wri + $mcq + $pra, 49)
                ? $this->markToGrade($mark)
                : ['grade' => 'F', 'gp' => 0.00];
        }

        if ($key === 'ict') {
            return $this->branchCheck($wri + $mcq + $pra, 17)
                ? $this->markToGrade($mark)
                : ['grade' => 'F', 'gp' => 0.00];
        }

        // ---------------- ALL OTHER SUBJECTS ----------------
        return $this->branchCheck($wri + $mcq + $pra, 33)
            ? $this->markToGrade($mark)
            : ['grade' => 'F', 'gp' => 0.00];
    }

    public function test_result()
    {
        $studentId = $this->request->getGet('student_id');
        $year      = $this->request->getGet('year');

        if (!$studentId || !$year) {
            return "Student ID and Year are required";
        }

        // ---------------- STUDENT ----------------
        $student = $this->studentModel->find($studentId);
        if (!$student) {
            return "Student not found";
        }

        // ---------------- ASSIGN SUBJECT ORDER ----------------
        $assignSubArr = explode(',', $student['assign_sub']);
        $normalSubs = [];
        $optionalSub = null;

        foreach ($assignSubArr as $sub) {
            if (str_contains($sub, '*')) {
                $optionalSub = (int) str_replace('*', '', $sub);
            } else {
                $normalSubs[] = (int) $sub;
            }
        }

        $orderedSubjects = $normalSubs;
        if ($optionalSub) {
            $orderedSubjects[] = $optionalSub;
        }

        // ---------------- FETCH RESULTS ----------------
        $half = $this->resultModel
            ->select('results.*, subjects.subject, subjects.full_mark')
            ->join('subjects', 'subjects.id = results.subject_id')
            ->where([
                'results.student_id' => $studentId,
                'results.year'       => $year,
                'results.exam'       => 'Half-Yearly'
            ])->findAll();

        $annual = $this->resultModel
            ->select('results.*, subjects.subject, subjects.full_mark')
            ->join('subjects', 'subjects.id = results.subject_id')
            ->where([
                'results.student_id' => $studentId,
                'results.year'       => $year,
                'results.exam'       => 'Annual Exam'
            ])->findAll();

        // ---------------- MERGE ----------------
        $marksheet = [];

        foreach ($half as $h) {
            $sid = $h['subject_id'];
            $marksheet[$sid] = [
                'subject'   => $h['subject'],
                'full_mark' => $h['full_mark'],
                'half'      => $h,
                'annual'    => null,
                'average'   => null,
                'final'     => null
            ];
        }

        foreach ($annual as $a) {
            $sid = $a['subject_id'];
            if (!isset($marksheet[$sid])) {
                $marksheet[$sid] = [
                    'subject'   => $a['subject'],
                    'full_mark' => $a['full_mark'],
                    'half'      => null,
                    'annual'    => null,
                    'average'   => null,
                    'final'     => null
                ];
            }
            $marksheet[$sid]['annual'] = $a;
        }

        // ---------------- SORT BY ASSIGNED ORDER ----------------
        $marksheetNumeric = [];
        foreach ($orderedSubjects as $sid) {
            if (isset($marksheet[$sid])) {
                $marksheetNumeric[] = $marksheet[$sid];
            }
        }

        // ---------------- COMBINE PAIRS (Bangla / English) ----------------
        $combinePairs = [
            [0, 1],
            [2, 3]
        ];

        foreach ($combinePairs as $pair) {
            $totalW = $totalM = $totalP = $totalSum = $fullMarkSum = 0;

            foreach ($pair as $i) {
                if (!isset($marksheetNumeric[$i])) continue;

                $row = $marksheetNumeric[$i];
                $h = $row['half'] ?? [];
                $a = $row['annual'] ?? [];

                $avgW = round((($h['written'] ?? 0) + ($a['written'] ?? 0)) / 2, 2);
                $avgM = round((($h['mcq'] ?? 0) + ($a['mcq'] ?? 0)) / 2, 2);
                $avgP = round((($h['practical'] ?? 0) + ($a['practical'] ?? 0)) / 2, 2);
                $avgTotal = round($avgW + $avgM + $avgP, 2);

                $marksheetNumeric[$i]['average'] = [
                    'written'   => $avgW,
                    'mcq'       => $avgM,
                    'practical' => $avgP,
                    'total'     => $avgTotal
                ];

                $totalW += $avgW;
                $totalM += $avgM;
                $totalP += $avgP;
                $totalSum += $avgTotal;
                $fullMarkSum += $row['full_mark'];
            }

            $percentage = $fullMarkSum > 0 ? round(($totalSum / $fullMarkSum) * 100, 2) : 0;
            $gradeInfo = $this->resultManipulation(
                (int)$student['class'],
                $student['section'],
                $marksheetNumeric[$pair[0]]['subject'], // Bangla / English
                $totalW,
                $totalM,
                $totalP,
                $percentage
            );

            foreach ($pair as $i) {
                if (!isset($marksheetNumeric[$i])) continue;

                $marksheetNumeric[$i]['final'] = [
                    'total_written'   => $totalW,
                    'total_mcq'       => $totalM,
                    'total_practical' => $totalP,
                    'total'           => $totalSum,
                    'full_mark'       => $fullMarkSum,
                    'percentage'      => $percentage,
                    'grade'           => $gradeInfo['grade'],
                    'grade_point'     => $gradeInfo['gp'],
                    'pass_status'     => ($percentage >= 33 ? 'Pass' : 'Fail')
                ];
            }
        }

        // ---------------- SINGLE SUBJECTS ----------------
        foreach ($marksheetNumeric as $i => &$row) {
            if (!isset($row['final'])) {
                $h = $row['half'] ?? [];
                $a = $row['annual'] ?? [];

                $avgW = round((($h['written'] ?? 0) + ($a['written'] ?? 0)) / 2, 2);
                $avgM = round((($h['mcq'] ?? 0) + ($a['mcq'] ?? 0)) / 2, 2);
                $avgP = round((($h['practical'] ?? 0) + ($a['practical'] ?? 0)) / 2, 2);
                $avgTotal = round($avgW + $avgM + $avgP, 2);

                $percentage = $row['full_mark'] > 0
                    ? round(($avgTotal / $row['full_mark']) * 100, 2)
                    : 0;

                $gradeInfo = $this->resultManipulation(
                    (int)$student['class'],
                    $student['section'],
                    $row['subject'],
                    $avgW,
                    $avgM,
                    $avgP,
                    $percentage
                );

                $row['average'] = [
                    'written'   => $avgW,
                    'mcq'       => $avgM,
                    'practical' => $avgP,
                    'total'     => $avgTotal
                ];

                $row['final'] = [
                    'total_written'   => $avgW,
                    'total_mcq'       => $avgM,
                    'total_practical' => $avgP,
                    'total'           => $avgTotal,
                    'full_mark'       => $row['full_mark'],
                    'percentage'      => $percentage,
                    'grade'           => $gradeInfo['grade'],
                    'grade_point'     => $gradeInfo['gp'],
                    'pass_status'     => ($percentage >= 33 ? 'Pass' : 'Fail')
                ];
            }
        }
        unset($row); // 🔒 VERY IMPORTANT
        // echo "<pre>";
        // print_r($marksheetNumeric);
        // echo "</pre>";

        return view('dashboard/test_result', [
            'marksheet' => $marksheetNumeric,
            'student'   => $student,
            'exam'      => 'Annual Exam',
            'year'      => $year
        ]);
    }

    // public function test_result()
    // {
    //     $request   = service('request');
    //     $studentId = $request->getGet('student_id');
    //     $year      = $request->getGet('year');

    //     if (!$studentId || !$year) {
    //         return redirect()->back()->with('error', 'Student ID and Year are required.');
    //     }

    //     /* ================= PAGE DATA (FROM showMarksheet) ================= */
    //     $this->data['title'] = 'Marksheet';
    //     $this->data['activeSection'] = 'result';
    //     $this->data['navbarItems'] = [
    //         ['label' => 'Tabulation Sheet', 'url' => base_url('admin/tabulation_form')],
    //         ['label' => 'Marksheet', 'url' => base_url('admin/select-marksheet')],
    //     ];

    //     /* ================= STUDENT ================= */
    //     $student = $this->studentModel->find($studentId);
    //     if (!$student) {
    //         return redirect()->back()->with('error', 'Student not found.');
    //     }

    //     $this->data['student'] = $student;
    //     $this->data['year']    = $year;

    //     /* ================= ASSIGNED SUBJECT ORDER ================= */
    //     $assignSubArr = explode(',', $student['assign_sub']);
    //     $normalSubs   = [];
    //     $optionalSub  = null;

    //     foreach ($assignSubArr as $sub) {
    //         if (str_contains($sub, '*')) {
    //             $optionalSub = (int) str_replace('*', '', $sub);
    //         } else {
    //             $normalSubs[] = (int) $sub;
    //         }
    //     }

    //     $orderedSubjects = $normalSubs;
    //     if ($optionalSub) {
    //         $orderedSubjects[] = $optionalSub;
    //     }

    //     /* ================= FETCH RESULTS ================= */
    //     $half = $this->resultModel
    //         ->select('results.*, subjects.subject, subjects.full_mark')
    //         ->join('subjects', 'subjects.id = results.subject_id')
    //         ->where([
    //             'results.student_id' => $studentId,
    //             'results.year'       => $year,
    //             'results.exam'       => 'Half-Yearly'
    //         ])->findAll();

    //     $annual = $this->resultModel
    //         ->select('results.*, subjects.subject, subjects.full_mark')
    //         ->join('subjects', 'subjects.id = results.subject_id')
    //         ->where([
    //             'results.student_id' => $studentId,
    //             'results.year'       => $year,
    //             'results.exam'       => 'Annual Exam'
    //         ])->findAll();

    //     /* ================= MERGE HALF + ANNUAL ================= */
    //     $marksheet = [];

    //     foreach ($half as $h) {
    //         $sid = $h['subject_id'];
    //         $marksheet[$sid] = [
    //             'subject'   => $h['subject'],
    //             'full_mark' => $h['full_mark'],
    //             'half'      => $h,
    //             'annual'    => null,
    //             'final'     => null,
    //         ];
    //     }

    //     foreach ($annual as $a) {
    //         $sid = $a['subject_id'];
    //         if (!isset($marksheet[$sid])) {
    //             $marksheet[$sid] = [
    //                 'subject'   => $a['subject'],
    //                 'full_mark' => $a['full_mark'],
    //                 'half'      => null,
    //                 'annual'    => null,
    //                 'final'     => null,
    //             ];
    //         }
    //         $marksheet[$sid]['annual'] = $a;
    //     }

    //     /* ================= SORT BY ASSIGNED SUBJECT ================= */
    //     $marksheetNumeric = [];
    //     foreach ($orderedSubjects as $sid) {
    //         if (isset($marksheet[$sid])) {
    //             $marksheetNumeric[] = $marksheet[$sid];
    //         }
    //     }

    //     /* ================= CALCULATE FINAL ================= */
    //     foreach ($marksheetNumeric as &$row) {

    //         $h = $row['half'] ?? [];
    //         $a = $row['annual'] ?? [];

    //         $avgTotal = (
    //             ($h['written'] ?? 0) + ($h['mcq'] ?? 0) + ($h['practical'] ?? 0) +
    //             ($a['written'] ?? 0) + ($a['mcq'] ?? 0) + ($a['practical'] ?? 0)
    //         ) / 2;

    //         $percentage = $row['full_mark'] > 0
    //             ? round(($avgTotal / $row['full_mark']) * 100, 2)
    //             : 0;

    //         $gradeInfo = $this->markToGrade($percentage);

    //         $row['final'] = [
    //             'total'       => round($avgTotal, 2),
    //             'full_mark'   => $row['full_mark'],
    //             'percentage'  => $percentage,
    //             'grade'       => $gradeInfo['grade'],
    //             'grade_point' => $gradeInfo['gp'],
    //             'pass_status' => ($percentage >= 33 ? 'Pass' : 'Fail'),
    //         ];
    //     }
    //     unset($row); // 🔒 IMPORTANT

    //     /* ================= SEND TO VIEW ================= */
    //     $this->data['marksheet'] = $marksheetNumeric;

    //     return view('dashboard/test_result', $this->data);
    // }

    public function showMarksheet()
    {
        $this->data['title'] = 'Marksheet';
        $this->data['activeSection'] = 'result';
        $this->data['navbarItems'] = [
            ['label' => 'Tabulation Sheet', 'url' => base_url('admin/tabulation_form')],
            ['label' => 'Marksheet', 'url' => base_url('admin/select-marksheet')],
        ];

        $request = service('request');
        $searchType = $request->getGet('search_type');

        if ($searchType === 'id') {
            $studentId = $request->getGet('student_id');
            $exam      = $request->getGet('exam');
            $year      = $request->getGet('year');

            if (!$studentId) {
                return redirect()->back()->with('error', 'Please enter a Student ID.');
            }

            $student = $this->studentModel->find($studentId);

            if (!$student) {
                return redirect()->back()->with('error', 'Student not found.');
            }

            // Fetch results with subject name
            $marksheet = $this->resultModel
                ->select('results.*, subjects.subject, subjects.full_mark')
                ->join('subjects', 'subjects.id = results.subject_id')
                ->where([
                    'results.student_id' => $studentId,
                    'results.exam'       => $exam,
                    'results.year'       => $year,
                ])
                ->findAll();

            // Sort based on assigned subjects
            $assigned = explode(',', $student['assign_sub'] ?? '');
            $orderMap = array_flip($assigned);

            usort($marksheet, function ($a, $b) use ($orderMap) {
                $posA = $orderMap[$a['subject_id']] ?? PHP_INT_MAX;
                $posB = $orderMap[$b['subject_id']] ?? PHP_INT_MAX;
                return $posA <=> $posB;
            });

            $this->data['examName'] = $exam;
            $this->data['examYear'] = $year;
            $this->data['student'] = $student;
            $this->data['marksheet'] = $marksheet;

            return view('dashboard/marksheet_view', $this->data);
        } elseif ($searchType === 'roll') {
            $class   = $request->getGet('class');
            $section = $request->getGet('section');
            $roll    = $request->getGet('roll');
            $exam    = $request->getGet('exam');
            $year    = $request->getGet('year');

            if (!$class || !$section || !$roll || !$exam || !$year) {
                return redirect()->back()->with('error', 'Please fill in all fields.');
            }

            $builder = $this->studentModel
                ->where('class', $class)
                ->where('roll', $roll);

            if ($section === 'vocational') {
                $builder->like('section', 'vocational');
            } else {
                $builder->groupStart()
                    ->like('section', 'n/a')
                    ->orLike('section', 'general')
                    ->groupEnd();
            }

            $student = $builder->first();

            if (!$student) {
                return redirect()->back()->with('error', 'Student not found for given Class/Roll.');
            }

            // Fetch marksheet with subject join
            $marksheet = $this->resultModel
                ->select('results.*, subjects.subject, subjects.full_mark')
                ->join('subjects', 'subjects.id = results.subject_id')
                ->where([
                    'results.student_id' => $student['id'],
                'results.exam'       => $exam,
                'results.year'       => $year,
                ])
                ->findAll();

            // Sort by assigned subjects
            $assignRaw = explode(',', $student['assign_sub']);
            $starredId = null;
            $ordered = [];

            // Separate normal and starred
            foreach ($assignRaw as $id) {
                if (str_ends_with($id, '*')) {
                    $starredId = rtrim($id, '*');
                } else {
                    $ordered[] = $id;
                }
            }

            usort($marksheet, function ($a, $b) use ($ordered, $starredId) {
                // If either subject is the starred one
                if ($a['subject_id'] == $starredId) {
                    return 1;
                }
                if ($b['subject_id'] == $starredId) {
                    return -1;
                }

                // Compare position in ordered list
                $posA = array_search($a['subject_id'], $ordered);
                $posB = array_search($b['subject_id'], $ordered);
                return $posA <=> $posB;
            });

            $this->data['examName'] = $exam;
            $this->data['examYear'] = $year;
            $this->data['student'] = $student;
            $this->data['marksheet'] = $marksheet;
            // echo '<pre>';
            // print_r($marksheet);
            // echo '</pre>';

            return view('dashboard/marksheet_view', $this->data);
        }

        return redirect()->back()->with('error', 'Invalid search method.');
    }

    public function viewStudent($id)
    {
        $this->studentModel = new StudentModel();
        $this->subjectModel = new SubjectModel();

        $student = $this->studentModel->find($id);

        if (!$student) {
            return redirect()->back()->with('error', 'No data found');
        }

        // ✅ Step 1: Parse subject IDs and extract 4th subject
        $subject_str_id = $student['assign_sub'];
        $rawIds = explode(',', $subject_str_id); // e.g. ['12', '13', '14*', '15']

        $subjectIds = [];
        $fourthSubjectId = null;

        foreach ($rawIds as $idEntry) {
            if (str_contains($idEntry, '*')) {
                $fourthSubjectId = str_replace('*', '', $idEntry);
                $subjectIds[] = $fourthSubjectId;
            } else {
                $subjectIds[] = $idEntry;
            }
        }

        $subjects = $this->subjectModel
            ->whereIn('id', $subjectIds)
            ->findAll();

        $fourthSubjectName = null;
        if ($fourthSubjectId) {
            $fourth = $this->subjectModel->find($fourthSubjectId);
            if ($fourth) {
                $fourthSubjectName = $fourth['subject'];
            }
        }

        // ✅ Step 4: Pass to view
        $this->data['title'] = 'Student Details';
        $this->data['activeSection'] = 'student';
        $this->data['navbarItems'] = [
            ['label' => 'Student List', 'url' => base_url('ad-student')],
            ['label' => 'Add Student', 'url' => base_url('student_create')],
            ['label' => 'View Student', 'url' => current_url()],
        ];
        $this->data['student'] = $student;
        $this->data['subjectsStr'] = $subject_str_id;
        $this->data['subjects'] = $subjects;
        $this->data['forthSubject'] = $fourthSubjectName;

        return view('dashboard/student_view', $this->data);
    }

    public function forthsub($id)
    {
        $subjectId = $this->request->getPost('subject_id');

        $subjectId = str_replace('*', '', $subjectId);

        $selectId  = $this->request->getPost('selectid');
        $className = $this->request->getPost('subject_class');



        if (in_array($className, [6, 7, 8])) {
            return redirect()->back()->with('error', 'Sorry Class 6, 7, 8 does not have 4th subject.');
        }
        if (!$selectId) {
            return redirect()->back()->with('error', 'Sir, No subject is selected.');
        } else {
            $subject = $this->subjectModel->find($selectId);
            $subjectNames = array_map('trim', explode(',', $subject['subject']));
            $subjectText = implode(', ', $subjectNames);

            $ids = $this->subjectModel
                ->select('id')
                ->whereIn('subject', [
                    'Higher Mathematics',
                    'Biology',
                    'Agriculture Studies',
                    'Agriculture Studies-1',
                    'Agriculture Studies-2'
                ])
                ->whereIn('class', [9, 10])
                ->findAll();

            $ids = array_column($ids, 'id');

            if (!in_array((int)$selectId, $ids)) {
                return redirect()->back()->with('error', 'Sorry sir, (' . $subjectText . ') is not a 4th subject.');
            } else {
                $replace = $selectId . "*";
                $updated = str_replace($selectId, $replace, $subjectId);

                $updatedResult = $this->studentModel->update($id, [
                    'assign_sub' => $updated,
                ]);

                if ($updatedResult) {
                    return redirect()->back()->with('success', $subjectText . ' is selected as 4th subject updated successfully to ID ' . $id);
                } else {
                    $dbError = $this->studentModel->db->error();
                    $errorMsg = $dbError['message'] ?? 'Unknown error occurred.';

                    return redirect()->back()->with('error', 'Update failed: ' . $errorMsg);
                }
            }
        }
    }

    public function editStudent($id)
    {

        $this->studentModel = new StudentModel();
        $student = $this->studentModel->find($id);

        if (!$student) {
            return redirect()->to('ad-student')->with('error', 'Student not found.');
        }

        $this->data['title'] = 'Edit Student';
        $this->data['activeSection'] = 'student';
        $this->data['navbarItems'] = [
            ['label' => 'Student List', 'url' => base_url('ad-student')],
            ['label' => 'Add Student', 'url' => base_url('student_create')],
            ['label' => 'Edit Student', 'url' => current_url()],
        ];
        $this->data['student'] = $student;

        return view('dashboard/student_edit', $this->data);
    }

    public function updateStudent($id)
    {
        $this->studentModel = new StudentModel();
        $student = $this->studentModel->find($id);

        if (!$student) {
            return redirect()->to('ad-student')->with('error', 'Student not found.');
        }

        $data = $this->request->getPost([
            'student_name',
            'roll',
            'class',
            'section',
            'esif',
            'father_name',
            'mother_name',
            'dob',
            'gender',
            'phone',
            'birth_registration_number',
            'father_nid_number',
            'mother_nid_number',
            'religion',
            'blood_group'
        ]);

        $this->studentModel->update($id, $data);

        return redirect()->to('admin/students/view/' . $id)->with('message', 'Student updated successfully.');
    }

    public function editStudentPhoto($id)
    {
        $this->studentModel = new StudentModel();
        $student = $this->studentModel->find($id);

        if (!$student) {
            return redirect()->to('admin/students')->with('error', 'Student not found.');
        }

        $this->data = [
            'title' => 'Edit Photo',
            'activeSection' => 'student',
            'navbarItems' => [
                ['label' => 'Student List', 'url' => base_url('ad-student')],
                ['label' => 'Edit Photo', 'url' => current_url()],
            ],
            'student' => $student
        ];

        return view('dashboard/edit_photo', $this->data);
    }

    public function updateStudentPhoto($id)
    {
        $this->studentModel = new StudentModel();
        $student = $this->studentModel->find($id);

        if (!$student) {
            return redirect()->to('admin/students')->with('error', 'Student not found.');
        }

        $file = $this->request->getFile('student_pic');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/students', $newName);

            // Delete old photo if it exists and is not default
            if (!empty($student['student_pic']) && file_exists(FCPATH . $student['student_pic'])) {
                unlink(FCPATH . $student['student_pic']);
            }

            // Update DB
            $this->studentModel->update($id, [
                'student_pic' => 'uploads/students/' . $newName,
            ]);

            return redirect()->to('admin/students/view/' . $id)->with('message', 'Photo updated successfully.');
        }

        return redirect()->back()->with('error', 'Photo upload failed.');
    }


    // Show all notices
    public function notices()
    {
        $this->data['title'] = 'Notice List';
        $this->data['activeSection'] = 'notice';
        $this->data['navbarItems'] = [
            ['label' => 'Notice List', 'url' => current_url()],
            ['label' => 'Add Notice', 'url' => base_url('admin/noticeForm')],
        ];
        $this->data['notices'] = $this->noticeModel->orderBy('id', 'DESC')->findAll();
        return view('dashboard/notice_list', $this->data);
    }

    // Show add form
    public function noticeForm()
    {
        $this->data['title'] = 'Notice Form';
        $this->data['activeSection'] = 'notice';
        $this->data['navbarItems'] = [
            ['label' => 'Notice List', 'url' => base_url('admin/notices')],
            ['label' => 'Add Notice', 'url' => current_url()],
        ];
        return view('dashboard/notice_form', $this->data);
    }

    // Save new notice
    public function saveNotice()
    {
        $data = [
            'title'       => $this->request->getPost('title'),
            'body'        => $this->request->getPost('body'),
            'notice_date' => $this->request->getPost('notice_date'),
            'status'      => $this->request->getPost('status'), // <--- Add this line
            'created_at'  => date('Y-m-d H:i:s'),
        ];

        // Handle file upload
        $file = $this->request->getFile('document_url');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/notices', $newName);
            $data['document_url'] = $newName;
        }

        $this->noticeModel->insert($data);
        return redirect()->to('admin/notices')->with('success', 'Notice added successfully!');
    }

    // Edit form
    public function editNotice($id)
    {
        $this->data['title'] = 'Notice Form';
        $this->data['activeSection'] = 'notice';
        $this->data['navbarItems'] = [
            ['label' => 'Notice List', 'url' => base_url('admin/notices')],
            ['label' => 'Add Notice', 'url' => current_url()],
        ];

        $this->data['notice'] = $this->noticeModel->find($id);

        if (!$this->data['notice']) {
            return redirect()->to('admin/notices')->with('error', 'Notice not found');
        }

        return view('dashboard/notice_form_edit', $this->data);
    }

    // Update existing notice
    public function updateNotice($id)
    {
        $noticeModel = new NoticeModel();
        $notice = $noticeModel->find($id);

        if (!$notice) {
            return redirect()->to('admin/notices')->with('error', 'Notice not found');
        }

        $data = [
            'title'       => $this->request->getPost('title'),
            'body'        => $this->request->getPost('body'),
            'notice_date' => $this->request->getPost('notice_date'),
            'status'      => $this->request->getPost('status'), // <--- Add this line
        ];

        // File update
        $file = $this->request->getFile('document_url');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            if (!empty($notice['document_url']) && file_exists('uploads/notices/' . $notice['document_url'])) {
                unlink('uploads/notices/' . $notice['document_url']);
            }
            $newName = $file->getRandomName();
            $file->move('uploads/notices', $newName);
            $data['document_url'] = $newName;
        }

        $noticeModel->update($id, $data);
        return redirect()->to('admin/notices')->with('success', 'Notice updated successfully!');
    }

    // Delete notice
    public function deleteNotice($id)
    {
        $noticeModel = new NoticeModel();
        $notice = $noticeModel->find($id);

        if ($notice) {
            if (!empty($notice['document_url']) && file_exists('uploads/notices/' . $notice['document_url'])) {
                unlink('uploads/notices/' . $notice['document_url']);
            }
            $noticeModel->delete($id);
        }

        return redirect()->to('admin/notices')->with('success', 'Notice deleted successfully!');
    }

    public function attendanceCalendar()
    {
        $this->data['title'] = 'Attendance';
        $this->data['activeSection'] = 'attendance';
        $this->data['navbarItems'] = [
            ['label' => 'Attendance', 'url' => base_url('attendance')],
        ];

        helper(['form', 'url']);

        // Get POST values
        $selectedClass   = $this->request->getPost('class') ?? '';
        $selectedSection = $this->request->getPost('section') ?? '';
        $selectedDate    = $this->request->getPost('date') ?? date('Y-m-d');

        // Base query
        $builder = $this->studentModel->where('permission', 0);

        // Filter by class
        if ($selectedClass) {
            $builder->where('class', $selectedClass);
        }

        // ✅ Section Filter
        if (strtolower($selectedSection) === 'general') {
            // Exclude any section containing "Vocational"
            $builder->notLike('section', 'Vocational');
        } elseif (strtolower($selectedSection) === 'vocational') {
            // Include only sections containing "Vocational"
            $builder->like('section', 'Vocational');
        }

        // Order and fetch
        $students = $builder->orderBy('CAST(roll AS UNSIGNED)', 'ASC')->findAll();

        // Get attendance for the selected date
        $attendances = $this->attendanceModel
            ->select('student_id, remark, DATE(created_at) as date')
            ->where('created_at >=', $selectedDate . ' 00:00:00')
            ->where('created_at <=', $selectedDate . ' 23:59:59')
            ->findAll();

        // Attendance mapping
        $attendanceMap = [];
        foreach ($attendances as $a) {
            if (!isset($attendanceMap[$a['student_id']])) {
                $attendanceMap[$a['student_id']] = [];
            }
            $attendanceMap[$a['student_id']][] = $a['remark'];
        }

        // Pass data to view
        $this->data['selectedClass']   = $selectedClass;
        $this->data['selectedSection'] = $selectedSection;
        $this->data['selectedDate']    = $selectedDate;
        $this->data['students']        = $students;
        $this->data['attendanceMap']   = $attendanceMap;

        return view('dashboard/attendance_calendar', $this->data);
    }

    public function saveAttendance()
    {
        $attendance = $this->request->getPost('attendance');

        $countUpdated = 0;
        $countDeleted = 0;
        $holidayError = false; // track if any date is a holiday

        foreach ($attendance as $studentId => $dates) {
            foreach ($dates as $date => $remark) {

                // 🔹 Check if date is Friday or Saturday
                $dayName = date('D', strtotime($date));
                if ($dayName === 'Fri' || $dayName === 'Sat') {
                    $holidayError = true;
                    continue; // skip saving attendance for this date
                }

                if ($remark === 'P') {
                    // --- Attend Record ---
                    $attendExists = $this->attendanceModel
                        ->where('student_id', $studentId)
                        ->where('remark', 'A')
                        ->where('DATE(created_at)', $date)
                        ->first();

                    if ($attendExists) {
                        $this->attendanceModel->update($attendExists['id'], [
                            'created_at' => $date . ' 10:00:00',
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                    } else {
                        $this->attendanceModel->insert([
                            'student_id' => $studentId,
                            'remark'     => 'A',
                            'created_at' => $date . ' 10:00:00',
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                    }

                    // --- Leave Record ---
                    $leaveExists = $this->attendanceModel
                        ->where('student_id', $studentId)
                        ->where('remark', 'L')
                        ->where('DATE(created_at)', $date)
                        ->first();

                    if ($leaveExists) {
                        $this->attendanceModel->update($leaveExists['id'], [
                            'created_at' => $date . ' 16:00:00',
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                    } else {
                        $this->attendanceModel->insert([
                            'student_id' => $studentId,
                            'remark'     => 'L',
                            'created_at' => $date . ' 16:00:00',
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                    }

                    $countUpdated++;
                } elseif ($remark === 'A') {
                    // Delete any existing Attend/Leave records
                    $existingRecords = $this->attendanceModel
                        ->where('student_id', $studentId)
                        ->whereIn('remark', ['A', 'L'])
                        ->where('DATE(created_at)', $date)
                        ->findAll();

                    foreach ($existingRecords as $record) {
                        $this->attendanceModel->delete($record['id']);
                    }

                    $countDeleted++;
                }
            }
        }

        // 🔹 Prepare message
        $messages = [];
        if ($holidayError) {
            $messages[] = "This day is a public holiday (Friday or Saturday). Attendance not saved.";
        }
        if ($countUpdated > 0) {
            $messages[] = "Attendance updated for {$countUpdated} students.";
        }
        if ($countDeleted > 0) {
            $messages[] = "Attendance deleted for {$countDeleted} students.";
        }

        $flashMessage = !empty($messages) ? implode(' | ', $messages) : "No changes made.";

        // 🔹 Choose message type
        $alertType = $holidayError ? 'error' : 'success';

        return redirect()->back()->with($alertType, $flashMessage);
    }

    public function transactionDashboard()
    {
        $this->data['title'] = 'Transaction Dashboard';
        $this->data['activeSection'] = 'accounts';
        $this->data['navbarItems'] = [
            ['label' => 'Accounts', 'url' => base_url('admin/transactions')],
            ['label' => 'Teacher', 'url' => base_url('admin/tec_pay')],
            ['label' => 'Students', 'url' => base_url('admin/std_pay')],
            ['label' => 'Statistics', 'url' => base_url('admin/pay_stat')],
            ['label' => 'Set Fees', 'url' => base_url('admin/set_fees')],
        ];

        // -----------------------------
        // Pagination settings
        // -----------------------------
        $perPage = 20; // number of records per page
        $page = (int) ($this->request->getGet('page') ?? 1);

        // Fetch paginated transactions (latest first)
        $transactions = $this->transactionModel
            ->orderBy('created_at', 'DESC') // newest first
            ->paginate($perPage, 'default', $page);

        $this->data['transactions'] = $transactions;
        $this->data['pager'] = $this->transactionModel->pager;

        // Totals (earn & cost)
        $totalEarnRow = $this->transactionModel->where('status', 0)->selectSum('amount')->get()->getRowArray();
        $totalCostRow = $this->transactionModel->where('status', 1)->selectSum('amount')->get()->getRowArray();

        $this->data['totalEarn'] = $totalEarnRow['amount'] ?? 0;
        $this->data['totalCost'] = $totalCostRow['amount'] ?? 0;

        $builder = db_connect()->table('transactions');

        /* -------------------------------------------------------
       ⭐ TODAY REPORT — HOURLY EARN VS COST
        ------------------------------------------------------- */
        $today = date('Y-m-d');

        $todayData = $builder
            ->select("
            HOUR(created_at) as hour,
            SUM(CASE WHEN status = 0 THEN amount ELSE 0 END) as earn,
            SUM(CASE WHEN status = 1 THEN amount ELSE 0 END) as cost
        ")
            ->where('DATE(created_at)', $today)
            ->groupBy('HOUR(created_at)')
            ->orderBy('HOUR(created_at)', 'ASC')
            ->get()
            ->getResultArray();

        $this->data['todayLabels'] = array_map(fn($d) => $d['hour'] . ":00", $todayData);
        $this->data['todayEarns'] = array_map('floatval', array_column($todayData, 'earn'));
        $this->data['todayCosts'] = array_map('floatval', array_column($todayData, 'cost'));

        /* -------------------------------------------------------
       ⭐ CURRENT MONTH DAILY REPORT
     ------------------------------------------------------- */
        $monthStart = date('Y-m-01');
        $monthEnd = date('Y-m-t');

        $currentMonthData = $builder
            ->select("
            DATE(created_at) as date,
            SUM(CASE WHEN status = 0 THEN amount ELSE 0 END) as earn,
            SUM(CASE WHEN status = 1 THEN amount ELSE 0 END) as cost
        ")
            ->where('created_at >=', $monthStart)
            ->where('created_at <=', $monthEnd)
            ->groupBy('DATE(created_at)')
            ->orderBy('DATE(created_at)', 'ASC')
            ->get()
            ->getResultArray();

        $this->data['dailyLabels'] = array_column($currentMonthData, 'date');
        $this->data['dailyEarns'] = array_map('floatval', array_column($currentMonthData, 'earn'));
        $this->data['dailyCosts'] = array_map('floatval', array_column($currentMonthData, 'cost'));

        /* -------------------------------------------------------
       ⭐ YEARLY MONTHLY SUMMARY
        ------------------------------------------------------- */
        $yearData = $builder
            ->select("
            MONTH(created_at) as month,
            SUM(CASE WHEN status = 0 THEN amount ELSE 0 END) as earn,
            SUM(CASE WHEN status = 1 THEN amount ELSE 0 END) as cost
        ")
            ->where('YEAR(created_at)', date('Y'))
            ->groupBy('MONTH(created_at)')
            ->orderBy('MONTH(created_at)', 'ASC')
            ->get()
            ->getResultArray();

        $this->data['monthLabels'] = array_map(
            fn($m) => date('M', mktime(0, 0, 0, $m['month'], 10)),
            $yearData
        );

        $this->data['monthEarns'] = array_map('floatval', array_column($yearData, 'earn'));
        $this->data['monthCosts'] = array_map('floatval', array_column($yearData, 'cost'));

        return view('dashboard/transaction_dashboard', $this->data);
    }

    public function tec_pay()
    {
        $this->data['title'] = 'Teacher Earnings';
        $this->data['activeSection'] = 'accounts';

        $this->data['navbarItems'] = [
            ['label' => 'Accounts', 'url' => base_url('admin/transactions')],
            ['label' => 'Teacher', 'url' => base_url('admin/tec_pay')],
            ['label' => 'Students', 'url' => base_url('admin/std_pay')],
            ['label' => 'Statistics', 'url' => base_url('admin/pay_stat')],
            ['label' => 'Set Fees', 'url' => base_url('admin/set_fees')],
        ];

        // Fetch teachers sorted by position
        $teachers = $this->userModel
            ->where('account_status !=', 0)
            ->orderBy('position', 'ASC') // sort by position ascending
            ->findAll();

        foreach ($teachers as &$t) {
            // Sum only "earn" transactions (status=0) for this teacher
            $t['total_earned'] = $this->transactionModel
                ->selectSum('amount')
                ->where('receiver_id', $t['id'])
                ->where('status', 0)      // only earn
                ->where('activity', 0)    // not paid
                ->first()['amount'] ?? 0;

            // Optional: sum only unpaid (same as total_earned if same filter)
            $t['unpaid'] = $this->transactionModel
                ->selectSum('amount')
                ->where('receiver_id', $t['id'])
                ->where('status', 0)
                ->where('activity', 0)   // not paid
                ->first()['amount'] ?? 0;
        }

        $this->data['teachers'] = $teachers;

        return view('dashboard/tec_pay', $this->data);
    }

    public function reset_amount($teacher_id)
    {
        // Update all unpaid earn transactions for this teacher to mark as paid
        $this->transactionModel
            ->where('receiver_id', $teacher_id)
            ->where('status', 0)      // only earn
            ->where('activity', 0)    // only not paid
            ->set(['activity' => 1])
            ->update();

        return redirect()->back()->with('success', 'Teacher earnings marked as paid.');
    }

    public function std_pay()
    {
        $this->data['title'] = 'Student Payment';
        $this->data['activeSection'] = 'payments';

        $this->data['navbarItems'] = [
            ['label' => 'Accounts', 'url' => base_url('admin/transactions')],
            ['label' => 'Teacher', 'url' => base_url('admin/tec_pay')],
            ['label' => 'Students', 'url' => base_url('admin/std_pay')],
            ['label' => 'Statistics', 'url' => base_url('admin/pay_stat')],
            ['label' => 'Set Fees', 'url' => base_url('admin/set_fees')],
        ];

        $builder = $this->studentModel->builder();

        // ✅ Get search/filter values
        $search = $this->request->getGet('search');
        $class = $this->request->getGet('class');
        $section = $this->request->getGet('section');

        // ✅ Apply search (roll, ID, or name)
        if ($search) {
            $builder->groupStart()
                ->like('roll', $search)
                ->orLike('id', $search)
                ->orLike('student_name', $search)
                ->groupEnd();
        }

        // ✅ Apply class & section filters
        if ($class) {
            $builder->where('class', $class);
        }
        if ($section) {
            $builder->where('section', $section);
        }

        // ✅ Get results
        $this->data['students'] = $builder
            ->orderBy('student_name', 'ASC')
            ->get()
            ->getResultArray();



        // Load total fees per class
        $this->data['fees_summary'] = $this->feesAmountModel
            ->select('class, SUM(fees) AS total_fees')
            ->groupBy('class')
            ->orderBy('class', 'ASC')
            ->get()
            ->getResultArray();

        // Convert fees_summary into an easy-to-lookup array: [class => total_fees]
        $classFees = [];
        foreach ($this->data['fees_summary'] as $row) {
            $classFees[$row['class']] = $row['total_fees'];
        }

        $this->data['classFees'] = $classFees; // ✅ pass to view

        // Load total deposit money per sender
        $this->data['fees_deposit'] = $this->transactionModel
            ->select('sender_id, sender_name, SUM(amount) AS total_deposit')
            ->groupBy('sender_id, sender_name')
            ->orderBy('sender_name', 'ASC')
            ->get()
            ->getResultArray();

        // Convert fees_deposit into an easy-to-lookup array: [sender_id => total_deposit]
        $senderDeposits = [];
        foreach ($this->data['fees_deposit'] as $row) {
            $senderDeposits[$row['sender_id']] = $row['total_deposit'];
        }

        $this->data['senderDeposits'] = $senderDeposits; // ✅ pass to view

        // ✅ Dropdown options
        $this->data['classes'] = $this->studentModel->select('class')->distinct()->orderBy('class', 'ASC')->get()->getResultArray();
        $this->data['sections'] = $this->studentModel->select('section')->distinct()->orderBy('section', 'ASC')->get()->getResultArray();

        // ✅ Pass search values to view
        $this->data['search'] = $search;
        $this->data['selectedClass'] = $class;
        $this->data['selectedSection'] = $section;

        return view('dashboard/std_pay', $this->data);
    }

    public function pay_stat()
    {
        $this->data['title'] = 'Transaction Dashboard';
        $this->data['activeSection'] = 'accounts';

        $this->data['navbarItems'] = [
            ['label' => 'Accounts', 'url' => base_url('admin/transactions')],
            ['label' => 'Teacher', 'url' => base_url('admin/tec_pay')],
            ['label' => 'Students', 'url' => base_url('admin/std_pay')],
            ['label' => 'Statistics', 'url' => base_url('admin/pay_stat')],
            ['label' => 'Set Fees', 'url' => base_url('admin/set_fees')],
        ];

        return view('dashboard/pay_stat', $this->data);
    }

    public function set_fees()
    {
        $this->data['title'] = 'Transaction Dashboard';
        $this->data['activeSection'] = 'accounts';

        $this->data['navbarItems'] = [
            ['label' => 'Accounts', 'url' => base_url('admin/transactions')],
            ['label' => 'Teacher', 'url' => base_url('admin/tec_pay')],
            ['label' => 'Students', 'url' => base_url('admin/std_pay')],
            ['label' => 'Statistics', 'url' => base_url('admin/pay_stat')],
            ['label' => 'Set Fees', 'url' => base_url('admin/set_fees')],
        ];


        $class = $this->request->getGet('class');

        // ✅ Fetch distinct classes dynamically from students
        $classes = $this->studentModel
            ->select('class')
            ->distinct()
            ->orderBy('CAST(class AS UNSIGNED)', 'ASC')
            ->findAll();
        $this->data['classes'] = array_column($classes, 'class');

        $this->data['selectedClass'] = $class;
        $this->data['titles'] = $this->feesModel->findAll();

        $existingAmounts = [];
        $existingUnits = [];
        $existingUpdates = [];

        $totalAmount = 0;

        if ($class) {
            $amounts = $this->feesAmountModel->where('class', $class)->findAll();
            foreach ($amounts as $a) {
                $existingAmounts[$a['title_id']] = $a['fees'];
                $existingUnits[$a['title_id']] = $a['unit'];
                $existingUpdates[$a['title_id']] = $a['updated_at'];

                // ✅ Calculate total = Σ (unit * fees)
                if (is_numeric($a['fees']) && is_numeric($a['unit'])) {
                    $totalAmount += $a['fees'] * $a['unit'];
                }
            }
        }

        $this->data['existingAmounts'] = $existingAmounts;
        $this->data['existingUnits'] = $existingUnits;
        $this->data['existingUpdates'] = $existingUpdates;
        $this->data['totalAmount'] = $totalAmount;

        return view('dashboard/set_fees', $this->data);
    }

    public function save_fees()
    {
        $class = $this->request->getPost('class');
        $feesData = $this->request->getPost('fees');
        $unitsData = $this->request->getPost('unit');

        if (!$class) {
            return redirect()->back()->with('error', 'Please select a class before saving.');
        }

        if (empty($feesData)) {
            return redirect()->back()->with('error', 'No fee amounts to save.');
        }

        $amountModel = new FeesAmountModel();

        foreach ($feesData as $title_id => $amount) {
            if ($amount === '' || $amount === null) {
                continue;
            }

            $unit = isset($unitsData[$title_id]) ? $unitsData[$title_id] : null;

            $existing = $this->feesAmountModel->where('class', $class)
                ->where('title_id', $title_id)
                ->first();

            if ($existing) {
                $amountModel->update($existing['id'], [
                    'fees' => $amount,
                    'unit' => $unit,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            } else {
                $amountModel->insert([
                    'class' => $class,
                    'title_id' => $title_id,
                    'fees' => $amount,
                    'unit' => $unit,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
        }

        return redirect()->back()->with('success', 'Fees updated successfully!');
    }

    public function payStudentRequest($id)
    {
        $this->data['title'] = 'Student Payment';
        $this->data['activeSection'] = 'accounts';

        $this->data['navbarItems'] = [
            ['label' => 'Accounts', 'url' => base_url('admin/transactions')],
            ['label' => 'Teacher', 'url' => base_url('admin/tec_pay')],
            ['label' => 'Students', 'url' => base_url('admin/std_pay')],
            ['label' => 'Statistics', 'url' => base_url('admin/pay_stat')],
            ['label' => 'Set Fees', 'url' => base_url('admin/set_fees')],
        ];


        // ✅ Load models
        // $studentModel = new \App\Models\StudentModel();
        // $feesModel = new \App\Models\FeesModel();
        // $feesAmountModel = new \App\Models\FeesAmountModel();
        // $userModel = new \App\Models\UserModel();

        // 🧍 Get student info
        $student = $this->studentModel->find($id);
        if (!$student) {
            return redirect()->back()->with('error', 'Student not found.');
        }

        // 🎓 Get all fees titles
        $fees = $this->feesModel->findAll();

        // 💰 Get class-wise fee amounts
        $classFees = $this->feesAmountModel->where('class', $student['class'])->findAll();

        // 🧾 Map fee amounts properly using title_id
        $feeAmounts = [];
        foreach ($classFees as $f) {
            $feeAmounts[$f['title_id']] = $f['fees'];
            $feeUnit[$f['title_id']] = $f['unit'];
        }

        // 👨‍🏫 Receiver (default admin)
        $userId = $this->session->get('user_id');
        $receiver = $this->userModel->find($userId);

        // 📦 Prepare data for view
        $this->data['student'] = $student;
        $this->data['fees'] = $fees;
        $this->data['feeAmounts'] = $feeAmounts;
        $this->data['feeUnit'] = $feeUnit;
        $this->data['receiver'] = $receiver;

        return view('dashboard/payStudentRequest', $this->data);
    }

    public function submitStudentPayment()
    {
        $studentId  = $this->request->getPost('student_id');
        $receiverId = $this->request->getPost('receiver_id');
        $amounts    = $this->request->getPost('amount');
        $feeIds     = $this->request->getPost('fee_id');

        $student  = $this->studentModel->find($studentId);
        $receiver = $this->userModel->find($receiverId);

        if (!$student || !$receiver) {
            return redirect()->back()->with('error', 'Invalid student or receiver.');
        }

        if (empty($amounts) || empty($feeIds)) {
            return redirect()->back()->with('error', 'No payment data provided.');
        }

        $successCount = 0;
        $errorMessages = [];

        foreach ($feeIds as $index => $feeId) {
            $amount = $amounts[$index] ?? 0;
            if ($amount <= 0) {
                continue;
            }

            // Get maximum allowed for this fee for the student's class
            $feeMax = $this->feesAmountModel
                ->where('class', $student['class'])
                ->where('title_id', $feeId)
                ->first();
            $maxAmount = $feeMax['unit'] * $feeMax['fees'] ?? 0;

            // Calculate total already paid by this student for this fee
            $feeTitle = $this->feesModel->find($feeId)['title'] ?? 'Unknown Fee';
            $totalPaid = $this->transactionModel
                ->where('sender_id', $student['id'])
                ->where('purpose', $feeTitle)
                ->select('SUM(amount) as paid')
                ->first();
            $paidAmount = $totalPaid['paid'] ?? 0;

            if ($paidAmount >= $maxAmount) {
                $errorMessages[] = "Sorry, maximum payment for '{$feeTitle}' already received.";
                continue;
            }

            // Prevent overpayment
            if ($paidAmount + $amount > $maxAmount) {
                $amount = $maxAmount - $paidAmount;
            }

            $this->transactionModel->insert([
                'transaction_id' => uniqid('TXN'),
                'sender_id'      => $student['id'],
                'sender_name'    => $student['student_name'],
                'receiver_id'    => $receiver['id'],
                'receiver_name'  => $receiver['name'],
                'amount'         => $amount,
                'purpose'        => $feeTitle,
                'description'    => 'Educational fees payment request',
                'status'         => 0,
            ]);

            $successCount++;
        }

        // Send messages separately
        if ($successCount > 0) {
            session()->setFlashdata('success', "$successCount payment request(s) submitted successfully.");
        }

        if (!empty($errorMessages)) {
            session()->setFlashdata('error', implode(' ', $errorMessages));
        }

        return redirect()->to(base_url('admin/std_pay'));
    }

    public function studentPaymentHistory($studentId)
    {

        // ✅ Page setup (for navbar & active section)
        $this->data['title'] = 'Student Payment';
        $this->data['activeSection'] = 'accounts';
        $this->data['navbarItems'] = [
            ['label' => 'Accounts', 'url' => base_url('admin/transactions')],
            ['label' => 'Teacher', 'url' => base_url('admin/tec_pay')],
            ['label' => 'Students', 'url' => base_url('admin/std_pay')],
            ['label' => 'Statistics', 'url' => base_url('admin/pay_stat')],
            ['label' => 'Set Fees', 'url' => base_url('admin/set_fees')],
        ];

        $student = $this->studentModel->find($studentId);
        if (!$student) {
            return redirect()->back()->with('error', 'Student not found.');
        }
        // ✅ Fetch all transactions for this student
        $payments = $this->transactionModel
            ->where('sender_id', $studentId)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        // ✅ Calculate total paid
        $totalPaid = array_sum(array_column($payments, 'amount'));

        // ✅ Pass data to view
        $this->data['student']   = $student;
        $this->data['payments']  = $payments;
        $this->data['totalPaid'] = $totalPaid;

        return view('dashboard/student_payment_history', $this->data);
    }

    public function teacherAttendance()
    {
        // Filters
        $selectedMonth = $this->request->getGet('month') ?? date('Y-m');
        $selectedTeacher = $this->request->getGet('teacher');

        // Page setup
        $this->data['title'] = 'Teacher Attendance';
        $this->data['activeSection'] = 'teacher_attendance';
        $this->data['navbarItems'] = [
            ['label' => 'Accounts', 'url' => base_url('admin/transactions')],
            ['label' => 'Teacher', 'url' => base_url('admin/tec_pay')],
            ['label' => 'Students', 'url' => base_url('admin/std_pay')],
            ['label' => 'Statistics', 'url' => base_url('admin/pay_stat')],
            ['label' => 'Set Fees', 'url' => base_url('admin/set_fees')],
        ];

        // Teacher list (all with account_status > 0)
        $allTeachers = $this->userModel->where('account_status >', 0)->orderBy('position', 'ASC')->findAll();

        // Filtered teacher list
        $builder = $this->userModel->where('account_status >', 0);
        if (!empty($selectedTeacher)) {
            $builder->where('id', $selectedTeacher);
        }
        $teacherList = $builder->orderBy('position', 'ASC')->findAll();

        // Build days of the month
        $daysInMonth = [];
        $numDays = date('t', strtotime($selectedMonth . '-01'));
        for ($d = 1; $d <= $numDays; $d++) {
            $date = $selectedMonth . '-' . sprintf("%02d", $d);
            $daysInMonth[] = [
                'date' => $date,
                'day'  => date('D', strtotime($date))
            ];
        }

        // Fetch teacher attendance for month
        $attendanceData = $this->teacherAttendanceModel
            ->where('created_at >=', $selectedMonth . '-01 00:00:00')
            ->where('created_at <=', $selectedMonth . '-' . $numDays . ' 23:59:59')
            ->findAll();

        // Map attendance by teacher + date
        $attendanceMap = [];
        foreach ($attendanceData as $record) {
            if (!isset($record['teacher_id'])) continue;

            $tid = $record['teacher_id'];
            $date = date('Y-m-d', strtotime($record['created_at']));
            $time = date('H:i:s', strtotime($record['created_at']));

            if (!isset($attendanceMap[$tid][$date])) {
                $attendanceMap[$tid][$date] = [
                    'arrival' => null,
                    'leave'   => null,
                    'remark'  => 'A', // default Absent
                ];
            }

            // Morning → arrival, Afternoon → leave
            if ($time <= '12:00:00') {
                $attendanceMap[$tid][$date]['arrival'] = $record['remark'];
            } else {
                $attendanceMap[$tid][$date]['leave'] = $record['remark'];
            }

            // Determine final remark
            $arrival = $attendanceMap[$tid][$date]['arrival'];
            $leave   = $attendanceMap[$tid][$date]['leave'];

            if ($arrival === 'Present' || $leave === 'Present') {
                $attendanceMap[$tid][$date]['remark'] = 'P';
            } elseif ($arrival === 'Late' || $leave === 'Late') {
                $attendanceMap[$tid][$date]['remark'] = 'L';
            } elseif ($arrival === 'Leave' || $leave === 'Leave') {
                $attendanceMap[$tid][$date]['remark'] = 'E';
            } else {
                $attendanceMap[$tid][$date]['remark'] = 'A';
            }
        }

        // Fill missing days with Absent or Holiday
        foreach ($allTeachers as $t) {
            foreach ($daysInMonth as $day) {
                $date = $day['date'];
                $dayName = $day['day'];

                if (!isset($attendanceMap[$t['id']][$date])) {
                    $attendanceMap[$t['id']][$date] = [
                        'remark' => in_array($dayName, ['Fri', 'Sat']) ? 'H' : 'A',
                        'arrival' => null,
                        'leave' => null
                    ];
                }
            }
        }

        // Pass data to view
        $this->data['teachers'] = $teacherList;
        $this->data['allTeachers'] = $allTeachers;
        $this->data['selectedTeacher'] = $selectedTeacher;
        $this->data['selectedMonth'] = $selectedMonth;
        $this->data['daysInMonth'] = $daysInMonth;
        $this->data['attendanceMap'] = $attendanceMap;

        return view('dashboard/teacher_attendance', $this->data);
    }
}