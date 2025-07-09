<?php

namespace App\Controllers;

use App\Models\SubjectModel;
use App\Models\StudentModel;

class Home extends BaseController
{
	public function index()
	{
		return view('public/home');
	}

	public function welcome()
	{
		return view('public/welcome');
	}
	public function history()
	{
		return view('public/history');
	}

	public function mission()
	{
		return view('public/mission');
	}

	public function staff()
	{
		return view('public/staff');
	}
	public function subjects()
	{
		$model = new SubjectModel();  // ✅ Correct instantiation

		$subjects = $model->findAll();
		return view('public/subject', ['subjects' => $subjects]);
	}
public function student()
    {
        $studentModel = new StudentModel();

        // Get search/filter parameters
        $q        = $this->request->getGet('q');
        $class    = $this->request->getGet('class');
        $section  = $this->request->getGet('section');

        // Start query
        $builder = $studentModel;

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

        // Get students with pagination, sorted by class and roll
        $students = $builder->orderBy('class', 'ASC')
                            ->orderBy('roll', 'ASC')
                            ->paginate(10, 'default');

        // Get all unique sections (for section dropdown)
        $sections = $studentModel->select('section')
                                 ->distinct()
                                 ->where('section IS NOT NULL')
                                 ->where('section !=', '')
                                 ->orderBy('section', 'ASC')
                                 ->findAll();

        return view('public/student_portal', [
            'students' => $students,
            'pager'    => $studentModel->pager,
            'q'        => $q,
            'class'    => $class,
            'section'  => $section,
            'sections' => $sections
        ]);
    }
}
