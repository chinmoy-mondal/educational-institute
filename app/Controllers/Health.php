<?php

namespace App\Controllers;

use App\Models\DrugsModel;

class Health extends BaseController
{
    // ---------------------------
    // DRUG LIST WITH PAGINATION
    // ---------------------------
    public function drugs()
    {
        $drugModel = new DrugsModel();

        $search = $this->request->getGet('q');

        if (!empty($search)) {
            $drugModel
                ->groupStart()
                ->like('drug_name', $search, 'after')
                ->orLike('group_name', $search, 'after')
                ->groupEnd()
                ->limit(10)
                ->find();
        }

        $data = [
            'drugs'  => $drugModel->paginate(20),     // 20 items per page
            'pager'  => $drugModel->pager,
            'search' => $search
        ];

        return view('health/prescription_new', $data);
    }

    // ---------------------------
    // OLD JSON-BASED PRESCRIPTION
    // ---------------------------
    public function prescription()
    {
        $drugModel = new DrugsModel();
        $data['drugs_json'] = json_encode($drugModel->findAll());

        return view('health/prescription', $data);
    }

    // ---------------------------
    // AJAX SEARCH API (not used in paginate version)
    // ---------------------------
    public function searchDrugs()
    {
        $keyword = $this->request->getGet('q');

        $model = new DrugsModel();

        $drugs = $model
            ->groupStart()
            ->like('drug_name', $keyword, 'after')
            ->orLike('group_name', $keyword, 'after')
            ->groupEnd()
            ->limit(10)
            ->find();

        return $this->response->setJSON($drugs);
    }
}
