<?php

namespace App\Controllers;

use App\Models\DrugsModel;

class Health extends BaseController
{

public function prescription()
{
    $drugModel = new DrugsModel();

    $search = $this->request->getGet('q');

    if ($search) {
        $drugModel->groupStart()
            ->like('drug_name', $search)
            ->orLike('company', $search)
            ->orLike('drug_type', $search)
            ->orLike('group_name', $search)
            ->groupEnd();
    }

    $data = [
        'drugs'   => $drugModel->paginate(20), // 20 items per page
        'pager'   => $drugModel->pager,
        'search'  => $search
    ];

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
