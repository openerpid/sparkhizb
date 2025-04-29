<?php

namespace App\Hizb\Syshab\Builder;

use Sparkhizb\Helpers\BuilderHelper;
use Sparkhizb\Helpers\UmmuHelper;

use App\Hizb\Syshab\Models\DivisiModel;

class DivisiBuilder
{
    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->db = \Config\Database::connect();
        $this->bHelp = new BuilderHelper();
        $this->qHelp = new UmmuHelper();

        $this->model = new DivisiModel();
    }

    public function show($id = null)
    {
        $allowedFields = [];
        $builder = $this->db->table($this->model->table)
            ->where('DeleteTime IS NULL');

        $params = [
            "builder" => $builder,
            "id" => $id,
            "search_params" => ["NmDivisi"],
            "company_id" => null
        ];

        $builder = $this->bHelp->conditions0($params);
        // $allowedFields = array_merge($allowedFields,[]);
        $builder = $this->qHelp->orderBy($builder, $allowedFields);

        return $builder;
    }
}