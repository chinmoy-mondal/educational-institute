<?php

namespace App\Controllers;

use App\Models\DrugsModel;

class Health extends BaseController
{

    public function prescription()
    {
        $drugModel = new DrugsModel();

        // Get search text (if typed)
        $search = $this->request->getGet('q');

        if ($search) {
            // Search by drug name OR type OR company OR group
            $drugModel
                ->groupStart()
                ->like('drug_name', $search)
                ->orLike('drug_type', $search)
                ->orLike('company', $search)
                ->orLike('group_name', $search)
                ->groupEnd();
        }

        $data['drugs'] = $drugModel->findAll();
        $data['search'] = $search;

        return view('health/prescription_table', $data);
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
