<?php

namespace App\Hizb\Builder;

use Sparkhizb\Helpers\IdentityHelper;
use Sparkhizb\Helpers\UmmuHelper;
use Sparkhizb\Helpers\RequestHelper;
use Sparkhizb\UmmuGoodsEvaluation;

// use App\Models\Safety\HazardReportQueueMailModel;
// use App\Models\Safety\HazardReportNumberModel;

class GoodsevalBuilder
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->iescm = \Config\Database::connect('iescm');
        $this->request = \Config\Services::request();
        $this->reqH = new RequestHelper();
        $this->identity = new IdentityHelper();
        $this->umHelp = new UmmuHelper();
        $this->ummu = new UmmuGoodsEvaluation();

        // $this->model = new HazardReportQueueMailModel();
        // $this->mNum = new HazardReportNumberModel();
    }

    public function show($id = null)
    {
        $payload = [
            "limit" => 10,
            "offset" => 0,
            "sort" => "id",
            "order" => "desc",
            "search" => "",
            "selects" => "*"
        ];

        $params = [
            "id" => $id,
            "payload" => $payload,
            "token" => $this->reqH->myToken()
        ];

        $builder = $this->ummu->show($params);

        return $builder;
    }

    public function show_herpapi($id = null)
    {
        $payload = [
            "limit" => 10,
            "offset" => 0,
            "sort" => "id",
            "order" => "desc",
            "search" => "",
            "selects" => "*"
        ];

        $params = [
            "id" => $id,
            "payload" => $payload,
            "token" => $this->identity->login_token()
        ];

        $builder = $this->ummu->show($params);

        return $builder;
    }

    public function show_new($nik, $site)
    {
        $builder = $this->mNum
            ->where('nik', $nik)
            ->where('site', $site)
            ->where('number IS NULL')
            ->where('used_at IS NULL')
            ->where('YEAR(created_at)', date('Y'))
            ->where('MONTH(created_at)', date('m'))
            ->first();

        return $builder;
    }

    public function show_number_unused($nik, $site)
    {
        $builder = $this->mNum
            ->where('nik', $nik)
            ->where('site', $site)
            ->where('used_at IS NULL')
            ->where('YEAR(created_at)', date('Y'))
            ->where('MONTH(created_at)', date('m'))
            ->first();

        return $builder;
    }

    public function getLastRow()
    {
        $builder = $this->iescm->table($this->mNum->table)
            ->where('YEAR(created_at)', date('Y'))
            ->where('MONTH(created_at)', date('m'))
            ->get()
            ->getLastRow();

        return $builder;
    }

    public function update_new($id, $payload)
    {
        $builder = $this->mNum
            ->where('id', $id)
            ->set($payload)
            ->update();

        return $builder;
    }

    public function create_id($payload)
    {
        return $this->mNum->insert($payload);
    }

    public function insert_number($payload)
    {
        return $this->mNum->insert($payload);
    }

    public function used_number($number)
    {
        return $this->mNum
            ->where('number', $number)
            ->set('used_at', date('Y-m-d H:i:s'))
            ->update();
    }

    public function insert($payload)
    {
        $params = [
            "id" => null,
            "payload" => $payload,
            "token" => $this->umHelp->token()
        ];

        $builder = $this->ummu->insert($params);
        return $builder;
    }

    public function zoneCreate_insert($payload)
    {
        $params = [
            "payload" => $payload,
            "token" => $this->umHelp->token()
        ];

        $builder = $this->ummu->zoneCreate_insert($params);

        return $builder;
    }

    public function zoneCreate_show($id = null, $payload)
    {
        $params = [
            "id" => $id,
            "payload" => $payload,
            "token" => $this->reqH->myToken()
        ];

        $builder = $this->ummu->zoneCreate_show($params);

        return $builder;
    }

    public function zoneCreate_update($id, $payload)
    {
        $params = [
            "id" => $id,
            "payload" => $payload,
            "token" => $this->umHelp->token()
        ];

        $builder = $this->ummu->zoneCreate_update($params);

        return $builder;
    }

    

    /**
     * Process Zone*/
    public function zoneProcess_show($id = null, $payload)
    {
        $params = [
            "id" => $id,
            "payload" => $payload,
            "token" => $this->reqH->myToken()
        ];

        $builder = $this->ummu->zoneProcess_show($params);

        return $builder;
    }

    public function zoneProcess_update($id, $payload)
    {
        $params = [
            "id" => $id,
            "payload" => $payload,
            "token" => $this->umHelp->token()
        ];

        $builder = $this->ummu->zoneProcess_update($params);

        return $builder;
    }



    /**
     * Monitoring Zone*/
    public function zoneMonitoring_show($id = null, $payload)
    {
        $params = [
            "id" => $id,
            "payload" => $payload,
            "token" => $this->reqH->myToken()
        ];

        $builder = $this->ummu->zoneMonitoring_show($params);

        return $builder;
    }
}