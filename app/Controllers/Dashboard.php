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
use App\Models\UserCollectionsPayModel;
use App\Models\CostTypeModel;
use App\Models\TeacherAttendanceModel;
use App\Models\RankingModel;
use App\Models\StudentBackupModel;
use App\Models\WelcomeMessageModel;
use App\Models\SliderModel;
use App\Models\RfidLogModel;
use App\Models\HolidayModel;
use App\Models\LeaveModel;

use CodeIgniter\Exceptions\PageNotFoundException;
use PhpParser\Node\Expr\Print_;
use Symfony\Component\Stopwatch\Section;

class Dashboard extends Controller
{
    protected $userModel;
    protected $subjectModel;
    protected $studentModel;
    protected $studentBackupModel;
    protected $resultModel;
    protected $calendarModel;
    protected $noticeModel;
    protected $markingModel;
    protected $attendanceModel;
    protected $feesModel;
    protected $feesAmountModel;
    protected $transactionModel;
    protected $userCollectionsPayModel;
    protected $costTypeModel;
    protected $welcomeMessageModel;
    protected $teacherAttendanceModel;
    protected $rankingModel;
    protected $sliderModel;
    protected $rfidLogModel;
    protected $holidayModel;
    protected $leaveModel;

    protected $session;
    protected $data;

    public function __construct()
    {
        $this->userModel        = new UserModel();
        $this->subjectModel     = new SubjectModel();
        $this->studentModel     = new StudentModel();
        $this->studentBackupModel     = new StudentBackupModel();
        $this->resultModel      = new ResultModel();
        $this->calendarModel    = new CalendarModel();
        $this->noticeModel      = new NoticeModel();
        $this->markingModel     = new MarkingOpenModel();
        $this->attendanceModel  = new AttendanceModel();
        $this->feesModel        = new FeesModel();
        $this->feesAmountModel  = new FeesAmountModel();
        $this->transactionModel = new TransactionModel();
        $this->userCollectionsPayModel = new UserCollectionsPayModel();
        $this->costTypeModel          = new CostTypeModel();
        $this->welcomeMessageModel    = new WelcomeMessageModel();
        $this->teacherAttendanceModel = new TeacherAttendanceModel();
        $this->rankingModel           = new RankingModel();
        $this->sliderModel            = new SliderModel();
        $this->rfidLogModel           = new RfidLogModel();
        $this->holidayModel           = new HolidayModel();
        $this->leaveModel             = new LeaveModel();


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
                'label' => 'Slider',
                'url' => base_url('admin/sliders'),
                'icon' => 'fas fa-image',
                'section' => 'slider'
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
            $year = date('Y');
            // Get unique subject IDs from results
            $given_subjects = $this->resultModel
                ->distinct()
                ->select('subject_id')
                ->whereIn('exam', $examNames)
                ->where('year', $year)
                ->findAll();

            // Get total subjects from calendar
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
            // $subjectModel = new \App\Models\SubjectModel();

            // Handle multiple subjects (comma-separated IDs)
            $subjectIds = explode(',', $teacher['assagin_sub']);

            foreach ($subjectIds as $subId) {
                $sub = $this->subjectModel->where('id', trim($subId))->first();
                if ($sub) {
                    $assignedSubjects[] = $sub['subject'];
                }
            }
        }

        $teacher['assagin_sub_list'] = $assignedSubjects; // store as array
        $this->data['user'] = $teacher;

        return view('dashboard/profile', $this->data);
    }

    public function updateCard($id)
    {
        $rfidRow = $this->rfidLogModel->find(1);

        if (!$rfidRow || empty($rfidRow['card_id'])) {
            return redirect()->back()->with('error', 'Card number not found');
        }

        $this->userModel->update($id, [
            'rfid' => $rfidRow['card_id']  // ✅ only single value
        ]);

        return redirect()->to(base_url('profile_id/' . $id))
            ->with('success', 'Card updated successfully');
    }

    public function studentUpdateCard($id)
    {
        $rfidRow = $this->rfidLogModel->find(1);

        if (!$rfidRow || empty($rfidRow['card_id'])) {
            return redirect()->back()->with('error', 'Card number not found');
        }

        $this->studentModel->update($id, [
            'rfid' => $rfidRow['card_id']  // ✅ only single valuesdf 
        ]);

        return redirect()->to(base_url('admin/students/view/' . $id))
            ->with('success', 'Card updated successfully');
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

    public function exam_routine()
    {
        $this->data['title'] = 'Exam Routine';
        $this->data['activeSection'] = 'calendar';

        // Navbar
        $this->data['navbarItems'] = [
            ['label' => 'Calendar', 'url' => base_url('calendar')],
            ['label' => 'Leave', 'url' => base_url('admin/leave')],
            ['label' => 'Holiday', 'url' => base_url('admin/holiday')],
            ['label' => 'Routine', 'url' => base_url('admin/exam-routine')],
            ['label' => 'Admit', 'url' => base_url('admin/print-admit-form')],
        ];

        // Subjects
        $this->data['subjects'] = $this->subjectModel->findAll();

        // Get search input
        $search = $this->request->getGet('search');

        $builder = $this->calendarModel;

        // Only Exam
        $builder->where('category', 'Exam');

        // ✅ Search ONLY by date
        if (!empty($search)) {
            $builder->like('start_date', $search);
        }

        // Final data
        $this->data['events'] = $builder
            ->orderBy('start_date', 'ASC')
            ->findAll();

        return view('dashboard/exam/exam_routine', $this->data);
    }

    public function create_exam_routine()
    {
        $this->data['title'] = 'Create Exam Routine';
        $this->data['activeSection'] = 'calendar';

        // Navbar
        $this->data['navbarItems'] = [
            ['label' => 'Calendar', 'url' => base_url('calendar')],
            ['label' => 'Leave', 'url' => base_url('admin/leave')],
            ['label' => 'Holiday', 'url' => base_url('admin/holiday')],
            ['label' => 'Routine', 'url' => base_url('admin/exam-routine')],
            ['label' => 'Admit', 'url' => base_url('admin/print-admit-form')],
        ];

        $this->data['subjects'] = $this->subjectModel->findAll();

        return view('dashboard/exam/create_exam_routine', $this->data);
    }

    public function admit_print_view()
    {

        $this->data['title'] = 'Create Exam Routine';
        $this->data['activeSection'] = 'calendar';
        // Navbar
        $this->data['navbarItems'] = [
            ['label' => 'Calendar', 'url' => base_url('calendar')],
            ['label' => 'Leave', 'url' => base_url('admin/leave')],
            ['label' => 'Holiday', 'url' => base_url('admin/holiday')],
            ['label' => 'Routine', 'url' => base_url('admin/exam-routine')],
            ['label' => 'Admit', 'url' => base_url('admin/print-admit-form')],
        ];



        return view('dashboard/exam/print_admit_card', $this->data);
    }

    public function getSubjectsByClass()
    {
        $class = $this->request->getGet('class');
        $data = $this->subjectModel->where('class', $class)->findAll();
        return $this->response->setJSON($data);
    }

    public function store_exam_routine()
    {
        $this->calendarModel->save([
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'start_date'  => $this->request->getPost('start_date'),
            'start_time'  => $this->request->getPost('start_time'),
            'end_date'    => $this->request->getPost('end_date'),
            'end_time'    => $this->request->getPost('end_time'),
            'color'       => $this->request->getPost('color'),
            'class'       => $this->request->getPost('class'),
            'category'    => 'Exam',
            'subcategory' => $this->request->getPost('subcategory'),
            'subject'     => $this->request->getPost('subject'),
        ]);

        return redirect()->to(base_url('admin/exam-routine'))
            ->with('success', 'Exam Routine Created Successfully');
    }

    public function edit_exam_routine($id)
    {
        $this->data['title'] = 'Edit Exam Routine';
        $this->data['activeSection'] = 'calendar';

        $this->data['subjects'] = $this->subjectModel->findAll();

        $event = $this->calendarModel->find($id);

        if (!$event) {
            return redirect()->back()->with('error', 'Routine not found');
        }

        $this->data['event'] = $event;

        return view('dashboard/exam/edit_exam_routine', $this->data);
    }

    public function update_exam_routine($id)
    {
        $this->calendarModel->update($id, [
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'start_date'  => $this->request->getPost('start_date'),
            'start_time'  => $this->request->getPost('start_time'),
            'end_date'    => $this->request->getPost('end_date'),
            'end_time'    => $this->request->getPost('end_time'),
            'color'       => $this->request->getPost('color'),
            'class'       => $this->request->getPost('class'),
            'category'    => $this->request->getPost('category'),
            'subcategory' => $this->request->getPost('subcategory'),
            'subject'     => $this->request->getPost('subject'),
        ]);

        return redirect()->to(base_url('admin/exam-routine'))
            ->with('success', 'Routine Updated Successfully');
    }

    public function delete_exam_routine($id)
    {
        $event = $this->calendarModel->find($id);

        if (!$event) {
            return redirect()->to(base_url('admin/exam-routine'))
                ->with('error', 'Routine not found.');
        }

        $this->calendarModel->delete($id);

        return redirect()->to(base_url('admin/exam-routine'))
            ->with('success', 'Routine deleted successfully.');
    }

    public function holiday()
    {
        $this->data['title'] = 'Calendar';
        $this->data['activeSection'] = 'calendar';

        // Common navbar and sidebar for all views
        // Navbar
        $this->data['navbarItems'] = [
            ['label' => 'Calendar', 'url' => base_url('calendar')],
            ['label' => 'Leave', 'url' => base_url('admin/leave')],
            ['label' => 'Holiday', 'url' => base_url('admin/holiday')],
            ['label' => 'Routine', 'url' => base_url('admin/exam-routine')],
            ['label' => 'Admit', 'url' => base_url('admin/print-admit-form')],
        ];

        $this->data['holidays'] = $this->holidayModel->orderBy('start_date', 'ASC')->findAll();

        return view('dashboard/holiday/holiday_list', $this->data);
    }

    public function addHolidayForm()
    {
        $this->data['title'] = 'Calendar';
        $this->data['activeSection'] = 'calendar';

        // Common navbar and sidebar for all views
        $this->data['navbarItems'] = [
            ['label' => 'Calendar', 'url' => base_url('calendar')],
            ['label' => 'Holiday List', 'url' => base_url('admin/holiday')],
        ];

        return view('dashboard/holiday/add_holiday', $this->data);
    }

    public function saveHoliday()
    {

        // ✅ Validation rules
        $rules = [
            'name' => 'required|min_length[3]',
            'start_date' => 'required|valid_date',
            'end_date' => 'required|valid_date',
        ];

        // Custom error messages (optional)
        $messages = [
            'name' => [
                'required' => 'Holiday name is required'
            ],
            'start_date' => [
                'required' => 'Start date is required'
            ],
            'end_date' => [
                'required' => 'End date is required'
            ]
        ];

        // ✅ Validate
        if (!$this->validate($rules, $messages)) {
            return redirect()->back()
                ->withInput()
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $start = $this->request->getPost('start_date');
        $end   = $this->request->getPost('end_date');

        // ✅ Date logic check
        if ($end < $start) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'End date must be greater than or equal to Start date');
        }

        // ✅ Insert Data
        try {
            $this->holidayModel->insert([
                'name'       => $this->request->getPost('name'),
                'start_date' => $start,
                'end_date'   => $end,
                'desc'       => $this->request->getPost('desc'),
            ]);

            return redirect()->to(base_url('admin/holiday'))
                ->with('success', 'Holiday Added Successfully');
        } catch (\Exception $e) {

            return redirect()->back()
                ->withInput()
                ->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function editHoliday($id)
    {

        $this->data['title'] = 'Calendar';
        $this->data['activeSection'] = 'calendar';

        // Common navbar and sidebar for all views
        $this->data['navbarItems'] = [
            ['label' => 'Calendar', 'url' => base_url('calendar')],
            ['label' => 'Holiday List', 'url' => base_url('admin/holiday')],
        ];

        $this->data['holiday'] = $this->holidayModel->find($id);

        if (!$this->data['holiday']) {
            return redirect()->to(base_url('admin/holiday'))
                ->with('error', 'Holiday not found');
        }

        $this->data['holiday'] = $this->holidayModel->find($id);
        return view('dashboard/holiday/add_holiday', $this->data);
    }

    public function updateHoliday($id)
    {
        $data = [
            'name'       => $this->request->getPost('name'),
            'start_date' => $this->request->getPost('start_date'),
            'end_date'   => $this->request->getPost('end_date'),
            'desc'       => $this->request->getPost('desc'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->holidayModel->update($id, $data);

        return redirect()->to(base_url('admin/holiday'))
            ->with('success', 'Holiday Updated Successfully');
    }

    public function deleteHoliday($id)
    {

        // Check if holiday exists
        $holiday = $this->holidayModel->find($id);

        if (!$holiday) {
            return redirect()->to(base_url('admin/holiday'))
                ->with('error', 'Holiday not found!');
        }

        // Delete the record
        $this->holidayModel->delete($id);

        return redirect()->to(base_url('admin/holiday'))
            ->with('success', 'Holiday deleted successfully!');
    }

    // leave form

    public function leaveList()
    {
        $this->data['title'] = 'Calendar';
        $this->data['activeSection'] = 'calendar';

        // Navbar
        $this->data['navbarItems'] = [
            ['label' => 'Calendar', 'url' => base_url('calendar')],
            ['label' => 'Leave', 'url' => base_url('admin/leave')],
            ['label' => 'Holiday', 'url' => base_url('admin/holiday')],
            ['label' => 'Routine', 'url' => base_url('admin/exam-routine')],
            ['label' => 'Admit', 'url' => base_url('admin/print-admit-form')],
        ];

        // 🔥 Logged-in user
        $userId = session()->get('user_id');
        $this->data['loginUser'] = $this->userModel->find($userId);

        // 🔍 Filters
        $search = $this->request->getGet('search');
        $status = $this->request->getGet('status');

        // 🔥 Fresh Builder
        $builder = $this->leaveModel
            ->select('leaves.*, users.name as user_name')
            ->join('users', 'users.id = leaves.user_id', 'left');

        // 🔍 Search
        if (!empty($search)) {
            $builder->groupStart()
                ->like('leaves.reason', $search)
                ->orLike('leaves.leave_type', $search)
                ->orLike('users.name', $search)
                ->groupEnd();
        }

        // 🔽 Status filter
        if (!empty($status)) {
            $builder->where('leaves.status', $status);
        }

        // 🔥 Get data
        $this->data['leaves'] = $builder
            // ->where('leaves.status', 'Pending') // 👈 only pending
            ->orderBy('leaves.id', 'DESC')
            ->findAll();

        return view('dashboard/leave/leave_list', $this->data);
    }

    public function leave_form($id = null)
    {
        $this->data['title'] = 'Leave Form';
        $this->data['activeSection'] = 'calendar';

        // Navbar
        $this->data['navbarItems'] = [
            ['label' => 'Calendar', 'url' => base_url('calendar')],
            ['label' => 'Leave', 'url' => base_url('admin/leave')],
            ['label' => 'Holiday', 'url' => base_url('admin/holiday')],
            ['label' => 'Routine', 'url' => base_url('admin/exam-routine')],
            ['label' => 'Admit', 'url' => base_url('admin/print-admit-form')],
        ];

        $userId = session()->get('user_id');

        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to('admin/leave')
                ->with('error', 'User not found or not logged in');
        }

        // 🔥 DEFAULT
        $leave = null;

        // 🔥 IF EDIT MODE
        if ($id) {
            $leave = $this->leaveModel->find($id);

            if (!$leave) {
                return redirect()->to('admin/leave')
                    ->with('error', 'Leave not found');
            }

            // 🚫 BLOCK EDIT IF APPROVED
            if ($leave['status'] == 'Approved') {
                return redirect()->to('admin/leave')
                    ->with('error', 'Approved leave cannot be edited');
            }
        }

        // 🔥 Count leaves
        $usedLeaves = $this->leaveModel
            ->where('user_id', $userId)
            ->where('status', 'Approved')
            ->countAllResults();

        $totalAllowedLeaves = 20;
        $remainingLeaves = $totalAllowedLeaves - $usedLeaves;

        // Pass data
        $this->data['user'] = $user;
        $this->data['leave'] = $leave; // 👈 important
        $this->data['usedLeaves'] = $usedLeaves;
        $this->data['remainingLeaves'] = $remainingLeaves;
        $this->data['totalAllowedLeaves'] = $totalAllowedLeaves;




        if (!empty($id)) {

            $userId = session()->get('user_id');
            $leave = $this->leaveModel->find($id);

            if ($userId != $leave['user_id']) {
                return redirect()->back()->with('error', 'You are not allowed to edit this leave');
            }
        }

        return view('dashboard/leave/leave_form', $this->data);
    }

    public function saveLeave()
    {
        $id = $this->request->getPost('id');

        $data = [
            'user_id'       => $this->request->getPost('user_id'),
            'leave_type'    => $this->request->getPost('leave_type'),
            'from_datetime' => $this->request->getPost('from_datetime'),
            'to_datetime'   => $this->request->getPost('to_datetime'),
            'reason'        => $this->request->getPost('reason'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ];

        // 🔥 If ID exists → UPDATE
        if ($id) {
            $leave = $this->leaveModel->find($id);

            // 🚫 Block if approved
            if ($leave['status'] == 'Approved') {
                return redirect()->back()->with('error', 'Approved leave cannot be updated');
            }

            $this->leaveModel->update($id, $data);

            return redirect()->to('admin/leave')
                ->with('success', 'Leave updated successfully');
        }

        // 🔥 Else → INSERT
        $data['status'] = 'Pending';

        $this->leaveModel->insert($data);

        return redirect()->to('admin/leave')
            ->with('success', 'Leave submitted successfully');
    }

    public function approve_leave($id)
    {
        $userId = session()->get('user_id');

        $loginUser = $this->userModel->find($userId);

        // 🚫 Check permission
        if (($loginUser['account_status'] ?? 0) <= 1) {
            return redirect()->back()->with('error', 'You are not allowed to approve leave');
        }

        // 🔍 Get leave
        $leave = $this->leaveModel->find($id);

        // 🚫 Check if already approved
        if (!$leave) {
            return redirect()->back()->with('error', 'Leave not found');
        }

        if ($leave['status'] == 'Approved') {
            return redirect()->back()->with('error', 'Already approved');
        }

        // ✅ Update status
        $this->leaveModel->update($id, [
            'status'     => 'Approved',
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to(base_url('admin/leave'))
            ->with('success', 'Leave approved successfully');
    }

    public function deleteLeave($id)
    {
        if (!$id) {
            return redirect()->back()->with('error', 'Invalid ID');
        }

        // Get leave
        $leave = $this->leaveModel->find($id);

        if (!$leave) {
            return redirect()->back()->with('error', 'Leave not found');
        }

        // Get logged in user
        $userId = session()->get('user_id');
        $loginUser = $this->userModel->find($userId);

        if (!$loginUser) {
            return redirect()->back()->with('error', 'User not found');
        }

        // 🔐 ADMIN CHECK
        if (($loginUser['account_status'] ?? 0) <= 1) {

            // ❌ Not admin → only own leave allowed
            if ($loginUser['id'] != $leave['user_id']) {
                return redirect()->back()->with('error', 'You are not allowed to delete this leave');
            }
        }

        // ✅ Delete
        $this->leaveModel->delete($id);

        return redirect()->back()->with('success', 'Leave deleted successfully');
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




        // Get latest year
        $latestYear = $this->resultModel
            ->selectMax('year', 'latest_year')
            ->first()['latest_year'];

        $this->data['latestYear'] = $latestYear;

        // Get all exams for latest year
        $examRows = $this->resultModel
            ->select('exam')
            ->where('year', $latestYear)
            ->groupBy('exam')
            ->orderBy('exam', 'ASC')
            ->findAll();

        $examsClass69 = [];
        $examsClass10 = [];

        foreach ($examRows as $row) {
            $exam = $row['exam'];

            if (stripos($exam, 'Test') !== false) {
                // Contains "Test" -> Class 10 only
                $examsClass10[] = $exam;
            } else {
                // Does not contain "Test" -> Classes 6-9
                $examsClass69[] = $exam;
            }
        }

        $this->data['examsClass69'] = $examsClass69;
        $this->data['examsClass10'] = $examsClass10;

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
            ->groupStart()
            ->where("FIND_IN_SET('81', assign_sub) >", 0, false)
            ->orWhere("FIND_IN_SET('81*', assign_sub) >", 0, false)
            ->groupEnd()
            ->where('permission', 0)
            ->where('CAST(class AS UNSIGNED) <=', 10, false)
            ->orderBy('CAST(roll AS UNSIGNED)', 'ASC', false)
            ->findAll();

            // echo "<pre>";
            // print_r($students);
            // echo "</pre>";
        

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
            ->where('results.year', date('Y'))
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

    public function delete_result_permission()
    {
        $resultId = $this->request->getPost('result_id');

        if (empty($resultId)) {
            return redirect()->back()->with('error', 'Invalid result ID.');
        }

        $result = $this->resultModel->find($resultId);

        if (!$result) {
            return redirect()->back()->with('error', 'Result not found.');
        }

        $success = $this->resultModel->delete($resultId);

        session()->setFlashdata(
            $success ? 'success' : 'error',
            $success ? 'Result deleted successfully.' : 'Failed to delete the result.'
        );

        // Re-populate the current request so ResultCheck() can read the same POST values.
        $_POST['user_id'] = $result['teacher_id'];
        $_POST['subject_id'] = $result['subject_id'];
        $_POST['exam_name'] = $result['exam'];

        return $this->ResultCheck();
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
            ['section' => 'Humanities'],
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
            ['label' => 'Make Top Sheet', 'url' => base_url('admin/topsheet_form')],
            ['label' => 'Print Top Sheet', 'url' => base_url('admin/print_topsheet_form')],
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
            ['label' => 'Make Top Sheet', 'url' => base_url('admin/topsheet_form')],
            ['label' => 'Print Top Sheet', 'url' => base_url('admin/print_topsheet_form')],
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
            ['label' => 'Make Top Sheet', 'url' => base_url('admin/topsheet_form')],
            ['label' => 'Print Top Sheet', 'url' => base_url('admin/print_topsheet_form')],
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
        if (str_contains($subject, 'bangla ')) return 'bangla';
        if (str_contains($subject, 'english ')) return 'english';
        if (str_contains($subject, 'bangla-')) return 'bangla';
        if (str_contains($subject, 'english-')) return 'english';
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

        if (
            str_contains($subject, 'self employment and entrepreneur')
        ) {
            return 'self_employment_entrepreneur';
        }

        // ---- Fallback ----
        return 'general';
    }

    public function resultManipulation($class, $section, $subject, $wri, $mcq, $pra, $mark)
    {
        // echo "<pre>";
        // print_r([
        //     'class'   => $class,
        //     'section' => $section,
        //     'subject' => $subject,
        //     'written' => $wri,
        //     'mcq'     => $mcq,
        //     'practical' => $pra,
        //     'mark'    => $mark,
        // ]);
        // echo "</pre>";

        // echo $class . "==";
        // echo $subject . "==";
        $section = strtolower($section);
        // echo "==" . $section . "==";
        $key     = $this->normalizeSubject($subject);
        // echo $key . "<br>";

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
            if (in_array($key, ['physics', 'chemistry', 'biology', 'higher_math', 'agriculture'])) {

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
        }

        // ---------------- CLASS 9–10 (VOCATIONAL) ----------------
        if (in_array($class, [9, 10]) && stripos($section, 'vocational') !== false) {



            // Agriculture
            if ($key === 'agriculture') {
                return ($this->branchCheck($wri, 15))
                    ? $this->markToGrade($mark)
                    : ['grade' => 'F', 'gp' => 0.00];
            }

            // ICT
            if ($key === 'computer') {
                return ($this->branchCheck($pra, 17))
                    ? $this->markToGrade($mark)
                    : ['grade' => 'F', 'gp' => 0.00];
            }

            // Science subjects
            if (in_array($key, ['physics', 'chemistry', 'biology', 'bgs', 'self_employment_entrepreneur'])) {

                return ($this->branchCheck($wri, 10))
                    ? $this->markToGrade($mark)
                    : ['grade' => 'F', 'gp' => 0.00];
            }

            // Other subjects
            return ($this->branchCheck($wri, 20))
                ? $this->markToGrade($mark)
                : ['grade' => 'F', 'gp' => 0.00];
        }

        if (in_array($class, [6, 7, 8]) && strpos($section, 'vocational') === false) {

            // ---------------- CLASS 6–8 ----------------
            if (in_array($key, ['bangla', 'english'])) {
                return $this->branchCheck($wri + $mcq + $pra, 49)
                    ? $this->markToGrade($mark)
                    : ['grade' => 'F', 'gp' => 0.00];
            }

            if (in_array($key, ['ict', 'agriculture'])) {
                return $this->branchCheck($wri + $mcq + $pra, 17)
                    ? $this->markToGrade($mark)
                    : ['grade' => 'F', 'gp' => 0.00];
            }

            // ---------------- ALL OTHER SUBJECTS ----------------
            return $this->branchCheck($wri + $mcq + $pra, 33)
                ? $this->markToGrade($mark)
                : ['grade' => 'F', 'gp' => 0.00];
        }
    }

    private function gpToGrade(float $gp): string
    {
        if ($gp >= 5.00) return 'A+';
        if ($gp >= 4.00) return 'A';
        if ($gp >= 3.50) return 'A-';
        if ($gp >= 3.00) return 'B';
        if ($gp >= 2.00) return 'C';
        if ($gp >= 1.00) return 'D';
        return 'F';
    }

    public function test_result($studentId = null, $year = null, $exam = null, $view = null)
    {
        if (!$studentId || !$year) {
            return "Student ID and Year are required";
        }

        // ---------------- STUDENT ----------------
        $student = $this->studentModel->find($studentId);
        if (!$student) {
            return "Student not found";
        }

        // ---------------- STUDENT BACKUP ----------------
        $studentBackup = $this->studentBackupModel
            ->where('student_id', $studentId)
            ->where('year', $year)
            ->first();

        if (!$studentBackup) {
            return "Student backup not found";
        }

        // ---------------- ASSIGN SUBJECT ORDER ----------------
        $assignSubArr = explode(',', $studentBackup['assign_sub']);
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
                'results.exam'       => $exam
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

            if (!count($marksheetNumeric)) {
                return "Sorry no Data found";
            }

            $gradeInfo = $this->resultManipulation(
                (int)$studentBackup['class'],
                $studentBackup['section'],
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
                    (int)$studentBackup['class'],
                    $studentBackup['section'],
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

        // return view('dashboard/test_result', [
        //     'marksheet' => $marksheetNumeric,
        //     'student'   => $student,
        //     'exam'      => 'Annual Exam',
        //     'year'      => $year
        // ]);

        $data = [
            'marksheet'     => $marksheetNumeric,
            'student'       => $student,
            'studentBackup' => $studentBackup,
            'exam'          => $exam,
            'year'          => $year
        ];

        if ($view)
            $this->saveRankingFromResult($data);
        else
            return view('dashboard/test_result', $data);
    }

    public function test_result_single_exam($studentId = null, $year = null, $exam = null, $view = null)
    {

        if (!$studentId || !$year || !$exam) {
            return "Student ID, Year and Exam are required";
        }
        
        // ---------------- STUDENT ----------------
        $student = $this->studentModel->find($studentId);
        if (!$student) {
            return "Student not found";
        }

        // ---------------- STUDENT BACKUP ----------------
        // $studentBackup = $this->studentBackupModel
        //     ->where('student_id', $studentId)
        //     ->where('year', $year)
        //     ->first();

        // if (!$studentBackup) {
        //     return "Student backup not found";
        // }


        echo "test -";

        // ---------------- ASSIGNED SUBJECT ORDER ----------------
        $assignSubArr = explode(',', $studentBackup['assign_sub']);
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

        // ---------------- FETCH SINGLE EXAM RESULT ----------------
        $results = $this->resultModel
            ->select('results.*, subjects.subject, subjects.full_mark')
            ->join('subjects', 'subjects.id = results.subject_id')
            ->where([
                'results.student_id' => $studentId,
                'results.year'       => $year,
                'results.exam'       => $exam
            ])
            ->findAll();

        // ---------------- PREPARE MARKSHEET ----------------
        $marksheet = [];
        foreach ($results as $r) {
            $marksheet[$r['subject_id']] = $r;
        }

        // ---------------- ORDER SUBJECTS ----------------
        $marksheetNumeric = [];
        foreach ($orderedSubjects as $sid) {
            if (!isset($marksheet[$sid])) continue;

            $row = $marksheet[$sid];

            $written   = $row['written'] ?? 0;
            $mcq       = $row['mcq'] ?? 0;
            $practical = $row['practical'] ?? 0;

            $total = $written + $mcq + $practical;

            $percentage = $row['full_mark'] > 0
                ? round(($total / $row['full_mark']) * 100, 2)
                : 0;

            $gradeInfo = $this->resultManipulation(
                (int)$studentBackup['class'],
                $studentBackup['section'],
                $row['subject'],
                $written,
                $mcq,
                $practical,
                $percentage
            );
            // echo "<pre>";
            // print_r($gradeInfo);
            // echo "</pre>";

            $marksheetNumeric[] = [
                'subject'   => $row['subject'],
                'full_mark' => $row['full_mark'],
                'exam'      => [
                    'written'   => $written,
                    'mcq'       => $mcq,
                    'practical' => $practical,
                    'total'     => $total
                ],
                'final' => [
                    'total_written'   => $written,
                    'total_mcq'       => $mcq,
                    'total_practical' => $practical,
                    'total'           => $total,
                    'percentage'      => $percentage,
                    'grade'           => $gradeInfo['grade'],
                    'grade_point'     => $gradeInfo['gp'],
                    'pass_status'     => ($percentage >= 33 ? 'Pass' : 'Fail')
                ]
            ];
        }

        // ---------------- COMBINE PAIRS (Bangla / English) ----------------
        $combinePairs = [
            [0, 1], // Example: Bangla 1 + Bangla 2
            [2, 3]  // Example: English 1 + English 2
        ];

        foreach ($combinePairs as $pair) {

            // Skip the pair if none of the indexes exist
            if (!isset($marksheetNumeric[$pair[0]]) && !isset($marksheetNumeric[$pair[1]])) {
                continue;
            }

            $totalW = $totalM = $totalP = $totalSum = $fullMarkSum = 0;

            foreach ($pair as $i) {
                if (!isset($marksheetNumeric[$i])) continue;

                $row = $marksheetNumeric[$i];
                $w = $row['exam']['written'] ?? 0;
                $m = $row['exam']['mcq'] ?? 0;
                $p = $row['exam']['practical'] ?? 0;
                $total = $w + $m + $p;

                $marksheetNumeric[$i]['average'] = [
                    'written'   => $w,
                    'mcq'       => $m,
                    'practical' => $p,
                    'total'     => $total
                ];

                $totalW += $w;
                $totalM += $m;
                $totalP += $p;
                $totalSum += $total;
                $fullMarkSum += $row['full_mark'] ?? 0;
            }

            // Only calculate grade if at least one subject exists
            if ($fullMarkSum > 0) {
                $percentage = round(($totalSum / $fullMarkSum) * 100, 2);
                $firstIndex = null;
                foreach ($pair as $i) {
                    if (isset($marksheetNumeric[$i])) {
                        $firstIndex = $i;
                        break;
                    }
                }

                $gradeInfo = $this->resultManipulation(
                    (int)$studentBackup['class'],
                    $studentBackup['section'],
                    $marksheetNumeric[$firstIndex]['subject'],
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
        }

        // ---------------- VIEW / SAVE ----------------
        $data = [
            'marksheet'     => $marksheetNumeric,
            'student'       => $student,
            'studentBackup' => $studentBackup,
            'exam'          => $exam,
            'year'          => $year
        ];
        echo "<pre>";
        print_r($marksheetNumeric);
        echo "<pre>";
        if ($view) {
            $this->saveRankingFromResult($data);
        } else {
            return view('dashboard/test_result_single_exam', $data);
        }
    }

    private function saveRankingFromResult(array $data)
    {
        $marksheet      = $data['marksheet'];
        $student        = $data['student'];
        $studentBackup  = $data['studentBackup'];
        $exam           = $data['exam'];
        $year           = $data['year'];

        echo "<pre>";
        print_r($marksheet);
        echo "</pre>";

        if ($exam == 'Annual Exam') {
            $total_fail = 0;
            $total_marks_sum = 0;
            $total_subject = 0;
            $total_grade_point = 0;
            $total_grade_point_without_forth = 0;

            $total_rows = count($marksheet);

            foreach ($marksheet as $id => $row) {

                $final = $row['final'] ?? [];

                $final_total = $final['total'] ?? 0;
                $final_gp    = $final['grade_point'] ?? 0;

                // skip combined rows
                if ($id == 1 || $id == 3) {
                    continue;
                }

                $total_marks_sum += $final_total;

                // last subject (4th subject logic)
                if ($total_rows == $id + 1 && !in_array($student['class'], [6, 7, 8])) {

                    $total_grade_point += max(0, $final_gp - 2);
                } else {

                    $total_fail += ($final_gp > 0) ? 0 : 1;
                    $total_grade_point += $final_gp;
                    $total_grade_point_without_forth += $final_gp;
                    $total_subject++;
                }
            }

            // GPA
            $gpa = $total_fail ? 0.00 : round(min(5, $total_grade_point / $total_subject), 2);
            $gpa_without_forth = $total_fail ? 0.00 : round(min(5, $total_grade_point_without_forth / $total_subject), 2);

            // Grade Letter
            $grade_letter = $total_fail ? 'F' : $this->gpToGrade($gpa);

            // Percentage
            $full_marks = array_sum(array_column($marksheet, 'full_mark'));
            $percentage = $full_marks > 0
                ? round(($total_marks_sum / $full_marks) * 100, 2)
                : 0;

            // ---------------- PREPARE DATA ----------------
            $rankingData = [
                'student_id'        => $student['id'],
                'class'             => $student['class'],
                'section'           => (stripos($student['section'], 'vocational') !== false) ? 'vocational' : 'general',
                'exam'              => $exam,
                'new_roll'          => '',
                'student_name'      => $student['student_name'],
                'past_roll'         => $student['roll'],
                'total'             => $total_marks_sum,
                'percentage'        => $percentage,
                'gpa'               => $gpa,
                'gpa_without_forth' => $gpa_without_forth,
                'grade_letter'      => $grade_letter,
                'fail'              => $total_fail,
                'year'              => $year,
                'updated_at'        => date('Y-m-d H:i:s'),
            ];
            // echo "{$student['id']} | {$student['class']} | {$student['roll']} | {$student['student_name']} | {$student['roll']} | {$total_marks_sum} | {$percentage}% | {$gpa} | {$gpa_without_forth} | {$grade_letter} | {$total_fail} | {$year}<br>";
            // ---------------- INSERT OR UPDATE ----------------
            $existing = $this->rankingModel
                ->where(['student_id' => $student['id'], 'year' => $year])
                ->first();
            if ($existing) {
                $this->rankingModel->update($existing['id'], $rankingData);
            } else {
                $rankingData['created_at'] = date('Y-m-d H:i:s');
                $this->rankingModel->insert($rankingData);
            }
        } else {
            $full_marks = 0;
            $total_marks = 0;
            $total_subject = 0;
            $total_fail = 0;
            $total_grade_point = 0;
            $total_grade_point_without_forth = 0;

            $total_rows = count($marksheet);

            foreach ($marksheet as $id => $row) {

                $full_marks += $row['full_mark'];
                // Detect 4th subject (last row for class 9–10)
                $isFourthSubject = (
                    $total_rows == $id + 1 &&
                    !in_array($student['class'], [6, 7, 8])
                );

                // Skip combined subjects (Bangla / English papers)
                if ($id == 1 || $id == 3) {
                    continue;
                }

                // Total marks
                $total_marks += $row['final']['total'];

                // Class 6–8
                if (in_array($student['class'], [6, 7, 8])) {

                    $total_fail += ($row['final']['grade_point'] > 0) ? 0 : 1;
                    $total_subject++;
                    $total_grade_point += $row['final']['grade_point'];
                    $total_grade_point_without_forth += $row['final']['grade_point'];
                } else {
                    // Class 9–10

                    if ($isFourthSubject) {
                        // 4th subject rule
                        $total_grade_point += max(0, $row['final']['grade_point'] - 2);
                    } else {
                        $total_fail += ($row['final']['grade_point'] > 0) ? 0 : 1;
                        $total_grade_point += $row['final']['grade_point'];
                        $total_grade_point_without_forth += $row['final']['grade_point'];
                        $total_subject++;
                    }
                }
            }

            // ---------- FINAL GPA ----------
            if ($total_subject > 0) {
                $gpa = $total_fail ? 0.00 : min(5, $total_grade_point / $total_subject);
                $gpa_without_forth = min(5, $total_grade_point_without_forth / $total_subject);
            } else {
                $gpa = 0.00;
                $gpa_without_forth = 0.00;
            }

            // Final grade letter
            $grade_letter = $total_fail ? 'F' : $this->gpToGrade($gpa);

            // Percentage (safe)
            $percentage = $total_subject > 0
                ? round(($total_marks / ($full_marks)) * 100, 2)
                : 0;

            // ---------- RANKING DATA ----------
            $rankingData = [
                'student_id'            => $student['id'],
                'class'                 => $student['class'],
                'section'               => (stripos($student['section'], 'vocational') !== false) ? 'vocational' : 'general',
                'exam'                  => $exam,
                'new_roll'              => '',
                'student_name'          => $student['student_name'],
                'past_roll'             => $student['roll'],
                'total'                 => $total_marks,
                'percentage'            => $percentage,
                'gpa'                   => number_format($gpa, 2),
                'gpa_without_forth'     => number_format($gpa_without_forth, 2),
                'grade_letter'          => $grade_letter,
                'fail'                  => $total_fail,
                'year'                  => $year,
                'updated_at'            => date('Y-m-d H:i:s'),
            ];

            echo "<pre>";
            print_r($rankingData);
            echo "</pre>";
            // ---------------- INSERT OR UPDATE ----------------
            $existing = $this->rankingModel
                ->where(['student_id' => $student['id'], 'year' => $year])
                ->first();
            if ($existing) {
                $this->rankingModel->update($existing['id'], $rankingData);
            } else {
                $rankingData['created_at'] = date('Y-m-d H:i:s');
                $this->rankingModel->insert($rankingData);
            }
        }
    }

    public function make_top_sheet()
    {
        $class = $this->request->getGet('class');
        $year  = $this->request->getGet('year');
        $exam  = $this->request->getGet('exam');
        $section_student = in_array($class, [9, 10]) ? $this->request->getGet('section') : 'general';

        // Get logged-in user ID
        $user_id = $this->session->get('user_id') ?? 0;

        // Default account status
        $account_status = 0;

        if ($user_id > 0) {
            // Fetch only the account_status column
            $user = $this->userModel->select('account_status')->find($user_id);

            if (!empty($user)) {
                $account_status = (int) $user['account_status'];
                if ($account_status < 2)
                    return redirect()->back()->with('error', 'Sorry, you are not permitted to perform this action');
            } else {
                return redirect()->back()->with('error', 'Sorry, you are not permitted to perform this action');
            }
        } else {
            return redirect()->back()->with('error', 'Sorry, you are not permitted to perform this action');
        }

        if (!$class || !$year) {
            return redirect()->back()->with('error', 'Class and Year are required');
        }

        $exam_db = $this->markingModel->where('exam_name', $exam)->first();

        $status = $exam_db['status'] ?? null;

        if ($exam_db == null || $status == 'closed') {
            return redirect()->back()->with('error', 'Sorry this exam is not open yet');
        }


        if (!$section_student) {
            return redirect()->back()->with('error', 'Section is required');
        }

        if ($section_student == 'vocational') {
            $students = $this->studentModel
                ->where('class', $class)
                ->where('permission', 0)
                ->where('section LIKE', '%Vocational%') // exclude vocational students
                ->orderBy('roll', 'ASC')
                ->findAll();
        } else {
            $students = $this->studentModel
                ->where('class', $class)
                ->where('permission', 0)
                ->where('section NOT LIKE', '%Vocational%') // exclude vocational students
                ->orderBy('roll', 'ASC')
                ->findAll();
        }
        foreach ($students as $student) {
            $studentId = $student['id'];
            $view = 1;
            $section   = $student['section'];

            // echo "{$studentId}  | {$section} | {$year}  | {$exam} <br>";

            if ($exam === 'Annual Exam') {
                // Annual exam goes to full result function
                $this->test_result($studentId, $year, $exam, $view);
            } elseif (in_array($exam, ['Pre-Test Exam', 'Half Yearly Exam', 'Test Exam'])) {
                // Other exams go to single exam function
                $this->test_result_single_exam($studentId, $year, $exam, $view);
            }
        }
        // echo $this->updateNewRollByClass($class, $year, $exam, $section_student) ? 'New Roll also saved' . '<br>' : 'New Roll is not saved' . '<br>';
    }

    public function updateNewRollByClass($class, $year, $exam, $section)
    {
        if ($section == 'vocational') {
            // 1️⃣ Get ordered ranking list
            $rankings = $this->rankingModel
                ->where('section LIKE', '%Vocational%')
                ->where('class', $class)
                ->where('year', $year)
                ->where('exam', $exam)
                ->orderBy('fail', 'ASC')
                ->orderBy('total', 'DESC')
                ->findAll();
        } else {
            $rankings = $this->rankingModel
                ->where('section NOT LIKE', '%Vocational%')
                ->where('class', $class)
                ->where('year', $year)
                ->where('exam', $exam)
                ->orderBy('fail', 'ASC')
                ->orderBy('total', 'DESC')
                ->findAll();
        }
        if (empty($rankings)) {
            return false;
        }

        // 2️⃣ Update new_roll serially
        $serial = 1;

        foreach ($rankings as $row) {
            $this->rankingModel->update($row['id'], [
                'new_roll'   => $serial,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            $serial++;
        }

        return true;
    }

    public function call_test_result()
    {
        // Get parameters from GET request
        $studentId = $this->request->getGet('student_id');
        $year      = $this->request->getGet('year');
        $exam      = $this->request->getGet('exam');
        $view      = $this->request->getGet('view');

        // Validation
        if (!$studentId || !$year || !$exam) {
            return redirect()->back()->with('error', 'Missing required parameters!');
        }

        if ($exam === 'Annual Exam') {
            // Annual exam goes to full result function
            return $this->test_result($studentId, $year, $exam, $view);
        } elseif (in_array($exam, ['Pre-Test Exam', 'Half Yearly Exam', 'Test Exam'])) {
            // Other exams go to single exam function
            return $this->test_result_single_exam($studentId, $year, $exam, $view);
        }

        // If exam name doesn't match any known exam
        return "no execution";
    }

    public function print_topsheet()
    {
        $class = $this->request->getGet('class');

        if (!$class) {
            return redirect()->back()->with('error', 'Please select a class');
        }

        // Class 9 & 10 → separate General and Vocational
        if (in_array($class, [9, 10])) {

            // General section
            $generalRankings = $this->rankingModel
                ->where('class', $class)
                ->where('section', 'general')
                ->orderBy('fail', 'ASC')
                ->orderBy('total', 'DESC')
                ->findAll();

            // Vocational section
            $vocationalRankings = $this->rankingModel
                ->where('class', $class)
                ->where('section', 'vocational')
                ->orderBy('fail', 'ASC')
                ->orderBy('total', 'DESC')
                ->findAll();

            return view('dashboard/print_topsheet', [
                'class'               => $class,
                'generalRankings'     => $generalRankings,
                'vocationalRankings'  => $vocationalRankings,
            ]);
        }

        // Class 6–8 → normal single list
        $rankings = $this->rankingModel
            ->where('class', $class)
            ->orderBy('fail', 'ASC')
            ->orderBy('total', 'DESC')
            ->findAll();

        echo "<pre>";
        print_r($rankings);
        echo "</pre>";

        return view('dashboard/print_topsheet', [
            'class'    => $class,
            'rankings' => $rankings,
        ]);
    }

    public function class_promote()
    {
        // Get logged-in user ID
        $user_id = $this->session->get('user_id') ?? 0;

        // Default account status
        $account_status = 0;

        if ($user_id > 0) {
            // Fetch only the account_status column
            $user = $this->userModel->select('account_status')->find($user_id);

            if (!empty($user)) {
                $account_status = (int) $user['account_status'];
                if ($account_status < 2)
                    return redirect()->back()->with('error', 'Sorry, you are not permitted to perform this action');
            } else {
                return redirect()->back()->with('error', 'Sorry, you are not permitted to perform this action');
            }
        } else {
            return redirect()->back()->with('error', 'Sorry, you are not permitted to perform this action');
        }

        $exam_db = $this->markingModel
            ->where('exam_name', 'Annual Exam')
            ->where('exam_name', 'Test Exam')
            ->first();

        $status = $exam_db['status'] ?? null;

        if ($exam_db == null || $status == 'closed') {
            return redirect()->back()->with('error', 'Sorry this exam is not open yet');
        }

        $students_info = $this->studentModel
            ->select('id, roll, class, section, assign_sub')
            ->where('class <', 11)
            ->findAll();

        $year = date('Y') - 1; // previous academic year

        foreach ($students_info as $student) {

            // 🔍 check if this student already backed up for this year
            $alreadyBackedUp = $this->studentBackupModel
                ->select('id')
                ->where('student_id', $student['id'])
                ->where('year', $year)
                ->first();

            // ⛔ if exists → skip
            if ($alreadyBackedUp) {
                continue;
            }

            // ✅ insert only once per year
            $this->studentBackupModel->insert([
                'student_id' => $student['id'],
                'roll'       => $student['roll'],
                'class'      => $student['class'],
                'section'    => $student['section'],
                'assign_sub' => $student['assign_sub'],
                'year'       => $year,
            ]);
        }

        $students_backup = $this->studentBackupModel
            ->select('student_id, class')
            ->where('year', $year)
            ->findAll();

        foreach ($students_backup as $backup) {

            $studentId = $backup['student_id'];
            $currentClass = $backup['class'];

            $this->studentModel->update($studentId, [
                'class' => $currentClass + 1, // promote
                'roll'  => '',                 // reset roll
            ]);
        }

        $rankings = $this->rankingModel
            ->select('student_id, new_roll')
            ->findAll();

        foreach ($rankings as $rank) {
            $this->studentModel->update($rank['student_id'], [
                'roll' => $rank['new_roll']
            ]);
        }

        return redirect()->to(base_url('admin/student'))
            ->with('success', 'Student backup completed (one-time per year).');
    }

    public function topsheet_form()
    {
        $this->data['title'] = 'Top Sheet';
        $this->data['activeSection'] = 'result';
        $this->data['navbarItems'] = [
            ['label' => 'Tabulation Sheet', 'url' => base_url('admin/tabulation_form')],
            ['label' => 'Marksheet', 'url' => base_url('admin/select-marksheet')],
            ['label' => 'Make Top Sheet', 'url' => base_url('admin/topsheet_form')],
            ['label' => 'Print Top Sheet', 'url' => base_url('admin/print_topsheet_form')],
        ];

        $this->data['exams'] = $this->resultModel->distinct()->select('exam')->orderBy('exam', 'ASC')->findAll();

        $this->data['class'] = $this->studentModel
            ->select('class')
            ->distinct()
            ->where('class <=', 10)  // <-- skip classes greater than 10
            ->orderBy('class', 'ASC')
            ->findAll();

        return view('dashboard/topsheet_form', $this->data);
    }

    public function print_topsheet_form()
    {
        $this->data['title'] = 'Top Sheet';
        $this->data['activeSection'] = 'result';
        $this->data['navbarItems'] = [
            ['label' => 'Tabulation Sheet', 'url' => base_url('admin/tabulation_form')],
            ['label' => 'Marksheet', 'url' => base_url('admin/select-marksheet')],
            ['label' => 'Make Top Sheet', 'url' => base_url('admin/topsheet_form')],
            ['label' => 'Print Top Sheet', 'url' => base_url('admin/print_topsheet_form')],
        ];

        $this->data['class'] = $this->studentModel
            ->select('class')
            ->distinct()
            ->where('class <=', 10)  // <-- skip classes greater than 10
            ->orderBy('class', 'ASC')
            ->findAll();

        return view('dashboard/print_topsheet_form', $this->data);
    }


    public function showMarksheet()
    {
        $this->data['title'] = 'Marksheet';
        $this->data['activeSection'] = 'result';
        $this->data['navbarItems'] = [
            ['label' => 'Tabulation Sheet', 'url' => base_url('admin/tabulation_form')],
            ['label' => 'Marksheet', 'url' => base_url('admin/select-marksheet')],
            ['label' => 'Make Top Sheet', 'url' => base_url('admin/topsheet_form')],
            ['label' => 'Print Top Sheet', 'url' => base_url('admin/print_topsheet_form')],
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

        $sections = $this->studentModel->select('section')->distinct()->orderBy('section')->findAll();

        $this->data['student'] = $student;
        $this->data['sections'] = $sections;

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

    public function calendar()
    {
        $this->data['title'] = 'Calendar';
        $this->data['activeSection'] = 'calendar';

        // Common navbar and sidebar for all views
        // Navbar
        $this->data['navbarItems'] = [
            ['label' => 'Calendar', 'url' => base_url('calendar')],
            ['label' => 'Leave', 'url' => base_url('admin/leave')],
            ['label' => 'Holiday', 'url' => base_url('admin/holiday')],
            ['label' => 'Routine', 'url' => base_url('admin/exam-routine')],
            ['label' => 'Admit', 'url' => base_url('admin/print-admit-form')],
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

        $data = [];

        foreach ($events as $event) {

            // build datetime
            $start = $event['start_date'];
            if (!empty($event['start_time'])) {
                $start .= 'T' . $event['start_time'];
            }

            $end = $event['end_date'];
            if (!empty($event['end_time'])) {
                $end .= 'T' . $event['end_time'];
            }

            $data[] = [
                'id'    => $event['id'],
                'title' => $event['title'],
                'start' => $start,
                'end'   => $end,
                'color' => $event['color'] ?? '#0d6efd'
            ];
        }

        return $this->response->setJSON($data);
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
            ['label' => 'Due', 'url' => base_url('admin/std_due')],
            ['label' => 'Report', 'url' => base_url('admin/pay_report')],
            ['label' => 'Salary', 'url' => base_url('admin/salary')],
            ['label' => 'Cost', 'url' => base_url('admin/cost')],
            ['label' => 'Statistics', 'url' => base_url('admin/pay_stat')],
            ['label' => 'Set Fees', 'url' => base_url('admin/set_fees')],
        ];

        $user_id = $this->session->get('user_id') ?? 0;
        $account_status = 0;
        if ($user_id > 0) {
            $user = $this->userModel->select('account_status')->find($user_id);
            if ($user) {
                $account_status = $user['account_status'];
            }
        }

        $this->data['account_status'] = $account_status;


        // ================= ALL TRANSACTIONS =================
        // $this->data['transactions'] = $this->transactionModel
        //     ->orderBy('created_at', 'DESC')
        //     ->findAll();
        $monthStart = date('Y-m-01 00:00:00');
        $monthEnd   = date('Y-m-t 23:59:59');

        $this->data['transactions'] = $this->transactionModel
            ->where('created_at >=', $monthStart)
            ->where('created_at <=', $monthEnd)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        // ================= TOTAL EARN (RAW AMOUNT) =================
        $totalEarnRow = $this->transactionModel
            ->where('status', 0)
            ->selectSum('amount')
            ->get()
            ->getRowArray();

        $totalEarnAmount = $totalEarnRow['amount'] ?? 0;

        // ================= TOTAL DISCOUNT (ONLY ONCE PER TRANSACTION_ID) =================
        $discountRow = db_connect()->query("
        SELECT SUM(discount) AS total_discount FROM (
            SELECT transaction_id, MAX(discount) AS discount
            FROM transactions
            WHERE status = 0
            GROUP BY transaction_id
        ) t
    ")->getRowArray();

        $totalDiscount = $discountRow['total_discount'] ?? 0;

        // ================= TOTAL COST =================
        $totalCostRow = $this->transactionModel
            ->where('status', 1)
            ->selectSum('amount')
            ->get()
            ->getRowArray();

        $totalCost = $totalCostRow['amount'] ?? 0;

        // ================= FINAL TOTALS =================
        $this->data['totalEarn'] = $totalEarnAmount - $totalDiscount;
        $this->data['totalCost'] = $totalCost;
        $this->data['totalDiscount'] = $totalDiscount;
        $this->data['netProfit'] = ($totalEarnAmount - $totalDiscount) - $totalCost;

        $builder = db_connect()->table('transactions');

        /* ================= ⭐ TODAY REPORT — HOURLY EARN VS COST ================= */
        $today = date('Y-m-d');

        $todayData = db_connect()->query("
    SELECT
        t1.hour,

        SUM(t1.earn) AS earn,
        SUM(t1.cost) AS cost,
        COALESCE(SUM(t1.discount),0) AS discount

    FROM (
        SELECT
            HOUR(created_at) AS hour,
            transaction_id,

            SUM(CASE WHEN status = 0 THEN amount ELSE 0 END) AS earn,
            SUM(CASE WHEN status = 1 THEN amount ELSE 0 END) AS cost,

            MAX(CASE WHEN status = 0 THEN discount ELSE 0 END) AS discount

        FROM transactions
        WHERE DATE(created_at) = '$today'
        GROUP BY transaction_id, HOUR(created_at)
    ) t1

    GROUP BY t1.hour
    ORDER BY t1.hour
")->getResultArray();

        // Prepare labels and values
        $this->data['todayLabels'] = array_map(fn($d) => $d['hour'] . ':00', $todayData);
        $this->data['todayEarns']  = array_map(fn($d) => floatval($d['earn'] - $d['discount']), $todayData);
        $this->data['todayCosts']  = array_map(fn($d) => floatval($d['cost']), $todayData);


        /* ================= ⭐ CURRENT MONTH DAILY REPORT ================= */
        $monthStart = date('Y-m-01');
        $monthEnd   = date('Y-m-t');

        $currentMonthData = db_connect()->query("
    SELECT 
        t1.date,
        SUM(t1.earn) AS earn,
        SUM(t1.cost) AS cost,
        COALESCE(SUM(t1.discount),0) AS discount

    FROM (
        SELECT 
            DATE(created_at) AS date,
            transaction_id,

            SUM(CASE WHEN status = 0 THEN amount ELSE 0 END) AS earn,
            SUM(CASE WHEN status = 1 THEN amount ELSE 0 END) AS cost,

            MAX(CASE WHEN status = 0 THEN discount ELSE 0 END) AS discount

        FROM transactions
        WHERE created_at BETWEEN '$monthStart' AND '$monthEnd'
        GROUP BY transaction_id, DATE(created_at)
    ) t1

    GROUP BY t1.date
    ORDER BY t1.date
")->getResultArray();

        $this->data['dailyLabels'] = array_column($currentMonthData, 'date');
        $this->data['dailyEarns']  = array_map(fn($d) => floatval($d['earn'] - $d['discount']), $currentMonthData);
        $this->data['dailyCosts']  = array_map(fn($d) => floatval($d['cost']), $currentMonthData);

        /* ================= ⭐ YEARLY MONTHLY SUMMARY ================= */
        $year = date('Y');

        $yearData = db_connect()->query("
    SELECT 
        t1.month,

        SUM(t1.earn) AS earn,
        SUM(t1.cost) AS cost,
        COALESCE(SUM(t1.discount), 0) AS discount

    FROM (
        SELECT 
            MONTH(created_at) AS month,
            transaction_id,

            -- earn: count ALL records (not grouped per transaction)
            SUM(CASE WHEN status = 0 THEN amount ELSE 0 END) AS earn,

            -- cost: normal sum
            SUM(CASE WHEN status = 1 THEN amount ELSE 0 END) AS cost,

            -- discount: only ONE per transaction_id
            MAX(CASE WHEN status = 0 THEN discount ELSE 0 END) AS discount

        FROM transactions
        WHERE YEAR(created_at) = $year
        GROUP BY transaction_id, MONTH(created_at)
    ) t1

    GROUP BY t1.month
    ORDER BY t1.month
")->getResultArray();


        $this->data['monthLabels'] = array_map(
            fn($m) => date('M', mktime(0, 0, 0, $m['month'], 10)),
            $yearData
        );

        $this->data['monthEarns'] = array_map(
            fn($d) => floatval($d['earn'] - $d['discount']),
            $yearData
        );

        $this->data['monthCosts'] = array_map(
            fn($d) => floatval($d['cost']),
            $yearData
        );


        return view('dashboard/transaction/transaction_dashboard', $this->data);
    }

    public function tec_pay()
    {
        $this->data['title'] = 'Teacher Earnings';
        $this->data['activeSection'] = 'accounts';

        $this->data['navbarItems'] = [
            ['label' => 'Accounts', 'url' => base_url('admin/transactions')],
            ['label' => 'Teacher', 'url' => base_url('admin/tec_pay')],
            ['label' => 'Students', 'url' => base_url('admin/std_pay')],
            ['label' => 'Due', 'url' => base_url('admin/std_due')],
            ['label' => 'Report', 'url' => base_url('admin/pay_report')],
            ['label' => 'Salary', 'url' => base_url('admin/salary')],
            ['label' => 'Cost', 'url' => base_url('admin/cost')],
            ['label' => 'Statistics', 'url' => base_url('admin/pay_stat')],
            ['label' => 'Set Fees', 'url' => base_url('admin/set_fees')],
        ];

        // Logged-in user account_status
        $user_id = $this->session->get('user_id') ?? 0;
        $account_status = 0;
        if ($user_id > 0) {
            $user = $this->userModel->select('account_status')->find($user_id);
            if ($user) {
                $account_status = $user['account_status'];
            }
        }

        // Fetch teachers
        // 🔹 Fetch teachers based on permission
        if ($account_status > 1) {
            // Admin / Accountant → all teachers
            $teachers = $this->userModel
                ->where('account_status !=', 0)
                ->orderBy('position', 'ASC')
                ->findAll();
        } else {
            // Teacher → only his own account
            $teachers = $this->userModel
                ->where('id', $user_id)
                ->where('account_status !=', 0)
                ->findAll();
        }

        // ===== Earnings calculation =====
        $builder = $this->transactionModel->builder();

        $subQuery = $builder
            ->select('
            receiver_id,
            transaction_id,
            SUM(amount) AS amount_sum,
            MAX(discount) AS discount_once
        ')
            ->where('status', 0)
            ->where('activity', 0)
            ->groupBy('receiver_id, transaction_id')
            ->getCompiledSelect();

        $finalBuilder = $this->transactionModel->builder("($subQuery) t");

        $totals = $finalBuilder
            ->select('
            receiver_id,
            SUM(amount_sum - discount_once) AS total_earned
        ')
            ->groupBy('receiver_id')
            ->get()
            ->getResultArray();

        $earnMap = array_column($totals, 'total_earned', 'receiver_id');

        foreach ($teachers as &$t) {
            $t['total_earned'] = $earnMap[$t['id']] ?? 0;

            // Fetch total already paid
            $paid = $this->userCollectionsPayModel
                ->select('SUM(amount_paid) as total_paid')
                ->where('user_id', $t['id'])
                ->first();

            $t['total_paid'] = $paid['total_paid'] ?? 0;
            $t['unpaid']     = $t['total_earned'] - $t['total_paid'];
        }



        $this->data['teachers'] = $teachers;
        $this->data['account_status'] = $account_status;

        return view('dashboard/transaction/tec_pay', $this->data);
    }

    public function view_tec_pay_details($id)
    {
        $this->data['title'] = 'Teacher Payment Details';
        $this->data['activeSection'] = 'accounts';

        $this->data['navbarItems'] = [
            ['label' => 'Accounts', 'url' => base_url('admin/transactions')],
            ['label' => 'Teacher', 'url' => base_url('admin/tec_pay')],
            ['label' => 'Students', 'url' => base_url('admin/std_pay')],
            ['label' => 'Due', 'url' => base_url('admin/std_due')],
            ['label' => 'Report', 'url' => base_url('admin/pay_report')],
            ['label' => 'Salary', 'url' => base_url('admin/salary')],
            ['label' => 'Cost', 'url' => base_url('admin/cost')],
            ['label' => 'Statistics', 'url' => base_url('admin/pay_stat')],
            ['label' => 'Set Fees', 'url' => base_url('admin/set_fees')],
        ];

        // Models
        // $teacherModel = new \App\Models\UserModel();
        // $payModel     = new \App\Models\UserCollectionsPayModel();

        // Teacher info
        $this->data['teacher'] = $this->userModel->find($id);

        // Payment history
        $this->data['payments'] = $this->userCollectionsPayModel
            ->where('user_id', $id)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        // Total paid
        $this->data['total_paid'] = $this->userCollectionsPayModel
            ->selectSum('amount_paid')
            ->where('user_id', $id)
            ->first()['amount_paid'] ?? 0;

        return view('dashboard/transaction/view_tec_pay_details', $this->data);
    }

    public function reset_amount($teacher_id = null)
    {
        $request = $this->request;
        $payAmount = $request->getPost('pay_amount');

        if (!$teacher_id || !$payAmount || $payAmount <= 0) {
            return redirect()->back()->with('error', 'Invalid data!');
        }

        $teacher = $this->userModel->find($teacher_id);

        if (!$teacher) {
            return redirect()->back()->with('error', 'Teacher not found!');
        }

        // Insert into the user_collections_pay table
        $this->userCollectionsPayModel->insert([
            'user_id'     => $teacher['id'],
            'user_name'   => $teacher['name'],
            'amount_paid' => $payAmount,
            'created_at'  => date('Y-m-d H:i:s')
        ]);

        // ===== Send simple email =====
        if (!empty($teacher['email'])) {
            $to      = $teacher['email'];
            $subject = 'Payment Received Notification';

            $message = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Payment Confirmation</title>
    </head>
    <body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
        <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: 20px auto; background-color: #ffffff; border: 1px solid #ddd; border-radius: 8px;">
            <tr>
                <td style="padding: 20px; text-align: center; background-color: #007bff; color: #ffffff; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                    <h2>Payment Confirmation</h2>
                </td>
            </tr>
            <tr>
                <td style="padding: 20px; color: #333333; font-size: 16px; line-height: 1.5;">
                    <p>Dear <strong>' . esc($teacher["name"]) . '</strong>,</p>
                    <p>We are pleased to inform you that a payment of <strong>৳ ' . number_format($payAmount, 2) . '</strong> has been successfully recorded in your account.</p>
                    <p>Thank you for your continued contribution.</p>
                    <p style="margin-top: 30px;">Best regards,<br>
                    <strong>Jhenaidah Cadet Coaching</strong></p>
                </td>
            </tr>
            <tr>
                <td style="padding: 15px; text-align: center; font-size: 12px; color: #888888; background-color: #f4f4f4; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
                    &copy; ' . date('Y') . ' Jhenaidah Cadet Coaching. All rights reserved.
                </td>
            </tr>
        </table>
    </body>
    </html>
    ';

            // Headers for HTML email
            $headers  = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8\r\n";
            $headers .= "From: Jhenaidah Cadet Coaching <no-reply@notes.com.bd>\r\n";  // Your domain email
            $headers .= "Reply-To: no-reply@notes.com.bd\r\n";

            // Send email using mail() with -f to set envelope sender
            $mailSent = mail($to, $subject, $message, $headers, "-fno-reply@notes.com.bd");

            if (!$mailSent) {
                log_message('error', 'Payment email could not be sent to ' . $to);
            }
        }

        return redirect()->back()->with('success', "Payment of ৳ " . number_format($payAmount, 2) . " recorded successfully!");
    }

    public function std_pay()
    {
        $this->data['title'] = 'Student Payment';
        $this->data['activeSection'] = 'payments';

        $this->data['navbarItems'] = [
            ['label' => 'Accounts', 'url' => base_url('admin/transactions')],
            ['label' => 'Teacher', 'url' => base_url('admin/tec_pay')],
            ['label' => 'Students', 'url' => base_url('admin/std_pay')],
            ['label' => 'Due', 'url' => base_url('admin/std_due')],
            ['label' => 'Report', 'url' => base_url('admin/pay_report')],
            ['label' => 'Salary', 'url' => base_url('admin/salary')],
            ['label' => 'Cost', 'url' => base_url('admin/cost')],
            ['label' => 'Statistics', 'url' => base_url('admin/pay_stat')],
            ['label' => 'Set Fees', 'url' => base_url('admin/set_fees')],
        ];

        $builder = $this->studentModel->builder();

        /* Get search & section */
        $search  = $this->request->getGet('search');
        $selectClass = $this->request->getGet('class');

        /* Search: roll / ID / name */
        if ($search) {
            $builder->groupStart()
                ->like('roll', $search)
                ->orLike('id', $search)
                ->orLike('student_name', $search)
                ->groupEnd();
        }

        /* Section filter only (আবাসিক / অনাবাসিক) */
        if ($selectClass) {
            $builder->where('class', $selectClass);
        }

        /* Students list */
        $this->data['students'] = $builder
            ->where('permission', 0)
            ->orderBy('student_name', 'ASC')
            ->get()
            ->getResultArray();

        $feesSummary = $this->feesAmountModel
            ->select('class, SUM(CASE WHEN unit = 0 THEN fees ELSE fees * unit END) AS total_fees')
            ->groupBy('class')
            ->orderBy('class', 'ASC')
            ->get()
            ->getResultArray();





        $classFees = [];
        foreach ($feesSummary as $row) {
            $class = trim($row['class']);
            $classFees[$class] = (float)$row['total_fees'];
        }



        $this->data['classFees'] = $classFees;

        $feesDeposit = $this->transactionModel
            ->select('sender_id, sender_name, SUM(amount) AS total_deposit')
            ->like('transaction_id', 'TX-', 'after')
            ->groupBy('sender_id, sender_name')
            ->orderBy('sender_name', 'ASC')
            ->get()
            ->getResultArray();

        $senderDeposits = [];

        foreach ($feesDeposit as $row) {
            $id = $row['sender_id'];
            $amount = (float)$row['total_deposit'];

            if (!isset($senderDeposits[$id])) {
                $senderDeposits[$id] = 0;
            }

            $senderDeposits[$id] += $amount;
        }

        $this->data['senderDeposits'] = $senderDeposits;

        $classs = $this->studentModel
            ->select('class')
            ->where('CAST(class AS UNSIGNED) <=', 10)
            ->distinct()
            ->orderBy('CAST(class AS UNSIGNED)', 'ASC', false)
            ->get()
            ->getResultArray();



        $fees  = $this->feesAmountModel->findAll();


        $month = date('n'); // 1–12

        $classTotals = [];

        foreach ($fees as $f) {
            $class = trim($f['class']);
            $unit    = (int) $f['unit'];
            $fee     = (float) $f['fees'];

            if ($unit <= 0) continue;

            $interval = 12 / $unit;

            // calculate cumulative total till current month
            for ($m = 1; $m <= $month; $m++) {

                if ($m === 1 || (($m - 1) % $interval === 0)) {
                    $classTotals[$class] = ($classTotals[$class] ?? 0) + $fee;
                }
            }
        }




        $this->data['classTotals'] = $classTotals;


        $this->data['class'] = array_column($classs, 'class');
        // $this->data['class'] = $class;

        /* Pass values to view */
        $this->data['search'] = $search;
        $this->data['selectedClass'] = $selectClass;

        return view('dashboard/transaction/std_pay', $this->data);
    }


    public function receipt($transactionId)
    {
        $this->data['title'] = 'Payment Receipt';
        $this->data['activeSection'] = 'accounts';

        $this->data['navbarItems'] = [
            ['label' => 'Accounts', 'url' => base_url('admin/transactions')],
            ['label' => 'Teacher', 'url' => base_url('admin/tec_pay')],
            ['label' => 'Students', 'url' => base_url('admin/std_pay')],
            ['label' => 'Due', 'url' => base_url('admin/std_due')],
            ['label' => 'Report', 'url' => base_url('admin/pay_report')],
            ['label' => 'Salary', 'url' => base_url('admin/salary')],
            ['label' => 'Cost', 'url' => base_url('admin/cost')],
            ['label' => 'Statistics', 'url' => base_url('admin/pay_stat')],
            ['label' => 'Set Fees', 'url' => base_url('admin/set_fees')],
        ];

        // Fetch all transactions with this ID
        $transactions = $this->transactionModel
            ->where('transaction_id', $transactionId)
            ->findAll();

        if (empty($transactions)) {
            return redirect()->to(base_url('admin/transactions'))
                ->with('error', 'Receipt not found.');
        }

        $first = $transactions[0];


        // Fetch student info
        $studentId = $first['sender_id'] ?? null;
        $student   = $studentId ? $this->studentModel->find($studentId) : [];

        $this->data['student'] = [
            'student_name'  => $first['sender_name'] ?? 'error',
            'id'            => $studentId ?? '',
            'roll'          => $student['roll'] ??  '',
            'section'       => $student['section'] ?? 'error',
        ];

        // Receiver info
        $this->data['receiver'] = [
            'name' => $first['receiver_name'] ?? 'error'
        ];

        $this->data['transaction_id'] = $transactionId;
        $this->data['date'] = $first['created_at'] ?? 'error';

        // Month names for display
        $monthNames = [
            1  => 'January',
            2  => 'February',
            3  => 'March',
            4  => 'April',
            5  => 'May',
            6  => 'June',
            7  => 'July',
            8  => 'August',
            9  => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December'
        ];

        $fees = [];
        $totalPaid = 0;
        $discountApplied = false;
        $discount = 0;

        foreach ($transactions as $t) {
            $amount = floatval($t['amount'] ?? 0);
            // Apply discount only once (first transaction with discount)
            if (!$discountApplied && !empty($t['discount'])) {
                $discount = floatval($t['discount']);
                $discountApplied = true;
            }
            // Convert month number to month name
            $monthName = isset($monthNames[intval($t['month'])]) ? $monthNames[intval($t['month'])] : '';

            $fees[] = [
                'title'  => $t['purpose'] ?? '',
                'month'  => $monthName,
                'amount' => $amount,
                'paid'   => ($t['payment_status'] ?? 0) == 1 ? true : false
            ];

            $totalPaid += $amount;
        }

        $this->data['fees'] = $fees;
        $this->data['discount'] = $discount ?? 0;
        $this->data['totalAmount'] = $totalPaid;
        $this->data['netAmount'] = $totalPaid - ($discount ?? 0);

        // Load receipt view
        return view('dashboard/transaction/receipt', $this->data);
    }

    public function studentPaymentReport()
    {

        $this->data['title'] = 'Today Student Payment Report';
        $this->data['activeSection'] = 'reports';
        $this->data['navbarItems'] = [
            ['label' => 'Accounts', 'url' => base_url('admin/transactions')],
            ['label' => 'Teacher', 'url' => base_url('admin/tec_pay')],
            ['label' => 'Students', 'url' => base_url('admin/std_pay')],
            ['label' => 'Due', 'url' => base_url('admin/std_due')],
            ['label' => 'Salary', 'url' => base_url('admin/salary')],
            ['label' => 'Cost', 'url' => base_url('admin/cost')],
            ['label' => 'Statistics', 'url' => base_url('admin/pay_stat')],
            ['label' => 'Set Fees', 'url' => base_url('admin/set_fees')],
        ];

        // ---------------- SQL QUERY (TODAY ONLY) ----------------
        $sql = "
        SELECT sender_name, receiver_name, month, total_pay, total_discount, net_amount
        FROM (
            SELECT
                sender_name,
                receiver_name,
                month,
                SUM(amount) AS total_pay,
                SUM(discount) AS total_discount,
                SUM(amount) - SUM(discount) AS net_amount,
                0 AS sort_order
            FROM (
                SELECT
                    transaction_id,
                    sender_name,
                    receiver_name,
                    month,
                    SUM(amount) AS amount,
                    MAX(discount) AS discount
                FROM transactions
                WHERE status = 0
                  AND DATE(created_at) = CURDATE()
                GROUP BY transaction_id, sender_name, receiver_name, month
            ) t
            GROUP BY sender_name, receiver_name, month

            UNION ALL

            SELECT
                'TOTAL' AS sender_name,
                '' AS receiver_name,
                '' AS month,
                SUM(amount) AS total_pay,
                SUM(discount) AS total_discount,
                SUM(amount) - SUM(discount) AS net_amount,
                1 AS sort_order
            FROM (
                SELECT
                    transaction_id,
                    SUM(amount) AS amount,
                    MAX(discount) AS discount
                FROM transactions
                WHERE status = 0
                  AND DATE(created_at) = CURDATE()
                GROUP BY transaction_id
            ) x
        ) final_table
        ORDER BY sort_order ASC, net_amount DESC
    ";

        $this->data['report'] = db_connect()->query($sql)->getResultArray();

        return view('dashboard/transaction/student_payment_report', $this->data);
    }

    public function sms_log()
    {
        $this->data['title'] = 'Student Payment';
        $this->data['activeSection'] = 'payments';

        $this->data['navbarItems'] = [
            ['label' => 'Accounts', 'url' => base_url('admin/transactions')],
            ['label' => 'Teacher', 'url' => base_url('admin/tec_pay')],
            ['label' => 'Students', 'url' => base_url('admin/std_pay')],
            ['label' => 'Due', 'url' => base_url('admin/std_due')],
            ['label' => 'Salary', 'url' => base_url('admin/salary')],
            ['label' => 'Cost', 'url' => base_url('admin/cost')],
            ['label' => 'Statistics', 'url' => base_url('admin/pay_stat')],
            ['label' => 'Set Fees', 'url' => base_url('admin/set_fees')],
        ];

        // Filter
        $selectedStatus = $this->request->getGet('status');
        $this->data['selectedStatus'] = $selectedStatus;

        // Query
        $query = $this->smsLogModel
            ->orderBy('created_at', 'DESC');

        if ($selectedStatus !== '' && $selectedStatus !== null) {
            $query->where('status', $selectedStatus);
        }

        // Pagination
        $this->data['smsList'] = $query->paginate(20);
        $this->data['pager']   = $this->smsLogModel->pager;

        // Stats
        $allSms = clone $query;

        $totalSms  = 0;
        $failedSms = 0;

        foreach ($allSms->findAll() as $row) {

            $length = mb_strlen($row['message'], 'UTF-8');

            $segments = preg_match('/[^\x00-\x7F]/', $row['message'])
                ? (($length <= 70) ? 1 : ceil($length / 67))
                : (($length <= 160) ? 1 : ceil($length / 153));

            if ($row['status']) {
                $totalSms += $segments;
            } else {
                $failedSms += $segments;
            }
        }

        $this->data['smsTotal']  = $totalSms;
        $this->data['smsFailed'] = $failedSms;

        return view('dashboard/transaction/sms_log', $this->data);
    }

    public function resendFailedSms()
    {
        $failedSms = $this->smsLogModel
            ->where('status', 0)
            ->findAll();

        $resendCount = 0;

        $successCodes = ['1000', '1001', '1002'];

        foreach ($failedSms as $sms) {

            $studentPhone = $sms['phone_number'] ?? '';

            if (!$studentPhone) continue;

            // Prevent duplicate 880
            if (!str_starts_with($studentPhone, '880')) {
                $studentPhone = '880' . ltrim($studentPhone, '0');
            }

            $message = $sms['message'];

            $apiKey   = env('sms.api');
            $callerID = "1234";

            $smsUrl = "https://bulksmsdhaka.net/api/sendtext?apikey={$apiKey}&callerID={$callerID}&number={$studentPhone}&message=" . urlencode($message);

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $smsUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);

            $response  = curl_exec($ch);
            $error     = curl_error($ch);
            $httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);

            $status = 0;
            $code   = null;

            // ✅ FIX: decode JSON response
            if (!$error && $response) {

                $data = json_decode($response, true);

                $code = $data['Status'] ?? null;

                if (in_array($code, $successCodes)) {
                    $status = 1;
                    $resendCount++;
                }
            }

            // Update log
            $this->smsLogModel->update($sms['id'], [
                'status'     => $status,
                'response'   => $response,
                'status_code' => $code,
                'error'      => $error,
                'http_code'  => $httpCode,
            ]);
        }

        session()->setFlashdata(
            'success',
            "$resendCount SMS(es) resent successfully."
        );

        return redirect()->to(base_url('admin/sms-log'));
    }

    public function cost()
    {
        $this->data['title'] = 'Cost Dashboard';
        $this->data['activeSection'] = 'accounts';

        $this->data['navbarItems'] = [
            ['label' => 'Accounts', 'url' => base_url('admin/transactions')],
            ['label' => 'Teacher', 'url' => base_url('admin/tec_pay')],
            ['label' => 'Students', 'url' => base_url('admin/std_pay')],
            ['label' => 'Due', 'url' => base_url('admin/std_due')],
            ['label' => 'Report', 'url' => base_url('admin/pay_report')],
            ['label' => 'Salary', 'url' => base_url('admin/salary')],
            ['label' => 'Cost', 'url' => base_url('admin/cost')],
            ['label' => 'Statistics', 'url' => base_url('admin/pay_stat')],
            ['label' => 'Set Fees', 'url' => base_url('admin/set_fees')],
        ];



        // Get cost history for current month excluding salaries
        $this->data['costs'] = $this->transactionModel
            ->where('status', 1)                   // only active records
            ->notLike('purpose', 'salary')         // exclude salary
            ->where('created_at >=', date('Y-m-01 00:00:00'))
            ->where('created_at <=', date('Y-m-t 23:59:59'))
            ->findAll();

        // Get all cost types for the dropdown
        $this->data['cost_types'] = $this->costTypeModel->findAll();

        return view('dashboard/transaction/cost', $this->data);
    }

    public function saveCost()
    {
        $typeId = $this->request->getPost('cost_type_id');
        $amount = $this->request->getPost('amount');
        $receiver_name = $this->request->getPost('receiver_name');
        $description = $this->request->getPost('description');

        // Basic validation
        if (!$typeId || !$amount || $amount <= 0) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Invalid cost data');
        }

        // Logged-in user
        $userId   = session()->get('user_id');
        $userName = session()->get('user_name');

        if (!$userId) {
            return redirect()->back()->with('error', 'User not logged in');
        }

        // Get cost type
        $costTypeModel = new CostTypeModel();
        $costType = $costTypeModel->find($typeId);

        if (!$costType) {
            return redirect()->back()->with('error', 'Invalid cost type');
        }

        // Generate unique transaction ID
        $transactionId = 'CST-' . date('YmdHis') . random_int(100, 999);

        // Month name (from current date)
        $monthName = date('n');

        $transactionModel = new TransactionModel();

        $transactionModel->insert([
            'transaction_id' => $transactionId,

            'sender_id'      => $userId,
            'sender_name'    => $userName,

            'receiver_id'    => null,
            'receiver_name'  => $receiver_name,

            'amount'         => $amount,
            'discount'       => 0,

            'month'          => $monthName,
            'purpose'        => 'cost-' . $costType['type_name'],
            'description'    => 'Cost for ' . $description,

            'payment_status' => 1,
            'status'         => 1,
            'activity'       => 0,
        ]);

        return redirect()->to(base_url('admin/cost'))
            ->with('success', 'Cost saved successfully');
    }

    public function cost_type()
    {
        $this->data['title'] = 'Cost Type Management';
        $this->data['activeSection'] = 'accounts';

        $this->data['navbarItems'] = [
            ['label' => 'Accounts', 'url' => base_url('admin/transactions')],
            ['label' => 'Teacher', 'url' => base_url('admin/tec_pay')],
            ['label' => 'Students', 'url' => base_url('admin/std_pay')],
            ['label' => 'Due', 'url' => base_url('admin/std_due')],
            ['label' => 'Report', 'url' => base_url('admin/pay_report')],
            ['label' => 'Salary', 'url' => base_url('admin/salary')],
            ['label' => 'Cost', 'url' => base_url('admin/cost')],
            ['label' => 'Statistics', 'url' => base_url('admin/pay_stat')],
            ['label' => 'Set Fees', 'url' => base_url('admin/set_fees')],
        ];

        // Load all cost types
        $this->data['costTypes'] = $this->costTypeModel
            ->orderBy('id', 'ASC')
            ->findAll();

        return view('dashboard/transaction/costType', $this->data);
    }

    public function save_cost_type()
    {
        $typeName = trim($this->request->getPost('type_name'));


        if ($typeName === '') {
            return redirect()->back()->with('error', 'Cost type cannot be empty');
        }

        // Prevent duplicate
        if ($this->costTypeModel->where('type_name', $typeName)->first()) {
            return redirect()->back()->with('error', 'Cost type already exists');
        }

        // Insert into database
        $this->costTypeModel->insert([
            'type_name' => $typeName
        ]);

        return redirect()->to('admin/cost_type')->with('success', 'Cost type added successfully');
    }

    public function delete_cost_type($id)
    {
        $costType = $this->costTypeModel->find($id);

        if (!$costType) {
            return redirect()->back()->with('error', 'Cost type not found');
        }

        $this->costTypeModel->delete($id);
        return redirect()->back()->with('success', 'Cost type deleted successfully');
    }

    public function salary()
    {
        $this->data['title'] = 'Salary Transactions';
        $this->data['activeSection'] = 'accounts';

        $this->data['navbarItems'] = [
            ['label' => 'Accounts', 'url' => base_url('admin/transactions')],
            ['label' => 'Teacher', 'url' => base_url('admin/tec_pay')],
            ['label' => 'Students', 'url' => base_url('admin/std_pay')],
            ['label' => 'Due', 'url' => base_url('admin/std_due')],
            ['label' => 'Report', 'url' => base_url('admin/pay_report')],
            ['label' => 'Salary', 'url' => base_url('admin/salary')],
            ['label' => 'Cost', 'url' => base_url('admin/cost')],
            ['label' => 'Statistics', 'url' => base_url('admin/pay_stat')],
            ['label' => 'Set Fees', 'url' => base_url('admin/set_fees')],
        ];

        // Fetch all salary transactions
        $rows = $this->transactionModel
            ->select('receiver_name, amount, created_at')
            ->where('status', 1)
            ->like('transaction_id', 'SAL') // Only SAL transactions
            ->orderBy('created_at', 'ASC')
            ->findAll();

        // Prepare yearly salary pivot
        $salaryData = [];
        foreach ($rows as $row) {
            $teacher = $row['receiver_name'];
            $month = date('n', strtotime($row['created_at'])); // 1-12
            $month = ($month == 1) ? 12 : $month - 1;
            $salaryData[$teacher][$month] = ($salaryData[$teacher][$month] ?? 0) + $row['amount'];
        }

        $this->data['salaryData'] = $salaryData;

        return view('dashboard/transaction/salary', $this->data);
    }

    public function salary_form()
    {
        $this->data['title'] = 'Teacher Salary';
        $this->data['activeSection'] = 'accounts';

        $this->data['navbarItems'] = [
            ['label' => 'Accounts', 'url' => base_url('admin/transactions')],
            ['label' => 'Teacher', 'url' => base_url('admin/tec_pay')],
            ['label' => 'Students', 'url' => base_url('admin/std_pay')],
            ['label' => 'Due', 'url' => base_url('admin/std_due')],
            ['label' => 'Report', 'url' => base_url('admin/pay_report')],
            ['label' => 'Salary', 'url' => base_url('admin/salary')],
            ['label' => 'Cost', 'url' => base_url('admin/cost')],
            ['label' => 'Statistics', 'url' => base_url('admin/pay_stat')],
            ['label' => 'Set Fees', 'url' => base_url('admin/set_fees')],
        ];

        // 🔑 Logged-in user
        $senderId = $this->session->get('user_id') ?? 0;

        $this->data['canPaySalary'] = false;

        if ($senderId > 0) {
            $sender = $this->userModel->select('id, account_status, name')->find($senderId);
            if ($sender && (int) $sender['account_status'] > 1) {
                $this->data['canPaySalary'] = true;
                $this->data['sender'] = $sender;
            }
        }

        $this->data['sections'] = $this->studentModel->select('section')->distinct()->orderBy('section')->findAll();
        // 👤 Fetch teachers
        $this->data['teachers'] = $this->userModel
            // ->where('role', 'teacher')
            ->where('account_status !=', 0)
            ->orderBy('name', 'ASC')
            ->findAll();

        return view('dashboard/transaction/salary_form', $this->data);
    }

    public function std_due()
    {
        $this->data['title'] = 'Due List';
        $this->data['activeSection'] = 'accounts';

        $this->data['navbarItems'] = [
            ['label' => 'Accounts', 'url' => base_url('admin/transactions')],
            ['label' => 'Teacher', 'url' => base_url('admin/tec_pay')],
            ['label' => 'Students', 'url' => base_url('admin/std_pay')],
            ['label' => 'Due', 'url' => base_url('admin/std_due')],
            ['label' => 'Report', 'url' => base_url('admin/pay_report')],
            ['label' => 'Salary', 'url' => base_url('admin/salary')],
            ['label' => 'Cost', 'url' => base_url('admin/cost')],
            ['label' => 'Statistics', 'url' => base_url('admin/pay_stat')],
            ['label' => 'Set Fees', 'url' => base_url('admin/set_fees')],
        ];

        // ===== Get Filters =====
        $selectedMonth   = (int) ($this->request->getGet('month') ?? date('n'));
        $selectedSection = $this->request->getGet('section') ?? 'all';
        $dueType         = $this->request->getGet('due_type') ?? 'due';



        $this->data['selectedMonth']   = $selectedMonth;
        $this->data['selectedSection'] = $selectedSection;

        // ===== Calculate Cumulative Fees up to Selected Month =====
        $fees = $this->feesAmountModel->findAll();
        $cumulativeFees = [];

        foreach ($fees as $f) {
            $section = trim($f['section']);
            $unit    = (int) $f['unit'];
            $fee     = (float) $f['fees'];

            if ($unit <= 0) continue;

            $interval = 12 / $unit;

            for ($m = 1; $m <= $selectedMonth; $m++) {
                if ($m === 1 || (($m - 1) % $interval === 0)) {
                    $cumulativeFees[$section] = ($cumulativeFees[$section] ?? 0) + $fee;
                }
            }
        }
        $this->data['monthFees'] = $cumulativeFees;

        // ===== Get Active Students =====
        $students = $this->studentModel
            ->where('permission', '0')
            ->orderBy('student_name', 'ASC')
            ->findAll();

        if ($selectedSection != 'all') {
            $students = array_filter($students, fn($std) => trim($std['section']) == $selectedSection);
        }
        $this->data['students'] = $students;

        // ===== Sections for Filter Dropdown =====
        $sectionRows = $this->studentModel
            ->select('TRIM(section) as section')
            ->where('section !=', null)
            ->where('section !=', '')
            ->groupBy('section')
            ->orderBy('section', 'ASC')
            ->findAll();

        $this->data['sectionRows'] = $sectionRows;

        // ===== Payment Summary (cumulative) =====
        $paymentSummary = [];
        $usedTransactionIds = []; // track discount counted per transaction

        $studentsPayments = $this->transactionModel
            ->select('transaction_id, sender_id, amount, discount, month')
            ->where('month <=', $selectedMonth)
            ->orderBy('id', 'ASC') // ensures first discount is used
            ->findAll();

        foreach ($studentsPayments as $p) {
            $sid = $p['sender_id'];
            $tid = $p['transaction_id'];

            // Paid = sum of amounts up to selected month
            $paymentSummary[$sid]['paid'] = ($paymentSummary[$sid]['paid'] ?? 0) + $p['amount'];

            // Discount = sum of first discount per transaction
            if (!in_array($tid, $usedTransactionIds)) {
                $paymentSummary[$sid]['discount'] = ($paymentSummary[$sid]['discount'] ?? 0) + ($p['discount'] ?? 0);
                $usedTransactionIds[] = $tid; // mark this transaction as counted
            }
        }

        $this->data['dueType']         = $dueType;
        $this->data['paymentSummary'] = $paymentSummary;

        // echo "<pre>";
        // print_r($paymentSummary);
        // echo "</pre>";

        return view('dashboard/transaction/std_due_list', $this->data);
    }

    public function std_due_csv()
    {
        $selectedMonth   = (int) ($this->request->getGet('month') ?? date('n'));
        $selectedSection = $this->request->getGet('section') ?? 'all';
        $dueType         = $this->request->getGet('due_type') ?? 'due';

        // ===== Calculate Cumulative Fees =====
        $fees = $this->feesAmountModel->findAll();
        $cumulativeFees = [];

        foreach ($fees as $f) {
            $section = trim($f['section']);
            $unit    = (int) $f['unit'];
            $fee     = (float) $f['fees'];

            if ($unit <= 0) continue;

            $interval = 12 / $unit;

            for ($m = 1; $m <= $selectedMonth; $m++) {
                if ($m === 1 || (($m - 1) % $interval === 0)) {
                    $cumulativeFees[$section] = ($cumulativeFees[$section] ?? 0) + $fee;
                }
            }
        }

        // ===== Students =====
        $students = $this->studentModel
            ->where('permission', '0')
            ->orderBy('student_name', 'ASC')
            ->findAll();

        if ($selectedSection != 'all') {
            $students = array_filter($students, fn($std) => trim($std['section']) == $selectedSection);
        }

        // ===== Payment Summary =====
        $paymentSummary = [];
        $usedTransactionIds = [];

        $studentsPayments = $this->transactionModel
            ->select('transaction_id, sender_id, amount, discount, month')
            ->where('month <=', $selectedMonth)
            ->orderBy('id', 'ASC')
            ->findAll();

        foreach ($studentsPayments as $p) {
            $sid = $p['sender_id'];
            $tid = $p['transaction_id'];

            $paymentSummary[$sid]['paid'] =
                ($paymentSummary[$sid]['paid'] ?? 0) + $p['amount'];

            if (!in_array($tid, $usedTransactionIds)) {
                $paymentSummary[$sid]['discount'] =
                    ($paymentSummary[$sid]['discount'] ?? 0) + ($p['discount'] ?? 0);
                $usedTransactionIds[] = $tid;
            }
        }

        // ===== CSV Headers =====
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=student_due_list.csv');

        $output = fopen('php://output', 'w');

        // Column Headers
        fputcsv($output, [
            'Student ID',
            'Student Name',
            'Phone',
            'Index',
            'Section',
            'Total Fee',
            'Paid',
            'Discount',
            'Net Due'
        ]);

        // ===== Data Rows =====
        foreach ($students as $std) {

            $sid = $std['id'];
            $sec = trim($std['section']);

            $totalFee = $cumulativeFees[$sec] ?? 0;
            $paid     = $paymentSummary[$sid]['paid'] ?? 0;
            $discount = $paymentSummary[$sid]['discount'] ?? 0;

            $netDue = $totalFee - $paid;

            // Skip if only due selected
            if ($dueType === 'due' && $netDue <= 0) {
                continue;
            }

            fputcsv($output, [
                $sid,
                $std['student_name'],
                $std['phone'],
                $std['roll'],
                $sec,
                number_format($totalFee, 2, '.', ''),
                number_format($paid, 2, '.', ''),
                number_format($discount, 2, '.', ''),
                number_format($netDue, 2, '.', '')
            ]);
        }

        fclose($output);
        exit;
    }

    public function pay_report()
    {
        $this->data['title'] = 'Payment Report';
        $this->data['activeSection'] = 'accounts';

        $this->data['navbarItems'] = [
            ['label' => 'Accounts', 'url' => base_url('admin/transactions')],
            ['label' => 'Teacher', 'url' => base_url('admin/tec_pay')],
            ['label' => 'Students', 'url' => base_url('admin/std_pay')],
            ['label' => 'Due', 'url' => base_url('admin/std_due')],
            ['label' => 'Report', 'url' => base_url('admin/pay_report')],
            ['label' => 'Salary', 'url' => base_url('admin/salary')],
            ['label' => 'Cost', 'url' => base_url('admin/cost')],
            ['label' => 'Statistics', 'url' => base_url('admin/pay_stat')],
            ['label' => 'Set Fees', 'url' => base_url('admin/set_fees')],
        ];

        $start_date = $this->request->getGet('start_date');
        $end_date   = $this->request->getGet('end_date');
        $type       = $this->request->getGet('type');
        $teacher_name = $this->request->getGet('teacher_name');
        $download   = $this->request->getGet('download'); // ✅ IMPORTANT

        $this->data['teacherList'] = $this->transactionModel
            ->select('receiver_name')
            ->where('activity', 'teacher')
            ->where('status', 0)
            ->where('receiver_name !=', null)
            ->distinct()
            ->findAll();

        $this->data['report'] = [];

        if ($start_date && $end_date) {

            $model = new TransactionModel();

            $start = $start_date . ' 00:00:00';
            $end   = $end_date . ' 23:59:59';

            $builder = $model->where('created_at >=', $start)
                ->where('created_at <=', $end);

            // ================= TYPE FILTER =================
            if ($type && $type != 'all_transaction') {

                if ($type == 'student') {
                    $builder->like('transaction_id', 'TX-', 'after');
                } elseif ($type == 'teacher') {
                    $builder->where('activity', 'teacher')
                        ->like('transaction_id', 'TX-', 'after');

                    if (!empty($teacher_name) && $teacher_name != 'all_teacher') {
                        $builder->where('receiver_name', $teacher_name);
                    }
                } elseif ($type == 'salary') {
                    $builder->like('transaction_id', 'SAL');
                } elseif ($type == 'cost') {
                    $builder->like('transaction_id', 'CST');
                }
            }

            $report = $builder->orderBy('created_at', 'DESC')->findAll();

            // =================================================
            // ✅ DOWNLOAD EXCEL (CSV)
            // =================================================
            if ($download == 1) {

                $filename = "payment_report_" . date('Ymd_His') . ".csv";

                header("Content-Type: text/csv");
                header("Content-Disposition: attachment; filename=$filename");

                $output = fopen("php://output", "w");

                // Header row
                fputcsv($output, [
                    'Date',
                    'Transaction ID',
                    'Sender',
                    'Receiver',
                    'Type',
                    'Amount',
                    'Discount',
                    'Month',
                    'Description'
                ]);

                $totalEarn = 0;
                $totalCost = 0;
                $totalDiscount = 0;
                $seenDiscount = [];

                foreach ($report as $row) {

                    $tid = $row['transaction_id'] ?? '-';
                    $amount = floatval($row['amount'] ?? 0);
                    $discount = floatval($row['discount'] ?? 0);
                    $status = $row['status'] ?? 0;

                    // Earn vs Cost
                    $typeLabel = ($status == 0) ? 'Earn' : 'Cost';

                    if ($status == 0) {
                        $totalEarn += $amount;
                    } else {
                        $totalCost += $amount;
                    }

                    // Unique discount
                    if (isset($seenDiscount[$tid])) {
                        $discount = '';
                    } else {
                        $totalDiscount += $discount;
                        $seenDiscount[$tid] = true;
                    }

                    fputcsv($output, [
                        date('d-m-Y', strtotime($row['created_at'])),
                        $tid,
                        $row['sender_name'] ?? '',
                        $row['receiver_name'] ?? '',
                        $typeLabel,
                        $amount,
                        $discount,
                        date('F', strtotime($row['created_at'])),
                        $row['description'] ?? ''
                    ]);
                }

                // Totals
                fputcsv($output, []);
                fputcsv($output, ['Total Earn', $totalEarn]);
                fputcsv($output, ['Total Cost', $totalCost]);
                fputcsv($output, ['Total Discount', $totalDiscount]);
                fputcsv($output, ['Net', $totalEarn - $totalCost - $totalDiscount]);

                fclose($output);
                exit;
            }

            $this->data['report'] = $report;
        }

        return view('dashboard/transaction/pay_report_form', $this->data);
    }

    // two date summation
    public function transaction_custome_date()
    {
        $fees = $this->feesAmountModel->findAll();

        $allMonths = [];

        for ($month = 1; $month <= 12; $month++) {

            foreach ($fees as $f) {

                $section = trim($f['section']);
                $unit    = (int) $f['unit'];
                $fee     = (float) $f['fees'];

                if ($unit <= 0) continue;

                $interval = 12 / $unit;

                for ($m = 1; $m <= $month; $m++) {

                    if ($m === 1 || (($m - 1) % $interval === 0)) {

                        // cumulative
                        $allMonths[$month][$section]['cumulative'] =
                            ($allMonths[$month][$section]['cumulative'] ?? 0) + $fee;

                        // current month only
                        if ($m == $month) {
                            $allMonths[$month][$section]['current'] =
                                ($allMonths[$month][$section]['current'] ?? 0) + $fee;
                        }
                    }
                }
            }
        }

        echo "<pre>";
        print_r($allMonths);
        echo "</pre>";
        exit;

        // $startDate = '2026-02-03 22:17:48';
        // $endDate   = '2026-02-05 23:59:59';
        // $receiver  = 'MD. ROKONUZZAMAN';

        // // Fetch transactions
        // $transactions = $this->transactionModel
        //     ->where('created_at >=', $startDate)
        //     ->where('created_at <=', $endDate)
        //     ->where('receiver_name', $receiver)
        //     ->orderBy('created_at', 'ASC')
        //     ->findAll();

        // // Group transactions by transaction_id
        // $grouped = [];
        // foreach ($transactions as $txn) {
        //     $tid = $txn['transaction_id'];

        //     if (!isset($grouped[$tid])) {
        //         $grouped[$tid] = [
        //             'transaction_id' => $tid,
        //             'created_at' => $txn['created_at'],
        //             'sender_name' => $txn['sender_name'],
        //             'receiver_name' => $txn['receiver_name'],
        //             'purpose' => $txn['purpose'],
        //             'month' => $txn['month'],
        //             'description' => $txn['description'],
        //             'amount_sum' => $txn['amount'],      // start sum
        //             'discount' => $txn['discount'],      // first occurrence
        //         ];
        //     } else {
        //         // Sum the amounts if multiple records with same transaction_id
        //         $grouped[$tid]['amount_sum'] += $txn['amount'];
        //     }
        // }

        // // Initialize totals
        // $totalAmount = 0;
        // $totalDiscount = 0;

        //         // Display table
        //         echo "Transaction from" . $startDate . " to " . $endDate . "<br>";
        // echo "<table border='1' cellpadding='5' cellspacing='0'>";
        // echo "<tr>
        //         <th>Date</th>
        //         <th>Transaction ID</th>
        //         <th>Sender</th>
        //         <th>Receiver</th>
        //         <th>Purpose</th>
        //         <th>Month</th>
        //         <th>Description</th>
        //         <th>Amount</th>
        //         <th>Discount</th>
        //         <th>Net Amount</th>
        //       </tr>";

        // foreach ($grouped as $txn) {
        //     $net = $txn['amount_sum'] - $txn['discount'];
        //     $totalAmount += $txn['amount_sum'];
        //     $totalDiscount += $txn['discount'];

        //     echo "<tr>
        //             <td>{$txn['created_at']}</td>
        //             <td>{$txn['transaction_id']}</td>
        //             <td>{$txn['sender_name']}</td>
        //             <td>{$txn['receiver_name']}</td>
        //             <td>{$txn['purpose']}</td>
        //             <td>{$txn['month']}</td>
        //             <td>{$txn['description']}</td>
        //             <td>{$txn['amount_sum']}</td>
        //             <td>{$txn['discount']}</td>
        //             <td>{$net}</td>
        //           </tr>";
        // }

        // // Total row
        // $grandNet = $totalAmount - $totalDiscount;
        // echo "<tr>
        //         <td colspan='7'><strong>Total</strong></td>
        //         <td><strong>{$totalAmount}</strong></td>
        //         <td><strong>{$totalDiscount}</strong></td>
        //         <td><strong>{$grandNet}</strong></td>
        //       </tr>";

        // echo "</table>";


    }

    public function pay_salary()
    {
        $teacherId = $this->request->getPost('teacher_id');
        $amount    = $this->request->getPost('amount');
        $month     = $this->request->getPost('month');
        $section = $this->request->getPost('section');

        if (!$teacherId || !$amount || !$month) {
            return redirect()->back()->with('error', 'Invalid salary data');
        }

        // 🔑 Logged-in user (sender)
        $senderId = $this->session->get('user_id') ?? 0;

        if ($senderId <= 0) {
            return redirect()->back()->with('error', 'Unauthorized access');
        }

        $sender = $this->userModel->find($senderId);
        if (!$sender || (int) $sender['account_status'] <= 1) {
            return redirect()->back()->with('error', 'You are not an admin');
        }

        // 👤 Teacher (receiver)
        $teacher = $this->userModel->find($teacherId);
        if (!$teacher) {
            return redirect()->back()->with('error', 'Teacher not found');
        }

        $transactionId = 'SAL-' . date('YmdHis') . rand(100, 999);


        $monthNumber = $this->request->getPost('month'); // '01' to '12'

        // Get current year
        $currentYear = date('Y');

        // Convert month number to full month name
        $monthName = date('F', mktime(0, 0, 0, $monthNumber, 1));

        // Description with current year
        $description = 'Salary paid for ' . $monthName . ' ' . $currentYear;


        $this->transactionModel->insert([
            'transaction_id' => $transactionId,

            // Sender (Admin)
            'sender_id'      => $sender['id'],
            'sender_name'    => $sender['name'],

            // Receiver (Teacher)
            'receiver_id'    => $teacher['id'],
            'receiver_name'  => $teacher['name'],

            'amount'         => $amount,
            'discount'       => 0,
            'month'          => $month,
            'purpose'        => 'salary-' . $section,
            'description'    => $description,
            'payment_status' => 1, // 1 for paid 0 for not paid
            'status'         => 1, // cost
            'activity'       => 'Teacher Salary Payment',
        ]);

        return redirect()->to(base_url('admin/transactions'))->with('success', 'Salary paid successfully');
    }

    public function pay_stat()
    {
        $this->data['title'] = 'Transaction Stat';
        $this->data['activeSection'] = 'accounts';

        $builder = $this->transactionModel
            ->select('transactions.*, students.section')
            ->join('students', 'students.id = transactions.sender_id', 'left');

        $transactions = $builder->findAll();

        $totalEarn = 0;
        $totalCost = 0;
        $totalDiscount = 0;

        $monthlyData = [];

        $residential = 0;
        $nonResidential = 0;

        $seenDiscount = [];

        foreach ($transactions as $t) {

            $month = date('M', strtotime($t['created_at']));
            $amount = floatval($t['amount']);
            $discount = floatval($t['discount'] ?? 0);
            $status = $t['status'];
            $tid = $t['transaction_id'];

            // monthly init
            if (!isset($monthlyData[$month])) {
                $monthlyData[$month] = ['earn' => 0, 'cost' => 0];
            }

            // earn / cost
            if ($status == 0) {
                $totalEarn += $amount;
                $monthlyData[$month]['earn'] += $amount;
            } else {
                $totalCost += $amount;
                $monthlyData[$month]['cost'] += $amount;
            }

            // ✅ DISCOUNT (UNIQUE)
            if ($discount > 0 && !isset($seenDiscount[$tid])) {
                $totalDiscount += $discount;
                $seenDiscount[$tid] = true;
            }

            // ================= RESIDENTIAL LOGIC =================
            $section = strtolower($t['section'] ?? '');

            // adjust based on your DB values
            if ($section == 'residential') {
                $residential += $amount;
            } elseif ($section == 'non-residential' || $section == 'day') {
                $nonResidential += $amount;
            }
        }

        $this->data['totalEarn'] = $totalEarn;
        $this->data['totalCost'] = $totalCost;
        $this->data['totalDiscount'] = $totalDiscount;

        $this->data['net'] = $totalEarn - $totalCost - $totalDiscount;

        $this->data['monthlyData'] = $monthlyData;

        $this->data['residential'] = $residential;
        $this->data['nonResidential'] = $nonResidential;

        return view('dashboard/transaction/pay_stat', $this->data);
    }

    public function set_fees()
    {
        $this->data['title'] = 'Transaction Dashboard';
        $this->data['activeSection'] = 'accounts';

        $this->data['navbarItems'] = [
            ['label' => 'Accounts', 'url' => base_url('admin/transactions')],
            ['label' => 'Teacher', 'url' => base_url('admin/tec_pay')],
            ['label' => 'Students', 'url' => base_url('admin/std_pay')],
            ['label' => 'Due', 'url' => base_url('admin/std_due')],
            ['label' => 'Report', 'url' => base_url('admin/pay_report')],
            ['label' => 'Salary', 'url' => base_url('admin/salary')],
            ['label' => 'Cost', 'url' => base_url('admin/cost')],
            ['label' => 'Statistics', 'url' => base_url('admin/pay_stat')],
            ['label' => 'Set Fees', 'url' => base_url('admin/set_fees')],
        ];

        // ✅ ONLY SECTION
        $class = $this->request->getGet('class');


        $this->data['selectedClass'] = $class;

        // Fee titles
        $this->data['titles'] = $this->feesModel->findAll();

        $existingAmounts = [];
        $existingUnits   = [];
        $existingUpdates = [];
        $totalAmount     = 0;

        if ($class) {
            $amounts = $this->feesAmountModel
                ->where('class', $class)
                ->findAll();


            foreach ($amounts as $a) {
                $existingAmounts[$a['title_id']] = $a['fees'];
                $existingUnits[$a['title_id']]   = $a['unit'];
                $existingUpdates[$a['title_id']] = $a['updated_at'];

                if (is_numeric($a['fees']) && is_numeric($a['unit'])) {
                    $totalAmount += $a['fees'] * $a['unit'];
                }
            }
        }

        // echo "<pre>";
        // print_r($amounts);
        // echo "</pre>";

        // $classRows = $this->studentModel
        //     ->select('class')
        //     ->where('class <=', 10)
        //     ->distinct()
        //     ->orderBy('class', 'ASC')
        //     ->findAll();

        $classRows = $this->studentModel
            ->select('class')
            ->where('CAST(class AS UNSIGNED) <=', 10)
            ->distinct()
            ->orderBy('CAST(class AS UNSIGNED)', 'ASC')
            ->findAll();
            
        $this->data['classRows'] = $classRows;

        $this->data['existingAmounts'] = $existingAmounts;
        $this->data['existingUnits']   = $existingUnits;
        $this->data['existingUpdates'] = $existingUpdates;
        $this->data['totalAmount']     = $totalAmount;

        // return view('dashboard/transaction/set_fees', $this->data);
    }

    public function save_fees()
    {
        $class   = $this->request->getPost('class');
        $feesData  = $this->request->getPost('fees');
        $unitsData = $this->request->getPost('unit');


        if (!$class) {
            return redirect()->back()->with('error', 'Please select a section before saving.');
        }

        if (empty($feesData)) {
            return redirect()->back()->with('error', 'No fee amounts to save.');
        }

        $amountModel = new FeesAmountModel();

        foreach ($feesData as $title_id => $amount) {

            if ($amount === '' || $amount === null) {
                continue;
            }

            $unit = $unitsData[$title_id] ?? null;

            $existing = $this->feesAmountModel
                ->where('class', $class)
                ->where('title_id', $title_id)
                ->first();

            if ($existing) {
                // UPDATE
                $amountModel->update($existing['id'], [
                    'fees'       => $amount,
                    'unit'       => $unit,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            } else {
                // INSERT
                $amountModel->insert([
                    'class'    => $class,
                    'title_id'   => $title_id,
                    'fees'       => $amount,
                    'unit'       => $unit,
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
            ['label' => 'Due', 'url' => base_url('admin/std_due')],
            ['label' => 'Report', 'url' => base_url('admin/pay_report')],
            ['label' => 'Salary', 'url' => base_url('admin/salary')],
            ['label' => 'Cost', 'url' => base_url('admin/cost')],
            ['label' => 'Statistics', 'url' => base_url('admin/pay_stat')],
            ['label' => 'Set Fees', 'url' => base_url('admin/set_fees')],
        ];

        // 🧍 Student
        $student = $this->studentModel->find($id);
        if (!$student) {
            return redirect()->back()->with('error', 'Student not found.');
        }

        $student_discount = $this->studentDiscountModel
            ->where('student_id', $id)
            ->first();



        // 🎓 Fee titles
        $fees = $this->feesModel->findAll();

        // 💰 SECTION-wise fees ONLY (✅ class removed)
        $sectionFees = $this->feesAmountModel
            ->where('section', trim($student['section'])) // আবাসিক / অনাবাসিক
            ->findAll();

        // 🧾 Map fee & unit
        $feeAmounts = [];
        $feeUnit    = [];

        foreach ($sectionFees as $f) {
            $feeAmounts[$f['title_id']] = (float) $f['fees'];
            $feeUnit[$f['title_id']]    = (int) $f['unit'];
        }

        // 👨‍🏫 Receiver
        $userId   = session()->get('user_id');
        $receiver = $this->userModel->find($userId);

        $payments = $this->transactionModel
            ->where('sender_id', $id)
            ->like('transaction_id', 'TX-', 'after')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        // ✅ Calculate total paid
        $totalPaid = array_sum(array_column($payments, 'amount'));
        $totalDiscount = array_sum(array_column($payments, 'discount'));

        // Logged-in user account_status
        $user_id = $this->session->get('user_id') ?? 0;
        $account_status = 0;
        if ($user_id > 0) {
            $user = $this->userModel->select('account_status')->find($user_id);
            if ($user) {
                $account_status = $user['account_status'];
            }
        }

        // 📦 Send to view
        $this->data['student']          = $student;
        $this->data['fees']             = $fees;
        $this->data['feeAmounts']       = $feeAmounts;
        $this->data['feeUnit']          = $feeUnit;
        $this->data['receiver']         = $receiver;
        $this->data['pay_history']      = $payments;
        $this->data['student_discount'] = $student_discount['amount'] ?? 0;
        $this->data['totalPaid']        = $totalPaid;
        $this->data['totalDiscount']    = $totalDiscount;
        $this->data['account_status']   = $account_status;


        return view('dashboard/transaction/payStudentRequest', $this->data);
    }

    public function studentPayment()
    {
        $request = $this->request;

        // ---------- INPUT ----------
        $studentId     = $request->getPost('student_id');
        $receiverId    = $request->getPost('receiver_id');
        $discount      = floatval($request->getPost('discount') ?? 0);
        $monthNumber   = intval($request->getPost('month') ?? date('m')); // get as number
        $paymentStatus = intval($request->getPost('payment_status'));      // 1 = paid | 0 = due

        $feeIds  = $request->getPost('fee_id') ?? [];
        $amounts = $request->getPost('amount') ?? [];

        $student  = $this->studentModel->find($studentId);
        $receiver = $this->userModel->find($receiverId);

        // ---------- TOTAL ----------
        $totalAmount = 0;
        foreach ($amounts as $amt) {
            $totalAmount += floatval($amt);
        }

        // ---------- TRANSACTION ID ----------
        $transactionId = 'TX-' . date('YmdHis') . rand(100, 999);

        // ---------- MONTH NAMES ----------
        $monthNames = [
            1  => 'January',
            2  => 'February',
            3  => 'March',
            4  => 'April',
            5  => 'May',
            6  => 'June',
            7  => 'July',
            8  => 'August',
            9  => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        ];
        $monthName = $monthNames[$monthNumber] ?? 'Unknown';

        // ---------- PAYMENT STATUS TEXT ----------
        $paymentStatusText = $paymentStatus ? 'paid' : 'due';

        // ---------- INSERT TRANSACTIONS ----------
        foreach ($feeIds as $index => $feeId) {

            $amount = floatval($amounts[$index] ?? 0);
            if ($amount <= 0) continue;

            $feeTitleRow = $this->feesModel->find($feeId);
            $feeTitle = $feeTitleRow['title'] ?? 'Fee';

            $this->transactionModel->insert([
                'transaction_id' => $transactionId,
                'sender_id'      => $studentId,
                'sender_name'    => $student['student_name'] ?? '',
                'receiver_id'    => $receiverId,
                'receiver_name'  => $receiver['name'] ?? '',
                'amount'         => $amount,
                'discount'       => $discount,
                'month'          => $monthNumber,
                'purpose'        => $feeTitle,
                'description'    => "Payment for {$feeTitle}",
                'status'         => 0,          // pending
                'activity'       => 0,          // extra tracking
                'payment_status' => $paymentStatus
            ]);
        }

        // ---------- SAVE DISCOUNT ----------
        if ($request->getPost('apply_discount')) {
            $existingDiscount = $this->studentDiscountModel->where('student_id', $studentId)->first();
            if ($existingDiscount) {
                $this->studentDiscountModel->update($existingDiscount['id'], [
                    'amount' => $discount,
                ]);
            } else {
                $this->studentDiscountModel->insert([
                    'student_id' => $studentId,
                    'amount'     => $discount,
                ]);
            }
        }

        // ---------- SEND SMS ----------
        $studentPhone = $student['phone'] ?? '';

        if ($studentPhone) {

            // Prevent duplicate 880
            if (!str_starts_with($studentPhone, '880')) {
                $studentPhone = '880' . ltrim($studentPhone, '0');
            }

            $message = "Dear {$student['student_name']}, your payment for {$monthName} is {$paymentStatusText}. --Jhenaidah Cadet Coaching";

            $apiKey   = env('sms.api');
            $callerID = "1234";

            $smsUrl = "https://bulksmsdhaka.net/api/sendtext?apikey={$apiKey}&callerID={$callerID}&number={$studentPhone}&message=" . urlencode($message);

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $smsUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);

            $response = curl_exec($ch);
            $error    = curl_error($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);

            // ---------- DEFAULT ----------
            $smsStatus = 0;
            $code      = null;

            $successCodes = ['1000', '1001', '1002'];

            // ---------- SAFE JSON CHECK ----------
            if (!$error && $response) {

                $data = json_decode($response, true);

                if (json_last_error() === JSON_ERROR_NONE) {

                    $code = $data['Status'] ?? null;

                    if (in_array($code, $successCodes)) {
                        $smsStatus = 1;
                    }
                }
            }

            // ---------- LOG SMS ----------
            $this->smsLogModel->insert([
                'student_name' => $student['student_name'],
                'phone_number' => $studentPhone,
                'message'      => $message,
                'response'     => $response,
                'status_code'  => $code,
                'error'        => $error,
                'http_code'    => $httpCode,
                'status'       => $smsStatus,
                'created_at'   => date('Y-m-d H:i:s'),
            ]);
        }

        // ---------- REDIRECT TO RECEIPT ----------
        return redirect()->to(base_url('admin/receipt/' . $transactionId));
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
            ['label' => 'Due', 'url' => base_url('admin/std_due')],
            ['label' => 'Report', 'url' => base_url('admin/pay_report')],
            ['label' => 'Salary', 'url' => base_url('admin/salary')],
            ['label' => 'Cost', 'url' => base_url('admin/cost')],
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
            ->like('transaction_id', 'TX-', 'after')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        // ✅ Calculate total paid
        // ✅ Calculate total paid
        $totalPaid = 0;
        $discountsByTransaction = [];

        foreach ($payments as $payment) {

            // Sum all amounts normally
            $totalPaid += $payment['amount'];

            // Store discount only once per transaction_id
            $transactionId = $payment['transaction_id'];

            if (!isset($discountsByTransaction[$transactionId])) {
                $discountsByTransaction[$transactionId] = $payment['discount'];
            }
        }

        $totalDiscount = array_sum($discountsByTransaction);

        // ✅ Pass data to view
        $this->data['student']   = $student;
        $this->data['payments']  = $payments;
        $this->data['totalPaid'] = $totalPaid - $totalDiscount;

        return view('dashboard/transaction/student_payment_history', $this->data);
    }

    // welcome page

    public function welcomeMessages()
    {
        $this->data['title'] = 'Welcome Message List';
        $this->data['activeSection'] = 'welcome_message';
        $this->data['navbarItems'] = [
            ['label' => 'Welcome Messages', 'url' => current_url()],
            ['label' => 'Add Welcome Message', 'url' => base_url('admin/welcomeMessageForm')],
        ];

        // Fetch all welcome messages (Newest first)
        $this->data['welcomeMessages'] = $this->welcomeMessageModel
            ->orderBy('id', 'DESC')
            ->findAll();

        return view('dashboard/welcome_message_list', $this->data);
    }

    public function welcomeMessageForm($id = null)
    {
        $this->data['title'] = $id ? 'Edit Welcome Message' : 'Add Welcome Message';
        $this->data['activeSection'] = 'welcome_message';
        $this->data['navbarItems'] = [
            ['label' => 'Welcome Messages', 'url' => base_url('admin/welcome-message')],
            ['label' => 'Add Welcome Message', 'url' => current_url()],
        ];

        if ($id) {
            $this->data['welcome'] = $this->welcomeMessageModel->find($id);
        }

        return view('dashboard/welcome_message_form', $this->data);
    }

    public function saveWelcomeMessage()
    {
        $id     = $this->request->getPost('id');
        $status = $this->request->getPost('status');

        $data = [
            'title'   => $this->request->getPost('title'),
            'message' => $this->request->getPost('message'),
            'status'  => $status,
        ];

        // Handle Photo Upload
        $photo = $this->request->getFile('photo');
        if ($photo && $photo->isValid() && !$photo->hasMoved()) {
            $newName = $photo->getRandomName();
            $photo->move(FCPATH . 'uploads/welcome/', $newName);
            $data['photo'] = $newName;
        }

        if ($status == 1) {

            if ($id) {
                // Editing → make all OTHER records inactive
                $this->welcomeMessageModel
                    ->where('id !=', $id)
                    ->set(['status' => 0])
                    ->update();
            } else {
                // Inserting new → make ALL existing inactive
                $this->welcomeMessageModel
                    ->where('id >', 0)   // safe condition
                    ->set(['status' => 0])
                    ->update();
            }
        }

        // Insert or Update
        if ($id) {
            $this->welcomeMessageModel->update($id, $data);
            session()->setFlashdata('success', 'Welcome Message Updated Successfully');
        } else {
            $this->welcomeMessageModel->insert($data);
            session()->setFlashdata('success', 'Welcome Message Added Successfully');
        }

        return redirect()->to(base_url('admin/welcomeMessages'));
    }

    public function deleteWelcomeMessage($id)
    {
        $welcome = $this->welcomeMessageModel->find($id);

        if (!$welcome) {
            session()->setFlashdata('error', 'Welcome Message Not Found');
            return redirect()->back();
        }

        // Delete image if exists
        if (!empty($welcome['photo']) && file_exists(FCPATH . 'uploads/welcome/' . $welcome['photo'])) {
            unlink(FCPATH . 'uploads/welcome/' . $welcome['photo']);
        }

        $this->welcomeMessageModel->delete($id);

        session()->setFlashdata('success', 'Welcome Message Deleted Successfully');

        return redirect()->to(base_url('admin/welcomeMessages'));
    }

    public function teacherAttendance()
    {
        $selectedMonth   = $this->request->getGet('month') ?? date('Y-m');
        $selectedTeacher = $this->request->getGet('teacher');

        $this->data['title'] = 'Teacher Attendance';
        $this->data['activeSection'] = 'teacher_attendance';

        // ✅ All Active Teachers
        $builder = $this->userModel->where('account_status >', 0);

        if (!empty($selectedTeacher)) {
            $builder->where('id', $selectedTeacher);
        }

        $teachers = $builder->orderBy('position', 'ASC')->findAll();
        $allTeachers = $this->userModel
            ->where('account_status >', 0)
            ->orderBy('position', 'ASC')
            ->findAll();

        // ✅ Build Month Days
        $daysInMonth = [];
        $numDays = date('t', strtotime($selectedMonth . '-01'));

        for ($d = 1; $d <= $numDays; $d++) {
            $date = $selectedMonth . '-' . sprintf("%02d", $d);
            $daysInMonth[] = [
                'date' => $date,
                'day'  => date('D', strtotime($date))
            ];
        }

        // ✅ Fetch Attendance Records
        $attendanceData = $this->teacherAttendanceModel
            ->where('created_at >=', $selectedMonth . '-01 00:00:00')
            ->where('created_at <=', $selectedMonth . '-' . $numDays . ' 23:59:59')
            ->findAll();

        $attendanceMap = [];

        $schoolStart = '10:00:00';
        $schoolEnd   = '16:00:00';

        // -------------------------
        // STORE ARRIVAL & LEAVE
        // -------------------------
        foreach ($attendanceData as $record) {

            if (!isset($record['teacher_id'])) continue;

            $tid  = $record['teacher_id'];
            $date = date('Y-m-d', strtotime($record['created_at']));
            $time = date('H:i:s', strtotime($record['created_at']));

            if (!isset($attendanceMap[$tid][$date])) {
                $attendanceMap[$tid][$date] = [
                    'arrival' => null,
                    'leave'   => null,
                    'remark'  => 'A'
                ];
            }

            if ($record['remark'] === 'A') {
                $attendanceMap[$tid][$date]['arrival'] = $time;
            }

            if ($record['remark'] === 'L') {
                $attendanceMap[$tid][$date]['leave'] = $time;
            }
        }

        // -------------------------
        // FINAL STATUS CALCULATION
        // -------------------------
        foreach ($attendanceMap as $tid => $dates) {
            foreach ($dates as $date => $data) {

                $arrival = $data['arrival'];
                $leave   = $data['leave'];

                // If only arrival exists
                if ($arrival && !$leave) {
                    $attendanceMap[$tid][$date]['remark'] = 'C';
                    continue;
                }

                // If only leave exists
                if (!$arrival && $leave) {
                    $attendanceMap[$tid][$date]['remark'] = 'P';
                    continue;
                }

                // If no punch at all
                if (!$arrival && !$leave) {
                    $attendanceMap[$tid][$date]['remark'] = 'A';
                    continue;
                }

                if ($arrival <= $schoolStart && $leave >= $schoolEnd) {
                    $attendanceMap[$tid][$date]['remark'] = 'P';
                } elseif ($arrival <= $schoolStart && $leave < $schoolEnd) {
                    $attendanceMap[$tid][$date]['remark'] = 'E';
                } elseif ($arrival > $schoolStart && $leave >= $schoolEnd) {
                    $attendanceMap[$tid][$date]['remark'] = 'L';
                } else {
                    $attendanceMap[$tid][$date]['remark'] = 'L/E';
                }
            }
        }

        // -------------------------
        // FILL MISSING DAYS
        // -------------------------
        foreach ($allTeachers as $teacher) {
            foreach ($daysInMonth as $day) {

                $date = $day['date'];
                $dayName = $day['day'];
                $tid = $teacher['id'];

                if (!isset($attendanceMap[$tid][$date])) {

                    $attendanceMap[$tid][$date] = [
                        'arrival' => null,
                        'leave'   => null,
                        'remark'  => in_array($dayName, ['Fri', 'Sat']) ? 'H' : 'A'
                    ];
                }
            }
        }

        $this->data['teachers'] = $teachers;
        $this->data['allTeachers'] = $allTeachers;
        $this->data['selectedTeacher'] = $selectedTeacher;
        $this->data['selectedMonth'] = $selectedMonth;
        $this->data['daysInMonth'] = $daysInMonth;
        $this->data['attendanceMap'] = $attendanceMap;

        return view('dashboard/teacher_attendance', $this->data);
    }

    // Show all sliders
    public function sliders()
    {
        $this->data['title'] = 'Slider List';
        $this->data['activeSection'] = 'slider';
        $this->data['navbarItems'] = [
            ['label' => 'Slider List', 'url' => current_url()],
            ['label' => 'Add Slider', 'url' => base_url('admin/sliderForm')],
        ];

        $this->data['sliders'] = $this->sliderModel
            ->orderBy('id', 'DESC')
            ->findAll();

        return view('dashboard/slider/slider_list', $this->data);
    }

    // Show add form
    public function sliderForm()
    {
        $this->data['title'] = 'Slider Form';
        $this->data['activeSection'] = 'slider';
        $this->data['navbarItems'] = [
            ['label' => 'Slider List', 'url' => base_url('admin/sliders')],
            ['label' => 'Add Slider', 'url' => current_url()],
        ];

        return view('dashboard/slider/slider_form', $this->data);
    }

    // Save new slider
    public function saveSlider()
    {
        $status = $this->request->getPost('status') ?? 0;

        $data = [
            'title'      => $this->request->getPost('title'),
            'caption'    => $this->request->getPost('caption'),
            'status'     => $status,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        // Handle image upload
        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/sliders', $newName);
            $data['image'] = $newName;
        }


        $this->sliderModel->insert($data);

        return redirect()->to('admin/sliders')
            ->with('success', 'Slider added successfully!');
    }

    // Edit form update
    public function editSlider($id)
    {
        $this->data['title'] = 'Edit Slider';
        $this->data['activeSection'] = 'slider';
        $this->data['navbarItems'] = [
            ['label' => 'Slider List', 'url' => base_url('admin/sliders')],
            ['label' => 'Edit Slider', 'url' => current_url()],
        ];

        $this->data['slider'] = $this->sliderModel->find($id);

        if (!$this->data['slider']) {
            return redirect()->to('admin/sliders')
                ->with('error', 'Slider not found');
        }

        return view('dashboard/slider/slider_form_edit', $this->data);
    }

    // Update existing slider
    public function updateSlider($id)
    {
        $slider = $this->sliderModel->find($id);

        if (!$slider) {
            return redirect()->to('admin/sliders')
                ->with('error', 'Slider not found');
        }

        $status = $this->request->getPost('status');

        $data = [
            'title'   => $this->request->getPost('title'),
            'caption' => $this->request->getPost('caption'),
            'status'  => $status,
        ];

        // Image update
        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && !$file->hasMoved()) {

            if (!empty($slider['image']) && file_exists('uploads/sliders/' . $slider['image'])) {
                unlink('uploads/sliders/' . $slider['image']);
            }

            $newName = $file->getRandomName();
            $file->move('uploads/sliders', $newName);
            $data['image'] = $newName;
        }


        $this->sliderModel->update($id, $data);

        return redirect()->to('admin/sliders')
            ->with('success', 'Slider updated successfully!');
    }

    // Delete slider
    public function deleteSlider($id)
    {
        $slider = $this->sliderModel->find($id);

        if ($slider) {

            if (!empty($slider['image']) && file_exists('uploads/sliders/' . $slider['image'])) {
                unlink('uploads/sliders/' . $slider['image']);
            }

            $this->sliderModel->delete($id);
        }

        return redirect()->to('admin/sliders')
            ->with('success', 'Slider deleted successfully!');
    }
}