<?php

namespace Sparkhizb\Builder;

use Sparkhizb\Helpers\UmmuHelper;
use Sparkhizb\Helpers\RequestHelper;
use Sparkhizb\UmmuHazardReport;
use App\Hizb\Models\Safety\HazardReportQueueMailModel;
use App\Hizb\Models\Safety\HazardReportNumberModel;

class HazardReportSparkBuilder
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->iescm = \Config\Database::connect('iescm');
        $this->request = \Config\Services::request();
        $this->reqH = new RequestHelper();
        $this->umHelp = new UmmuHelper();
        $this->ummu = new UmmuHazardReport();
        $this->model = new HazardReportQueueMailModel();
        $this->mNum = new HazardReportNumberModel();
    }

    public function show($id = null)
    {
        return $this->showFrom_openapi2($id);
    }

    public function showFrom_iescm($id = null)
    {
        // 
    }

    public function showFrom_openapi2($id = null)
    {
        $payload = $this->reqH->payloadStd();

        $params = [
            "id" => $id,
            "payload" => $payload,
            "token" => $this->reqH->myToken()
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
            ->get()
            ->getFirstRow();

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
            ->where('deleted_at IS NULL')
            ->get()
            ->getFirstRow();

        return $builder;
    }

    public function show_number_unused_by_accountid($account_id)
    {
        $builder = $this->mNum
            ->where('created_by', $account_id)
            ->where('used_at IS NULL')
            ->where('YEAR(created_at)', date('Y'))
            ->where('MONTH(created_at)', date('m'))
            ->where('deleted_at IS NULL')
            ->get()
            ->getFirstRow();

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

    // public function show_queue_mail()
    // {
    //     $builder = $this->model
    //         ->where('send_mail IS NULL')
    //         ->find();

    //     return $builder;
    // }

    // public function show_queue_mail_detail($id)
    // {
    //     $payload = [
    //         "limit" => 10,
    //         "offset" => 0,
    //         "sort" => "id",
    //         "order" => "desc",
    //         "search" => "",
    //         "selects" => "*"
    //     ];

    //     $params = [
    //         "id" => $id,
    //         "payload" => $payload,
    //         "token" => getenv('OPEN_INTEGRASI_TOKEN_SAFETY')
    //     ];

    //     $builder = $this->ummu->show($params);
    //     return $builder;
    // }

    // public function create_queue_mail($document_id)
    // {
    //     $builder = $this->model->insert(["document_id" => $document_id]);
    //     return $builder;
    // }

    // public function update_queue_mail($id, $body)
    // {
    //     $builder = $this->model->update($id, $body);
    //     return $builder;
    // }
}