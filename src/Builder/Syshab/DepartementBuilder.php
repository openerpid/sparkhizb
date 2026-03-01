<?php

namespace Sparkhizb\Builder\Syshab;

use Sparkhizb\Helpers\BuilderHelper;
use Sparkhizb\Helpers\UmmuHelper;

use Sparkhizb\Models\Syshab\DivisiModel;
use Sparkhizb\Models\Syshab\DepartemenModel;

class DepartementBuilder
{
    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->db = \Config\Database::connect();
        $this->bHelp = new BuilderHelper();
        $this->qHelp = new UmmuHelper();

        $this->mDivisi = new DivisiModel();
        $this->model = new DepartemenModel();
    }

    private function qbAlya()
    {
        $subquery = $this->db->table($this->model->table . ' a')
            ->select('
                a.*,
                b.NmDivisi
            ')
            ->join($this->mDivisi->table . ' b', 'b.KdDivisi = a.KdDivisi', 'left')
            ->where('a.DeleteBy IS NULL');

        return $this->db->newQuery()->fromSubquery($subquery, 't');
    }

    public function show($id = null)
    {
        if ($this->qHelp->is_jsonVar() == true) {
            $KdDivisi = $this->request->getJsonVar('KdDivisi');
        } else {
            $KdDivisi = $this->request->getVar('KdDivisi');
        }

        $allowedFields = $this->model->allowedFields;

        $builder = $this->qbAlya();

        if ($KdDivisi) {
            $builder->where('KdDivisi', $KdDivisi);
        }

        $params = [
            "builder" => $builder,
            "id" => $id,
            "search_params" => ["KdDepar", "NmDepar"],
            "company_id" => null
        ];

        $builder = $this->bHelp->conditions0($params);
        $allowedFields = array_merge($allowedFields, ["NmDivisi"]);
        $builder = $this->qHelp->orderBy($builder, $allowedFields);

        return $builder;
    }

    public function show_by_kode($kode = null)
    {
        $builder = $this->db->table($this->model->table)
            ->where('KdDepar', $kode)
            ->where('DeleteBy IS NULL');

        return $builder;
    }
}