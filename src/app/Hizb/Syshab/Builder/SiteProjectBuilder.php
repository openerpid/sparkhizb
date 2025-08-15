<?php

namespace App\Hizb\Syshab\Builder;

use Sparkhizb\Helpers\BuilderHelper;
use Sparkhizb\Helpers\UmmuHelper;
use Sparkhizb\UmmuSiteProject;

use App\Hizb\Syshab\Models\SiteProjectModel;

class SiteProjectBuilder
{
    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->db = \Config\Database::connect();
        $this->bHelp = new BuilderHelper();
        $this->qHelp = new UmmuHelper();
        $this->ummu = new UmmuSiteProject();
        $this->model = new SiteProjectModel();
    }

    private function qbAlya()
    {
        $table = $this->model->table;
        $allowedFields = $this->model->allowedFields;

        $subquery = $this->db->table($table)
            // ->select("*,region_code as id,region_name as text")
            ->where('tActive', 1);

        return $this->db->newQuery()->fromSubquery($subquery, 't');
    }

    public function show($id = null)
    {
        $allowedFields = $this->model->allowedFields;
        $kode = $this->request->getJsonVar("kode");

        $builder = $this->qbAlya();
        if ($kode) {
            $builder->where("region_code", $kode);
        }

        $params = [
            "builder" => $builder,
            "id" => $id,
            "search_params" => ["region_code", "region_name"],
            "company_id" => null
        ];

        $builder = $this->bHelp->conditions0($params);
        $builder = $this->qHelp->orderBy($builder, $allowedFields);

        return $builder;
    }

    public function update($id, $payload)
    {
        $builder = $this->db->table('ms_jobsite')
            ->where('region_code', $id)
            ->update($payload);

        return $builder;
    }

    public function usp_0202_SHB_0004($user)
    {
        $builder = $this->db->query('EXEC usp_0202_SHB_0004 ' . $user);

        return $builder;
    }

    public function show_by_kode($kode)
    {
        // $builder = 
    }

    public function show_from_openintegrasi($params)
    {
        $id = $params['id'];
        $payload = $params['payload'];

        $params = [
            "id" => $id,
            "payload" => $payload,
            "token" => getenv('OPEN_INTEGRASI_TOKEN')
        ];

        $builder = $this->ummu->show($params);
        return $builder;
    }

    public function get_name($kode)
    {
        $table = $this->model->table;

        $builder = $this->db->table($table)
            ->select("region_name as name")
            ->where("region_code", $kode)
            ->where("tActive", 1);

        return $builder;
    }
}