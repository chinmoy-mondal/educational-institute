<?php

namespace App\Controllers;

class Register extends BaseController
{
    public function index()
    {
        return view('register');
    }

    public function submit()
    {
        // You can process the form data here
        $data = $this->request->getPost();

        // For now, just dump the data (in production, you'd save to DB)
        return view('register_success', ['data' => $data]);
    }
}