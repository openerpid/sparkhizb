<?php

namespace App\Hizb\Syshab\Builder;

use Sparkhizb\Helpers\BuilderHelper;
use Sparkhizb\Helpers\UmmuHelper;

use App\Hizb\Syshab\Models\SeksiModel;
use App\Hizb\Syshab\Models\DepartemenModel;

class SeksiBuilder
{
    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->db = \Config\Database::connect();
        $this->bHelp = new BuilderHelper();
        $this->qHelp = new UmmuHelper();

        $this->model = new SeksiModel();
        $this->mDepar = new DepartemenModel();
    }

    private function qbAlya()
    {
        $subquery = $this->db->table($this->model->table . ' a')
            ->select('
                a.*,
                b.NmDepar
            ')
            ->join($this->mDepar->table . ' b', 'b.KdDepar = a.KdDepar', 'left')
            ->where('a.DeleteBy IS NULL');

        return $this->db->newQuery()->fromSubquery($subquery, 't');
    }

    public function show($id = null)
    {
        if ($this->qHelp->is_jsonVar() == true) {
            $KdDepar = $this->request->getJsonVar('KdDepar');
        } else {
            $KdDepar = $this->request->getVar('KdDepar');
        }

        $allowedFields = $this->model->allowedFields;

        $builder = $this->qbAlya();

        if ($KdDepar) {
            $builder->where('KdDepar', $KdDepar);
        }

        $params = [
            "builder" => $builder,
            "id" => $id,
            "search_params" => ["NmSec"],
            "company_id" => null
        ];

        $builder = $this->bHelp->conditions0($params);
        $allowedFields = array_merge($allowedFields, ["NmSec"]);
        $builder = $this->qHelp->orderBy($builder, $allowedFields);

        return $builder;
    }

    public function show_by_kode($kode = null)
    {
        $builder = $this->db->table($this->model->table)
            ->where('KdSec', $kode)
            ->where('DeleteTime IS NULL');

        return $builder;
    }
}