<?php

namespace Sparkhizb\Builder\Syshab;

use Sparkhizb\Helpers\BuilderHelper;
use Sparkhizb\Helpers\UmmuHelper;

use Sparkhizb\Models\Syshab\DivisiModel;

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
        $KdDivisi = $this->request->getJsonVar('KdDivisi');
        $allowedFields = [];
        $builder = $this->db->table($this->model->table)
            ->where('DeleteTime IS NULL');

        if ($KdDivisi) {
            $builder->where('KdDivisi', $KdDivisi);
        }

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

    public function show_by_kode($kode = null)
    {
        $builder = $this->db->table($this->model->table)
            ->where('KdDivisi', $kode)
            ->where('DeleteTime IS NULL');

        return $builder;
    }
}