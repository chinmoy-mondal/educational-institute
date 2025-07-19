<?php

namespace App\Controllers;

use App\Models\StudentModel;

class Student extends BaseController
{
    public function index()
    {
        $model   = new StudentModel();
        $builder = $model->select('*');

        // ── filters via query-string ─────────────────────────────
        $name    = trim($this->request->getGet('name'));
        $roll    = trim($this->request->getGet('roll'));
        $class   = trim($this->request->getGet('class'));
        $section = trim($this->request->getGet('section'));

        if ($name)    $builder->like('student_name', $name);
        if ($roll)    $builder->where('roll', $roll);
        if ($class)   $builder->where('class', $class);
        if ($section) $builder->where('section', $section);

        // ── pagination (10 per page) ────────────────────────────
        $perPage   = 10;
        $students  = $builder->orderBy('class, section, roll')->paginate($perPage);
        $pager     = $model->pager;

        // ── distinct class / section lists for dropdowns ───────
        $classes   = $model->select('class')->distinct()->orderBy('class')->findAll();
        $sections  = $model->select('section')->distinct()->orderBy('section')->findAll();

        return view('public/students', compact('students','pager','classes','sections','name','roll','class','section'));
    }
}
