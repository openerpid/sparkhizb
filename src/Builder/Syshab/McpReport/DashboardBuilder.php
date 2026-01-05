<?php

namespace Sparkhizb\Builder\Syshab\McpReport;

use Sparkhizb\Helpers\UmmuHelper;
use Sparkhizb\Helpers\RequestHelper;
use Sparkhizb\UmmuHazardReport;
// use App\Hizb\Models\Safety\HazardReportQueueMailModel;
// use App\Hizb\Models\Safety\HazardReportNumberModel;
use Sparkhizb\Models\DashboardSiteProjectListModel;

class DashboardBuilder
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        // $this->iescm = \Config\Database::connect('iescm');
        $this->mcp = \Config\Database::connect('mcp');
        $this->request = \Config\Services::request();
        $this->reqH = new RequestHelper();
        $this->umHelp = new UmmuHelper();
        // $this->ummu = new UmmuHazardReport();
        // $this->model = new HazardReportQueueMailModel();
        // $this->mNum = new HazardReportNumberModel();
        $this->mSiteDash = new DashboardSiteProjectListModel();
    }

    public function show_hauling_daily($tgl, $tgl2, $site)
    {
        // SELECT * FROM ( 
        //     SELECT 'LOADER' AS tipe, TEMP1.unit_code,TEMP1.ProdDate,TEMP1.day_rit,TEMP1.night_rit,TEMP1.day,TEMP1.night,
        //         ISNULL (( SELECT SUM(qty_out)
        //             FROM      V_FUEL_CONSUMPTION_FOR_MCC_CL
        //             WHERE  region_code = '{$site}' AND unit_code = TEMP1.unit_code AND CONVERT(CHAR(8),tgl,112)  = CONVERT(CHAR(8),TEMP1.ProdDate,112) ),0) AS fuel,
        //         (ISNULL((SELECT SUM(MCC_TR_WORKHOUR.time_dec)
        //             FROM    MCC_TR_WORKHOUR   
        //             WHERE   MCC_TR_WORKHOUR.region_code = '{$site}' AND MCC_TR_WORKHOUR.proddate = TEMP1.ProdDate AND
        //                     MCC_TR_WORKHOUR.activity_code = '02'  AND MCC_TR_WORKHOUR.equipment_code = TEMP1.unit_code ), 0) ) AS stb ,
        //         (ISNULL((SELECT SUM(MCC_TR_WORKHOUR.time_dec)
        //             FROM    MCC_TR_WORKHOUR   
        //             WHERE   MCC_TR_WORKHOUR.region_code = '{$site}' AND MCC_TR_WORKHOUR.proddate = TEMP1.ProdDate AND
        //                         MCC_TR_WORKHOUR.activity_code = '03'  AND MCC_TR_WORKHOUR.equipment_code = TEMP1.unit_code ), 0) ) AS bd, 
        //         (ISNULL((SELECT SUM(MCC_TR_WORKHOUR.time_dec)
        //             FROM    MCC_TR_WORKHOUR   
        //             WHERE   MCC_TR_WORKHOUR.region_code = '{$site}' AND MCC_TR_WORKHOUR.proddate = TEMP1.ProdDate AND
        //                         MCC_TR_WORKHOUR.activity_code = '04'  AND MCC_TR_WORKHOUR.equipment_code = TEMP1.unit_code ), 0) ) AS idle,
        //             (CONVERT(INT,'{$tgl2}') - CONVERT(INT,'{$tgl}') + 1 ) * 24 AS mohh
        //     FROM (SELECT V_MCC_TR_HPRODUCTIONB_CL.unit_loader  AS unit_code,V_MCC_TR_HPRODUCTIONB_CL.ProdDate,   
        //        SUM(CASE V_MCC_TR_HPRODUCTIONB_CL.tshift WHEN 'D' THEN V_MCC_TR_HPRODUCTIONB_CL.QtyRit ELSE 0 END) AS day_rit,
        //        SUM(CASE V_MCC_TR_HPRODUCTIONB_CL.tshift WHEN 'N' THEN V_MCC_TR_HPRODUCTIONB_CL.QtyRit ELSE 0 END) AS night_rit,
        //        SUM(CASE V_MCC_TR_HPRODUCTIONB_CL.tshift WHEN 'D' THEN V_MCC_TR_HPRODUCTIONB_CL.Weight ELSE 0 END) AS day,
        //        SUM(CASE V_MCC_TR_HPRODUCTIONB_CL.tshift WHEN 'N' THEN V_MCC_TR_HPRODUCTIONB_CL.Weight ELSE 0 END) AS night
        // FROM    V_MCC_TR_HPRODUCTIONB_CL
        // WHERE   V_MCC_TR_HPRODUCTIONB_CL.region_code ='{$site}' AND 
        //         CONVERT(CHAR(8) , V_MCC_TR_HPRODUCTIONB_CL.proddate, 112) BETWEEN '{$tgl}' AND '{$tgl2}'   
        // GROUP BY V_MCC_TR_HPRODUCTIONB_CL.unit_loader,V_MCC_TR_HPRODUCTIONB_CL.ProdDate) AS TEMP1

        // UNION ALL

        $q = "
            SELECT 'HAULER' AS tipe, TEMP1.unit_code,TEMP1.ProdDate,TEMP1.day_rit,TEMP1.night_rit,TEMP1.day,TEMP1.night,
                ISNULL (( SELECT SUM(qty_out)
                    FROM      V_FUEL_CONSUMPTION_FOR_MCC_CL
                    WHERE  region_code = '{$site}' AND unit_code = TEMP1.unit_code AND CONVERT(CHAR(8),tgl,112)  = CONVERT(CHAR(8),TEMP1.ProdDate,112) ),0) AS fuel,
                (ISNULL((SELECT SUM(MCC_TR_WORKHOUR.time_dec)
                    FROM    MCC_TR_WORKHOUR   
                    WHERE   MCC_TR_WORKHOUR.region_code = '{$site}' AND MCC_TR_WORKHOUR.proddate = TEMP1.ProdDate AND
                            MCC_TR_WORKHOUR.activity_code = '02'  AND MCC_TR_WORKHOUR.equipment_code = TEMP1.unit_code ), 0) ) AS stb ,
                (ISNULL((SELECT SUM(MCC_TR_WORKHOUR.time_dec)
                    FROM    MCC_TR_WORKHOUR   
                    WHERE   MCC_TR_WORKHOUR.region_code = '{$site}' AND MCC_TR_WORKHOUR.proddate = TEMP1.ProdDate AND
                                MCC_TR_WORKHOUR.activity_code = '03'  AND MCC_TR_WORKHOUR.equipment_code = TEMP1.unit_code ), 0) ) AS bd, 
                (ISNULL((SELECT SUM(MCC_TR_WORKHOUR.time_dec)
                    FROM    MCC_TR_WORKHOUR   
                    WHERE   MCC_TR_WORKHOUR.region_code = '{$site}' AND MCC_TR_WORKHOUR.proddate = TEMP1.ProdDate AND
                                MCC_TR_WORKHOUR.activity_code = '04'  AND MCC_TR_WORKHOUR.equipment_code = TEMP1.unit_code ), 0) ) AS idle,
                    (CONVERT(INT,'{$tgl2}') - CONVERT(INT,'{$tgl}') + 1 ) * 24 AS mohh
            FROM ( SELECT 
                V_MCC_TR_HPRODUCTIONB_CL.unit_houler  AS unit_code,
                V_MCC_TR_HPRODUCTIONB_CL.ProdDate,   
               SUM(CASE V_MCC_TR_HPRODUCTIONB_CL.tshift WHEN 'D' THEN V_MCC_TR_HPRODUCTIONB_CL.qtyRit ELSE 0 END) AS day_rit,
               SUM(CASE V_MCC_TR_HPRODUCTIONB_CL.tshift WHEN 'N' THEN V_MCC_TR_HPRODUCTIONB_CL.qtyRit ELSE 0 END) AS night_rit,
               SUM(CASE V_MCC_TR_HPRODUCTIONB_CL.tshift WHEN 'D' THEN V_MCC_TR_HPRODUCTIONB_CL.Weight ELSE 0 END) AS day,
               SUM(CASE V_MCC_TR_HPRODUCTIONB_CL.tshift WHEN 'N' THEN V_MCC_TR_HPRODUCTIONB_CL.Weight ELSE 0 END) AS night
            FROM V_MCC_TR_HPRODUCTIONB_CL WHERE V_MCC_TR_HPRODUCTIONB_CL.region_code ='{$site}' AND CONVERT(CHAR(8) , V_MCC_TR_HPRODUCTIONB_CL.proddate, 112) BETWEEN '{$tgl}' AND '{$tgl2}' 
            GROUP BY V_MCC_TR_HPRODUCTIONB_CL.unit_houler,V_MCC_TR_HPRODUCTIONB_CL.ProdDate ) AS TEMP1;
            -- ) AS TEMP2 
            -- ORDER BY TEMP2.tipe,TEMP2.unit_code,TEMP2.ProdDate ASC
        ";

        $builder = $this->mcp->query($q);
        $builder->getResultArray();

        return $builder;
    }

    public function TEMP1($tgl, $tgl2, $site)
    {
        $query = "
            SELECT 
                V_MCC_TR_HPRODUCTIONB_CL.unit_houler  AS unit_code,
                V_MCC_TR_HPRODUCTIONB_CL.ProdDate,   
               SUM(CASE V_MCC_TR_HPRODUCTIONB_CL.tshift WHEN 'D' THEN V_MCC_TR_HPRODUCTIONB_CL.qtyRit ELSE 0 END) AS day_rit,
               SUM(CASE V_MCC_TR_HPRODUCTIONB_CL.tshift WHEN 'N' THEN V_MCC_TR_HPRODUCTIONB_CL.qtyRit ELSE 0 END) AS night_rit,
               SUM(CASE V_MCC_TR_HPRODUCTIONB_CL.tshift WHEN 'D' THEN V_MCC_TR_HPRODUCTIONB_CL.Weight ELSE 0 END) AS day,
               SUM(CASE V_MCC_TR_HPRODUCTIONB_CL.tshift WHEN 'N' THEN V_MCC_TR_HPRODUCTIONB_CL.Weight ELSE 0 END) AS night
            FROM V_MCC_TR_HPRODUCTIONB_CL WHERE V_MCC_TR_HPRODUCTIONB_CL.region_code ='{$site}' AND CONVERT(CHAR(8) , V_MCC_TR_HPRODUCTIONB_CL.proddate, 112) BETWEEN '{$tgl}' AND '{$tgl2}' 
            GROUP BY V_MCC_TR_HPRODUCTIONB_CL.unit_houler,V_MCC_TR_HPRODUCTIONB_CL.ProdDate
        ";

        $builder = $this->mcp->query($query);
        $builder->getResultArray();

        return $builder;
    }

    public function show_V_MCC_TR_HPRODUCTIONB_CL($tgl, $site)
    {
        // $builder = $this->mcp->table('V_MCC_TR_HPRODUCTIONB_CL')
        // // ->select($select)
        // ->where('ProdDate', $tgl)
        // ->where('region_code', $site);

        $query = "SELECT * FROM V_MCC_TR_HPRODUCTIONB_CL
            WHERE ProdDate = '{$tgl}'
            AND region_code = '{$site}'
        ";

        $builder = $this->mcp->query($query);
        $builder->getResultArray();

        return $builder;
    }

    public function show_TR_PRODUCTIONB($select, $site, $tgl, $kode)
    {
        $builder = $this->mcp->table('MCC_TR_HPRODUCTIONB')
        ->select($select)
        ->where('ProdDate', $tgl)
        ->where('kode', $kode);

        if (is_array($site)) {
            $builder->whereIn('region_code', $site);
        }else{
            $builder->where('region_code', $site);
        }
        
        // $query = "SELECT *
        //     FROM MCPHILL.dbo.MCC_TR_HPRODUCTIONB
        //     WHERE region_code = '{$site}'
        //     AND kode = '{$kode}'
        //     AND CONVERT(CHAR(8), ProdDate, 112) = '{$tgl}'
        // ";

        // $builder = $this->mcp->query($query);
        // $builder->getResultArray();

        return $builder;
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