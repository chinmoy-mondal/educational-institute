<?php

namespace App\Controllers;

use App\Models\DrugsModel;

class Health extends BaseController
{

    public function prescription()
    {
        $drugModel = new DrugsModel();

        // Get search keyword from GET parameter
        $keyword = $this->request->getGet('search');

        if ($keyword) {
            $drugs = $drugModel
                ->like('drug_name', $keyword)
                ->orLike('drug_type', $keyword)
                ->orLike('company', $keyword)
                ->orLike('group_name', $keyword)
                ->findAll();
        } else {
            $drugs = $drugModel->findAll();
        }

        $data['drugs'] = $drugs;
        $data['search'] = $keyword;

        return view('health/prescription_new', $data);
    }








    // public function prescription()
    // {
    //     $drugModel = new DrugsModel();
    //     $data['drugs_json'] = json_encode($drugModel->findAll());
    //     return view('health/prescription', $data);
    // }

    // public function searchDrugs()
    // {
    //     $keyword = $this->request->getGet('q');
    //     $model = new DrugsModel();
    //     $drugs = $model->like('drug_name', $keyword)
    //         ->orLike('drug_type', $keyword)
    //         ->orLike('group_name', $keyword)
    //         ->orLike('company', $keyword)
    //         ->findAll();
    //     return $this->response->setJSON($drugs);
    // }
}
