<?php

namespace App\Controllers;

use App\Models\DrugsModel;

class Health extends BaseController
{
    public function prescription()
    {
        $drugModel = new DrugsModel();
        $data['drugs_json'] = json_encode($drugModel->findAll());
        return view('health/prescription', $data);
    }

    public function searchDrugs()
    {
        $keyword = $this->request->getGet('q');
        $model = new DrugsModel();
        $drugs = $model->like('drug_name', $keyword)
            ->orLike('drug_type', $keyword)
            ->orLike('group_name', $keyword)
            ->orLike('company', $keyword)
            ->findAll(20);
        return $this->response->setJSON($drugs);
    }

    public function save()
    {
        $data = $this->request->getJSON(true);

        $model = new DrugsModel();
        $model->insert($data);

        return $this->response->setJSON(["status" => "success"]);
    }
}
