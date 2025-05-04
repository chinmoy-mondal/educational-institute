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

        // Validation rules, including new 'student_pic'
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
            'student_pic' => 'uploaded[student_pic]|is_image[student_pic]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $model = new StudentModel();

        // Prepare data for saving
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
            'student_pic' => $this->uploadFile('student_pic'),
        ];

        $model->save($data);

        return redirect()->to('/student')->with('success', 'Student Info Saved!');
    }

    // Reusable file upload handler
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

    public function list()
    {
        $model = new StudentModel();
        $data['students'] = $model->findAll();
        return view('student_list', $data);
    }

    public function edit($id)
    {
        $model = new StudentModel();
        $student = $model->find($id);

        if (!$student) {
            return redirect()->to('/student/list')->with('error', 'Student not found');
        }

        return view('student_edit_form', ['student' => $student]);
    }

    public function update($id)
    {
        $model = new StudentModel();
        $student = $model->find($id);

        if (!$student) {
            return redirect()->to('/student/list')->with('error', 'Student not found');
        }

        $data = $this->request->getPost();

        // Handle file updates including 'student_pic'
        foreach (['birth_registration_pic', 'father_id_pic', 'mother_id_pic', 'student_pic'] as $field) {
            $file = $this->request->getFile($field);

            if ($file && $file->isValid() && !$file->hasMoved()) {
                // Delete old image
                if (!empty($student[$field]) && file_exists($student[$field])) {
                    unlink($student[$field]);
                }

                $newName = $file->getRandomName();
                $file->move('uploads/', $newName);
                $data[$field] = 'uploads/' . $newName;
            } else {
                unset($data[$field]); // Keep old one
            }
        }

        $model->update($id, $data);
        return redirect()->to('/student/list')->with('success', 'Student updated successfully.');
    }

    public function delete($id)
    {
        $model = new StudentModel();
        $student = $model->find($id);

        if (!$student) {
            return redirect()->to('/student/list')->with('error', 'Student not found');
        }

        // Delete all related images including student_pic
        foreach (['birth_registration_pic', 'father_id_pic', 'mother_id_pic', 'student_pic'] as $field) {
            if (!empty($student[$field]) && file_exists($student[$field])) {
                unlink($student[$field]);
            }
        }

        $model->delete($id);

        return redirect()->to('/student/list')->with('success', 'Student deleted successfully.');
    }
}
