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
            'class' => 'required|in_list[6,7,8,9,10]',
            'esif' => 'required',
            'section' => 'permit_empty|in_list[General - Science,General - Arts,Vocational - Food Processing and Preservation,Vocational - IT Support and IoT Basics]',
            'father_name' => 'required|string|max_length[255]',
            'mother_name' => 'required|string|max_length[255]',
            'dob' => 'required|valid_date',
            'gender' => 'required|in_list[Male,Female,Other]',
            'phone' => 'required',
            'birth_registration_number' => 'required',
            'father_nid_number' => 'required',
            'mother_nid_number' => 'required',
            'student_pic' => 'uploaded[student_pic]|is_image[student_pic]|max_size[student_pic,100]|max_dims[student_pic,300,300]',
        ]);


        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $model = new StudentModel();

        $student_pic = $this->uploadFile('student_pic');

        $data = [
            'student_name' => $this->request->getPost('student_name'),
            'roll' => $this->request->getPost('roll'),
            'class' => $this->request->getPost('class'),
            'esif' => $this->request->getPost('esif'),
            'father_name' => $this->request->getPost('father_name'),
            'mother_name' => $this->request->getPost('mother_name'),
            'section' => $this->request->getPost('section'),
            'dob' => $this->request->getPost('dob'),
            'gender' => $this->request->getPost('gender'), 
            'phone' => $this->request->getPost('phone'),
            'birth_registration_number' => $this->request->getPost('birth_registration_number'),
            'father_nid_number' => $this->request->getPost('father_nid_number'),
            'mother_nid_number' => $this->request->getPost('mother_nid_number'),
            'student_pic' => $student_pic,
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
        $data['gender'] = $this->request->getPost('gender'); 
        
        // Handle student_pic update
        $file = $this->request->getFile('student_pic');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            if (!empty($student['student_pic']) && file_exists($student['student_pic'])) {
                unlink($student['student_pic']);
            }

            $newName = $file->getRandomName();
            $file->move('uploads/', $newName);
            $data['student_pic'] = 'uploads/' . $newName;
        } else {
            unset($data['student_pic']);
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

        if (!empty($student['student_pic']) && file_exists($student['student_pic'])) {
            unlink($student['student_pic']);
        }

        $model->delete($id);

        return redirect()->to('/student/list')->with('success', 'Student deleted successfully.');
    }
}
