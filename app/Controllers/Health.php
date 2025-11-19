<?php

namespace App\Controllers;

use App\Models\DrugsModel;

class Health extends BaseController
{
    public function prescription()
    {
        $drugModel = new DrugsModel();

        $data['title'] = 'Prescription';
        $data['activeSection'] = 'health';

        // Navbar items so AdminLTE layout doesn't break
        $data['navbarItems'] = [
            ['label' => 'Prescription', 'url' => base_url('prescription')],
        ];

        // Fetch the drug list
        $data['drugs'] = $drugModel->findAll();

        return view('health/prescription', $data);
    }
}
