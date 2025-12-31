<?php

namespace Sparkhizb\Builder;

use Sparkhizb\Helpers\UmmuHelper;
use Sparkhizb\Helpers\RequestHelper;
use Sparkhizb\UmmuHazardReport;
use App\Hizb\Models\Safety\HazardReportQueueMailModel;
use App\Hizb\Models\Safety\HazardReportNumberModel;
use Sparkhizb\Models\DashboardSiteProjectListModel;

class HazardReportSparkBuilder
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->iescm = \Config\Database::connect('iescm');
        $this->mcp = \Config\Database::connect('mcp');
        $this->request = \Config\Services::request();
        $this->reqH = new RequestHelper();
        $this->umHelp = new UmmuHelper();
        $this->ummu = new UmmuHazardReport();
        $this->model = new HazardReportQueueMailModel();
        $this->mNum = new HazardReportNumberModel();
        $this->mSiteDash = new DashboardSiteProjectListModel();
    }

    public function show_dashSite()
    {
        // 
    }

    public function show_plan_ob()
    {
        "SELECT 
            RTRIM(LTRIM(CAST(CONVERT(CHAR(10),MCC_MS_TARGETB.tgl, 103) AS CHAR))) AS tanggal,
            MCC_MS_TARGETB.targetDay,
            IsNull((SELECT SUM(weight) FROM  MCC_TR_HPRODUCTIONB WHERE MCC_TR_HPRODUCTIONB.kode = 'OB' AND MCC_TR_HPRODUCTIONB.region_code = @argproject AND CONVERT(CHAR(8), MCC_TR_HPRODUCTIONB.ProdDate, 112)  = @tgl1),0) AS actual,
            IsNull((SELECT  SUM(targetday) FROM  MCC_MS_TARGETB a WHERE a.material = 'OB' AND a.region_code =@argproject AND CONVERT(CHAR(8), a.tgl, 112) BETWEEN @tgl2 AND @tgl1 ),0) AS daily_cumm_plan,
            IsNull((SELECT  SUM(weight) FROM  MCC_TR_HPRODUCTIONB WHERE MCC_TR_HPRODUCTIONB.kode = 'OB' AND MCC_TR_HPRODUCTIONB.region_code =@argproject AND CONVERT(CHAR(8),
            MCC_TR_HPRODUCTIONB.ProdDate, 112) BETWEEN @tgl2 AND @tgl1 ),0) AS actual_cumm_plan
        FROM MCC_MS_TARGETB
        WHERE 
            a.material = 'OB' 
            AND a.region_code = @argproject 
            AND CONVERT(CHAR(8),MCC_MS_TARGETB.tgl, 112) = @ tgl1";

        $builder = $this->mcp->query($sp);
        $builder->getResultArray();
        $builder = $builder->resultArray;

        $bcm_tot_arr = [];
        foreach ($builder as $key => $value) {
            $bcm_tot_arr[] = $value['bcm_tot'];
        }

        $tot_all_bcm = array_sum($bcm_tot_arr);

        return $this->respond($tot_all_bcm, 200);
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
        $release = $this->request->getJsonVar("release");
        $nomor_dokumen = $this->request->getJsonVar("nomor_dokumen");
        $nik = $this->request->getJsonVar("nik");

        $payload = $this->reqH->payloadStd();
        $payload["release"] = $release;
        $payload["nomor_dokumen"] = $nomor_dokumen;

        if ($nik) {
            $payload["nika_in"] = $nik;
        }

        // if ($nik) {
        //     $payload["anywhere"] = [
        //         [
        //             "anywhere" => true,
        //             "column" => "nikaryawan",
        //             "copr" => "IN",
        //             "value" => $nik
        //         ]
        //     ];
        // }

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