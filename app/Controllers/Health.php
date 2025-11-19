<?php

namespace App\Controllers;

use App\Models\DrugsModel;

class Health extends BaseController
{
    public function prescriptionForm()
    {
        $drugs = (new DrugsModel())->orderBy('drug_name', 'ASC')->findAll();

        return view('health/prescription', [
            'drugs' => $drugs
        ]);
    }

    public function savePrescription()
    {
        // TEMP — print submitted data (you can save later)
        echo "<pre>";
        print_r($this->request->getPost());
        echo "</pre>";
    }
}