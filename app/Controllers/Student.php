<?php namespace App\Controllers;

use App\Models\StudentModel;

class Student extends BaseController
{
    public function index()
    {
        return view('student_form');
    }

    public function save()
    {
        helper(['form', 'url']);

        $validation = \Config\Services::validation();

        $validation->setRules([
            'student_name' => 'required',
            'roll' => 'required',
            'class' => 'required',
            'esif' => 'required',
            'section' => 'required|in_list[General,BM]',
            'dob' => 'required|valid_date',
            'phone' => 'required',
            'birth_registration_pic' => 'uploaded[birth_registration_pic]|is_image[birth_registration_pic]',
            'father_id_pic' => 'uploaded[father_id_pic]|is_image[father_id_pic]',
            'mother_id_pic' => 'uploaded[mother_id_pic]|is_image[mother_id_pic]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $model = new StudentModel();

        $data = [
            'student_name' => $this->request->getPost('student_name'),
            'roll' => $this->request->getPost('roll'),
            'class' => $this->request->getPost('class'),
            'esif' => $this->request->getPost('esif'),
            'section' => $this->request->getPost('section'),
            'dob' => $this->request->getPost('dob'),
            'phone' => $this->request->getPost('phone'),
            'birth_registration_pic' => $this->uploadFile('birth_registration_pic'),
            'father_id_pic' => $this->uploadFile('father_id_pic'),
            'mother_id_pic' => $this->uploadFile('mother_id_pic'),
        ];

        $model->save($data);

        return redirect()->to('/student')->with('success', 'Student Info Saved!');
    }

    private function uploadFile($field)
    {
        $file = $this->request->getFile($field);
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/', $newName);
            return 'uploads/' . $newName;
        }
        return null;
    }
}
