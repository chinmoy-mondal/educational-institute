<?php

namespace App\Controllers;

use App\Models\DrugsModel;

class Health extends BaseController
{
    public function prescription()
    {
        $drugModel = new DrugsModel();

        $data['drugs'] = $drugModel->findAll();

        // return view('health/prescription', $data);
        echo "hello";
    }
}
