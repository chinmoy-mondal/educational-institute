<?php

namespace App\Controllers;

use App\Models\DrugsModel;

class Health extends BaseController
{
    public function prescription()
    {
        $drugModel = new DrugsModel();

        $data['drugs'] = $drugModel->findAll();

        return view('health/prescription', $data);
    }

    public function searchDrugs()
    {
        $keyword = $this->request->getGet('q');

        $model = new DrugsModel();
        $drugs = $model->like('drug_name', $keyword)->findAll(20); // return only 20

        return $this->response->setJSON($drugs);
    }
}
