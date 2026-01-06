<?php

namespace Sparkhizb\Controllers\Syshab\McpReport;;

use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\Files\File;
use CodeIgniter\HTTP\Files\UploadedFile;
use App\Builder\Approval\ApprovalBuilder;
use Dorbitt\GviewsHelper;
use App\Helpers\GlobalHelper;
// use Dorbitt\Models\Herp\SiteProjectModel;
use Dorbitt\Builder\Iescm\SiteProjectHerpBuilder;
use Sparkhizb\Models\DashboardSiteProjectListModel;
use Sparkhizb\Builder\Syshab\McpReport\DashboardBuilder;
use Sparkhizb\Models\Syshab\McpReport\VmcctrhproductionbclModel;

class DashboardController extends ResourceController
{
    public $db;
    public $mcp;
    public $gViews;
    public $gHelp;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->mcp = \Config\Database::connect('mcp');
        $this->request = \Config\Services::request();
        $this->gViews = new GviewsHelper();
        $this->gHelp = new GlobalHelper();
        $this->mSiteDash = new DashboardSiteProjectListModel();
        // $this->sitepMod = new SiteProjectModel();
        // $this->qbSite = new SiteProjectHerpBuilder();
        $this->qBuilder = new DashboardBuilder();
    }

    public function index()
    {
        // $login_module = session()->get('login_module');
        // $data = [
        //     'navlink' => 'mcp_dashboard',
        //     'breadcrumb' => [
        //         [
        //             "name" => "Admin",
        //             "page" => "#",
        //             "active" => ""
        //         ],
        //         [
        //             "name" => "Dashboard",
        //             "page" => "#",
        //             "active" => "active"
        //         ]
        //     ]
        // ];

        // $page = 'pages/mcp_report/dashboard/index';

        // return view($page, $data);
    }

    public function show_siteProject()
    {
        $query = "SELECT * FROM ms_jobsite  WHERE tActive = 1 ";

        $builder = $this->mcp->query($query);
        $builder->getResultArray();
        $builder = $builder->resultArray;
        // $response = $this->qbSite->get();
        return $this->respond($builder, 200);
    }

    private function show_region_code()
    {
        $kdSite_arr = [];

        /*========
        from herp db*/
        // $query = "SELECT region_code FROM ms_jobsite  WHERE tActive = 1 ";

        // $builder = $this->mcp->query($query);
        // $builder->getResultArray();
        // $builder = $builder->resultArray;
        
        // foreach ($builder as $key => $value) {
        //     $kdSite_arr[] = $value['region_code'];
        // }


        /*========
        from iescm db*/
        $siteList = $this->mSiteDash
        ->select('kode')
        ->findAll();

        foreach ($siteList as $key => $value) {
            $kdSite_arr[] = $value['kode'];
        }

        return $kdSite_arr;
    }

    public function show_summary_ob()
    {
        // uSP_0405_SHB_0080 '20251202', 'SSA'
        $tgl = $this->request->getVar('tgl');
        // $site = $this->request->getVar('site');

        $query_siteProject = "SELECT region_code FROM ms_jobsite WHERE tActive = 1 ";

        $siteProject = $this->mcp->query($query_siteProject);
        $siteProject->getResultArray();
        $siteProject = $siteProject->resultArray;

        $kdSite = [];
        foreach ($siteProject as $key => $value) {
            $kdSite[] = $value['region_code'];
        }

        $kdSiteIm = implode(',', $kdSite);

        $all_summary_arr = [];

        $sp = "uSP_0405_SHB_0080 " . $tgl . ", '" . $kdSiteIm . "'";

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

    public function show_plan_ob_daily()
    {
        $tgl = $this->request->getVar('tgl');
        $site = $this->request->getVar('site');
        // $site = implode("','", $this->show_region_code());
        // $site = "SSA";
        $site_project = $this->show_region_code();

        /*exec dbo.uSP_0405_SHB_0046B N''{$tgl}'',N'SSA' --FUEL
        exec dbo.uSP_0405_SHB_0046C N''{$tgl}'',N''{$tgl}'',N'SSA' --daily
        exec dbo.uSP_0405_SHB_0046D 2025,12,N''{$tgl}'',N''{$tgl}'',N'20250101',N'SSA' --monthly dan yearly
        exec dbo.uSP_0405_SHB_0046A N''{$tgl}'',N'SSA'*/

        // $sp = "uSP_0405_SHB_0046C '{$tgl}', '{$tgl}', '{$site}'";

        /*$a = "SELECT SUM(weight) as actual FROM  MCC_TR_HPRODUCTIONB WHERE MCC_TR_HPRODUCTIONB.kode = 'OB' AND MCC_TR_HPRODUCTIONB.region_code =  ('{$site}') AND CONVERT(CHAR(8), MCC_TR_HPRODUCTIONB.ProdDate, 112)  = '{$tgl}'";*/

        /*SELECT  RTRIM(LTRIM(CAST(CONVERT(CHAR(10), MCC_MS_TARGETB.tgl, 103) AS CHAR))) AS tanggal,
            MCC_MS_TARGETB.targetDay,
            IsNull((SELECT  SUM(weight)
            FROM  MCC_TR_HPRODUCTIONB
            WHERE MCC_TR_HPRODUCTIONB.kode = 'OB' AND MCC_TR_HPRODUCTIONB.region_code =@argproject AND
            CONVERT(CHAR(8), MCC_TR_HPRODUCTIONB.ProdDate, 112)  = @tgl1),0) AS actual,
            
            IsNull((SELECT  SUM(targetday)
            FROM  MCC_MS_TARGETB a
            WHERE a.material = 'OB' AND a.region_code =@argproject AND
            CONVERT(CHAR(8), a.tgl, 112) BETWEEN @tgl2 AND @tgl1 ),0) AS daily_cumm_plan,
            
            IsNull((SELECT  SUM(weight)
            FROM  MCC_TR_HPRODUCTIONB
            WHERE MCC_TR_HPRODUCTIONB.kode = 'OB' AND MCC_TR_HPRODUCTIONB.region_code =@argproject AND
            CONVERT(CHAR(8), MCC_TR_HPRODUCTIONB.ProdDate, 112) BETWEEN @tgl2 AND @tgl1 ),0) AS actual_cumm_plan
            
        FROM    MCC_MS_TARGETB
        WHERE   MCC_MS_TARGETB.material = 'OB' AND MCC_MS_TARGETB.region_code =@argproject AND CONVERT(CHAR(8), MCC_MS_TARGETB.tgl, 112)= @tgl1*/
        
        // $sp = "
        //     SELECT RTRIM(LTRIM(CAST(CONVERT(CHAR(10),MCC_MS_TARGETB.tgl, 103) AS CHAR))) AS tanggal,
        //         MCC_MS_TARGETB.targetDay,
        //         IsNull((SELECT SUM(weight) FROM  MCC_TR_HPRODUCTIONB WHERE MCC_TR_HPRODUCTIONB.kode = 'OB' AND MCC_TR_HPRODUCTIONB.region_code IN ('{$site}') AND CONVERT(CHAR(8), MCC_TR_HPRODUCTIONB.ProdDate, 112)  = '{$tgl}'),0) AS actual,
        //         IsNull((SELECT  SUM(targetday) FROM  MCC_MS_TARGETB a WHERE a.material = 'OB' AND a.region_code IN ('{$site}') AND CONVERT(CHAR(8), a.tgl, 112) BETWEEN '{$tgl}' AND '{$tgl}' ),0) AS daily_cumm_plan,
        //         IsNull((SELECT  SUM(weight) FROM  MCC_TR_HPRODUCTIONB WHERE MCC_TR_HPRODUCTIONB.kode = 'OB' AND MCC_TR_HPRODUCTIONB.region_code IN ('{$site}') AND CONVERT(CHAR(8),
        //         MCC_TR_HPRODUCTIONB.ProdDate, 112) = '{$tgl}' ),0) AS actual_cumm_plan

        //     FROM MCC_MS_TARGETB
        //     WHERE MCC_MS_TARGETB.material = 'OB' 
        //         AND MCC_MS_TARGETB.region_code IN  ('{$site}') 
        //         AND CONVERT(CHAR(8),MCC_MS_TARGETB.tgl, 112) = '{$tgl}'
        // ";

        // $builder = $this->mcp->query($sp);
        // $builder->getResultArray();
        // $builder = $builder->resultArray;

        // // $bcm_tot_arr = [];

        $rows = [];
        $targetDay_arr = [];
        $actual_arr = [];

        if ($site) {
            $sitex = $site;
            $sp = "uSP_0405_SHB_0046C '{$tgl}', '{$tgl}', '{$site}'";
            $builder = $this->mcp->query($sp);
            $builder->getResultArray();
            $result = $builder->resultArray;
            foreach ($result as $key => $value) {
                foreach ($value as $key2 => $value2) {
                    $value['region_code'] = $site;
                }

                $rows[] = $value;
            }
        }else{
            $sitex = $site_project;
            foreach ($site_project as $key => $value) {
                $sp = "uSP_0405_SHB_0046C '{$tgl}', '{$tgl}', '{$value}'";
                $builder = $this->mcp->query($sp);
                $builder->getResultArray();
                $result = $builder->resultArray;
                foreach ($result as $key2 => $value2) {
                    foreach ($value2 as $key3 => $value3) {
                        $value2['region_code'] = $value;
                    }
                    $rows[] = $value2;
                }
            }
        }

        foreach ($rows as $key => $value) {
            $targetDay_arr[] = $value['targetDay'];
            $actual_arr[] = $value['actual'];

            if ($value['targetDay'] == '.000') {
                $rows[$key]['targetDay'] = 0;
            }

            if ($value['actual'] == '.000') {
                $rows[$key]['actual'] = 0;
            }

            $persentase = ($value['actual'] / $value['targetDay']) * 100;
            $rows[$key]['persentase'] = round($persentase, 2);
            $rows[$key]['minus'] = $value['actual'] - $value['targetDay'];
        }

        $select = "SUM(QtyRit * Capacity) AS total_ton_day";
        $builder_coal = $this->qBuilder->show_TR_PRODUCTIONB($select, $sitex, $tgl, 'CL');
        $total_actual_coal = $builder_coal->get()->getRow();

        $response = [
            "status" => true,
            "rows" => $rows,
            // "targetDay_arr" => $targetDay_arr,
            // "actual_arr" => $actual,
            "total_target" => array_sum($targetDay_arr),
            "total_actual" => array_sum($actual_arr),
            "total_target_coal" => 0,
            "total_actual_coal" => round($total_actual_coal->total_ton_day, 2)
        ];

        return $this->respond($response, 200);
    }

    public function show_daily()
    {
        $tgl = $this->request->getVar('tgl');
        $tgl2 = $this->request->getVar('tgl2');
        if (!$tgl2) {
            $tgl2 = $tgl;
        }
        $site = $this->request->getVar('site');
        // $site = implode("','", $this->show_region_code());
        // $site = "SSA";
        $site_project = $this->show_region_code();

        /*exec dbo.uSP_0405_SHB_0046B N''{$tgl}'',N'SSA' --FUEL
        exec dbo.uSP_0405_SHB_0046C N''{$tgl}'',N''{$tgl}'',N'SSA' --daily
        exec dbo.uSP_0405_SHB_0046D 2025,12,N''{$tgl}'',N''{$tgl}'',N'20250101',N'SSA' --monthly dan yearly
        exec dbo.uSP_0405_SHB_0046A N''{$tgl}'',N'SSA'*/

        // $sp = "uSP_0405_SHB_0046C '{$tgl}', '{$tgl}', '{$site}'";

        /*$a = "SELECT SUM(weight) as actual FROM  MCC_TR_HPRODUCTIONB WHERE MCC_TR_HPRODUCTIONB.kode = 'OB' AND MCC_TR_HPRODUCTIONB.region_code =  ('{$site}') AND CONVERT(CHAR(8), MCC_TR_HPRODUCTIONB.ProdDate, 112)  = '{$tgl}'";*/

        /*SELECT  RTRIM(LTRIM(CAST(CONVERT(CHAR(10), MCC_MS_TARGETB.tgl, 103) AS CHAR))) AS tanggal,
            MCC_MS_TARGETB.targetDay,
            IsNull((SELECT  SUM(weight)
            FROM  MCC_TR_HPRODUCTIONB
            WHERE MCC_TR_HPRODUCTIONB.kode = 'OB' AND MCC_TR_HPRODUCTIONB.region_code =@argproject AND
            CONVERT(CHAR(8), MCC_TR_HPRODUCTIONB.ProdDate, 112)  = @tgl1),0) AS actual,
            
            IsNull((SELECT  SUM(targetday)
            FROM  MCC_MS_TARGETB a
            WHERE a.material = 'OB' AND a.region_code =@argproject AND
            CONVERT(CHAR(8), a.tgl, 112) BETWEEN @tgl2 AND @tgl1 ),0) AS daily_cumm_plan,
            
            IsNull((SELECT  SUM(weight)
            FROM  MCC_TR_HPRODUCTIONB
            WHERE MCC_TR_HPRODUCTIONB.kode = 'OB' AND MCC_TR_HPRODUCTIONB.region_code =@argproject AND
            CONVERT(CHAR(8), MCC_TR_HPRODUCTIONB.ProdDate, 112) BETWEEN @tgl2 AND @tgl1 ),0) AS actual_cumm_plan
            
        FROM    MCC_MS_TARGETB
        WHERE   MCC_MS_TARGETB.material = 'OB' AND MCC_MS_TARGETB.region_code =@argproject AND CONVERT(CHAR(8), MCC_MS_TARGETB.tgl, 112)= @tgl1*/
        
        // $sp = "
        //     SELECT RTRIM(LTRIM(CAST(CONVERT(CHAR(10),MCC_MS_TARGETB.tgl, 103) AS CHAR))) AS tanggal,
        //         MCC_MS_TARGETB.targetDay,
        //         IsNull((SELECT SUM(weight) FROM  MCC_TR_HPRODUCTIONB WHERE MCC_TR_HPRODUCTIONB.kode = 'OB' AND MCC_TR_HPRODUCTIONB.region_code IN ('{$site}') AND CONVERT(CHAR(8), MCC_TR_HPRODUCTIONB.ProdDate, 112)  = '{$tgl}'),0) AS actual,
        //         IsNull((SELECT  SUM(targetday) FROM  MCC_MS_TARGETB a WHERE a.material = 'OB' AND a.region_code IN ('{$site}') AND CONVERT(CHAR(8), a.tgl, 112) BETWEEN '{$tgl}' AND '{$tgl}' ),0) AS daily_cumm_plan,
        //         IsNull((SELECT  SUM(weight) FROM  MCC_TR_HPRODUCTIONB WHERE MCC_TR_HPRODUCTIONB.kode = 'OB' AND MCC_TR_HPRODUCTIONB.region_code IN ('{$site}') AND CONVERT(CHAR(8),
        //         MCC_TR_HPRODUCTIONB.ProdDate, 112) = '{$tgl}' ),0) AS actual_cumm_plan

        //     FROM MCC_MS_TARGETB
        //     WHERE MCC_MS_TARGETB.material = 'OB' 
        //         AND MCC_MS_TARGETB.region_code IN  ('{$site}') 
        //         AND CONVERT(CHAR(8),MCC_MS_TARGETB.tgl, 112) = '{$tgl}'
        // ";

        // $builder = $this->mcp->query($sp);
        // $builder->getResultArray();
        // $builder = $builder->resultArray;

        // // $bcm_tot_arr = [];

        $rows = [];
        $targetDay_arr = [];
        $actual_arr = [];

        if ($site) {
            $sitex = $site;
            $sp = "uSP_0405_SHB_0046C '{$tgl}', '{$tgl}', '{$site}'";
            $builder = $this->mcp->query($sp);
            $builder->getResultArray();
            $result = $builder->resultArray;
            foreach ($result as $key => $value) {
                foreach ($value as $key2 => $value2) {
                    $value['region_code'] = $site;
                }

                $rows[] = $value;
            }
        }else{
            $sitex = $site_project;
            foreach ($site_project as $key => $value) {
                $sp = "uSP_0405_SHB_0046C '{$tgl}', '{$tgl}', '{$value}'";
                $builder = $this->mcp->query($sp);
                $builder->getResultArray();
                $result = $builder->resultArray;
                foreach ($result as $key2 => $value2) {
                    foreach ($value2 as $key3 => $value3) {
                        $value2['region_code'] = $value;
                    }
                    $rows[] = $value2;
                }
            }
        }

        $keys = [];
        foreach ($rows as $key => $value) {
            // $keys[$value['region_code']] = $value['actual'];
            $keys[] = $value['region_code'];

            $targetDay_arr[] = $value['targetDay'];
            $actual_arr[] = $value['actual'];

            if ($value['targetDay'] == '.000') {
                $rows[$key]['targetDay'] = 0;
            }

            if ($value['actual'] == '.000') {
                $rows[$key]['actual'] = 0;
            }

            $persentase = ($value['actual'] / $value['targetDay']) * 100;
            $rows[$key]['persentase'] = round($persentase, 2);
            $rows[$key]['balance'] = $value['actual'] - $value['targetDay'];
            $rows[$key]['minus'] = $value['actual'] - $value['targetDay'];
        }

        $keys2 = $keys;
        foreach ($site_project as $key => $value) {
            if (!in_array($value, $keys)) {
                array_push($keys2, $value);
            }
        }

        // $a = array_merge($keys, $notKey);

        // $rows_by_site = [];
        // foreach ($a as $key => $value) {
        //     $a = [
        //         "region_code" => $key,
        //         "total_target" => 0,
        //         "total_actual" => $value,
        //         "persentase" => 0,
        //         "balance" => 0
        //     ];

        //     $rows_by_site[] = $a;
        // }

        $select = "SUM(QtyRit * Capacity) AS total_ton_day";
        $builder_coal = $this->qBuilder->show_TR_PRODUCTIONB($select, $sitex, $tgl, 'CL');
        $total_actual_coal = $builder_coal->get()->getRow();

        $show_hauling_daily = $this->hauling_daily();

        $ob_daily_by_site = [];
        $hauling_daily_by_site = [];
        $coal_daily_by_site = [];

        foreach ($site_project as $key => $value) {
            $hauling_total_target_site = round($this->qBuilder->total_target_production($tgl, $tgl2, [$value], ['CL'])->total_target,2);
            $hauling_total_actual_site = round($this->qBuilder->total_actual_production($tgl, $tgl2, [$value], ['CL'])->total_actual,2);
            $hauling_total_balance_site = round($hauling_total_actual_site - $hauling_total_target_site,2);
            if ($hauling_total_target_site != 0) {
                $hauling_total_actual_persen_site = round(($hauling_total_actual_site / $hauling_total_target_site) * 100, 2);
            }else{
                $hauling_total_actual_persen_site = 0;
            }
            $hauling_daily_by_site[] = [
                "region_code" => $value,
                "total_target" => $hauling_total_target_site,
                "total_actual" => $hauling_total_actual_site,
                "total_balance" => $hauling_total_balance_site ,
                "total_actual_persen" => $hauling_total_actual_persen_site
            ];

            $ob_total_target_site = round($this->qBuilder->total_target_production($tgl, $tgl2, [$value], ['OB'])->total_target,2);
            $ob_total_actual_site = round($this->qBuilder->total_actual_production($tgl, $tgl2, [$value], ['OB'])->total_actual,2);
            $ob_total_balance_site = round($ob_total_actual_site - $ob_total_target_site,2);
            if ($ob_total_target_site != 0) {
                $ob_total_actual_persen_site = round(($ob_total_actual_site / $ob_total_target_site) * 100, 2);
            }else{
                $ob_total_actual_persen_site = 0;
            }
            $ob_daily_by_site[] = [
                "region_code" => $value,
                "total_target" => $ob_total_target_site,
                "total_actual" => $ob_total_actual_site,
                "total_balance" => $ob_total_balance_site ,
                "total_actual_persen" => $ob_total_actual_persen_site
            ];

            $coal_total_target_site = round($this->qBuilder->total_target_production($tgl, $tgl2, [$value], ['CG'])->total_target,2);
            $coal_total_actual_site = round($this->qBuilder->total_actual_production($tgl, $tgl2, [$value], ['CL'])->total_actual,2);
            $coal_total_balance_site = round($coal_total_actual_site - $coal_total_target_site,2);
            if ($coal_total_target_site != 0) {
                $coal_total_actual_persen_site = round(($coal_total_actual_site / $coal_total_target_site) * 100, 2);
            }else{
                $coal_total_actual_persen_site = 0;
            }
            $coal_daily_by_site[] = [
                "region_code" => $value,
                "total_target" => $coal_total_target_site,
                "total_actual" => $coal_total_actual_site,
                "total_balance" => $coal_total_balance_site ,
                "total_actual_persen" => $coal_total_actual_persen_site
            ];
        }

        $ob_total_target = round($this->qBuilder->total_target_production($tgl, $tgl2, $site_project, ['OB'])->total_target,2);
        $ob_total_actual = round($this->qBuilder->total_actual_production($tgl, $tgl2, $site_project, ['OB'])->total_actual,2);
        $ob_total_balance = round($ob_total_actual - $ob_total_target, 2);
        $ob_total_actual_persen = round(($ob_total_actual / $ob_total_target) * 100, 2);

        $coal_total_target = round($this->qBuilder->total_target_production($tgl, $tgl2, $site_project, ['CG'])->total_target,2);
        $coal_total_actual = round($this->qBuilder->total_actual_production($tgl, $tgl2, $site_project, ['CL'])->total_actual,2);
        $coal_total_balance = round($coal_total_actual - $coal_total_target, 2);
        $coal_total_actual_persen = round(($coal_total_actual / $coal_total_target) * 100, 2);

        $hauling_total_target = round($this->qBuilder->total_target_production($tgl, $tgl2, $site_project, ['CL'])->total_target,2);
        $hauling_total_actual = round($this->qBuilder->total_actual_production($tgl, $tgl2, $site_project, ['CL'])->total_actual,2);
        $hauling_total_balance = round($hauling_total_actual - $hauling_total_target, 2);
        $hauling_total_actual_persen = round(($hauling_total_actual / $hauling_total_target) * 100, 2);

        $response = [
            "status" => true,
            "ob" => [
                "total_target" => $ob_total_target,
                "total_actual" => $ob_total_actual,
                "total_balance" => $ob_total_balance,
                "total_actual_persen" => $ob_total_actual_persen,
                "rows" => $ob_daily_by_site
            ],
            "coalore" => [
                "total_target" => $coal_total_target,
                "total_actual" => $coal_total_actual,
                "total_balance" => $coal_total_balance,
                "total_actual_persen" => $coal_total_actual_persen,
                "rows" => $coal_daily_by_site
            ],
            "hauling" => [
                "total_target" => $hauling_total_target,
                "total_actual" => $hauling_total_actual,
                "total_balance" => $hauling_total_balance,
                "total_actual_persen" => $hauling_total_actual_persen,
                "rows" => $hauling_daily_by_site,
            ],
            // "keys" => $keys,
            // "keys2" => $keys2,
            // // "a" => $a,
            // "rows" => $rows,
            // // "targetDay_arr" => $targetDay_arr,
            // // "actual_arr" => $actual,
            // "total_target" => array_sum($targetDay_arr),
            // "total_actual" => array_sum($actual_arr),
            // "total_target_coal" => 0,
            // "total_actual_coal" => round($total_actual_coal->total_ton_day, 2),
            // // "total_target_hauling" => 0,
            // // "total_actual_hauling" => $show_hauling_daily['total'],
            // // "rows_actual_hauling" => $tota
            // "zhauling" => $this->hauling_daily()
        ];

        return $this->respond($response, 200);
    }

    public function zshow_summary_coalore_daily()
    {
        $tgl = $this->request->getVar('tgl');
        $site = $this->request->getVar('site');
        $site_project = $this->show_region_code();

        $q = "SELECT  '1.UNIT POPULATION' AS status_unit,
            mcc_ms_unit.model_no,
            mcc_ms_unit.unit_code,
            /*
                (SELECT TOP 1 time_start FROM MCC_TR_WORKHOUR WHERE MCC_TR_WORKHOUR.equipment_code = mcc_ms_unit.unit_code AND CAST(CONVERT(CHAR(8), MCC_TR_WORKHOUR.prodDate, 112) AS NUMERIC) = '{$tgl}' AND MCC_TR_WORKHOUR.activity_code = '01' AND MCC_TR_WORKHOUR.time_start = (SELECT MIN(time_start) FROM    MCC_TR_WORKHOUR a WHERE   a.equipment_code = mcc_ms_unit.unit_code AND a.time_start >= 7 AND a.time_start <= 18.59 AND a.activity_code = '01' AND CAST(CONVERT(CHAR(8), a.prodDate, 112) AS NUMERIC) = '{$tgl}')) AS time_start_day,
                (SELECT TOP 1 time_finish FROM    MCC_TR_WORKHOUR WHERE   MCC_TR_WORKHOUR.equipment_code = mcc_ms_unit.unit_code AND
                    CAST(CONVERT(CHAR(8), MCC_TR_WORKHOUR.prodDate, 112) AS NUMERIC) = '{$tgl}' AND
                    MCC_TR_WORKHOUR.activity_code = '01' AND
                    MCC_TR_WORKHOUR.time_finish = (SELECT   MAX(time_finish)
                    FROM    MCC_TR_WORKHOUR a
                    WHERE   a.equipment_code = mcc_ms_unit.unit_code AND
                    a.time_finish >= 7 AND
                    a.time_finish <= 18.59 AND
                    a.activity_code = '01' AND
                    CAST(CONVERT(CHAR(8), a.prodDate, 112) AS NUMERIC) = '{$tgl}')) AS time_end_day,
                (SELECT SUM(time_use)
                    FROM    MCC_TR_WORKHOUR
                    WHERE   MCC_TR_WORKHOUR.equipment_code = mcc_ms_unit.unit_code AND
                    MCC_TR_WORKHOUR.activity_code = '01' AND
                    MCC_TR_WORKHOUR.time_start >= 7 AND
                    MCC_TR_WORKHOUR.time_finish <= 18.59 AND
                    CAST(CONVERT(CHAR(8), MCC_TR_WORKHOUR.prodDate, 112) AS NUMERIC) = '{$tgl}') AS time_use_day,
                (SELECT hm_start
                    FROM    MCC_TR_HOURMETERB
                    WHERE   MCC_TR_HOURMETERB.equipment_code = mcc_ms_unit.unit_code AND
                    CAST(CONVERT(CHAR(8), MCC_TR_HOURMETERB.ProdDate, 112) AS NUMERIC) = '{$tgl}' AND
                    MCC_TR_HOURMETERB.shift_code = 'D') AS hm_start_day,
                (SELECT hm_end
                    FROM    MCC_TR_HOURMETERB
                    WHERE   MCC_TR_HOURMETERB.equipment_code = mcc_ms_unit.unit_code AND
                    CAST(CONVERT(CHAR(8), MCC_TR_HOURMETERB.ProdDate, 112) AS NUMERIC) = '{$tgl}' AND
                    MCC_TR_HOURMETERB.shift_code = 'D') AS hm_end_day,
                ISNULL((SELECT  hm_end
                    FROM    MCC_TR_HOURMETERB
                    WHERE   MCC_TR_HOURMETERB.equipment_code = mcc_ms_unit.unit_code AND
                    CAST(CONVERT(CHAR(8), MCC_TR_HOURMETERB.ProdDate, 112) AS NUMERIC) = '{$tgl}' AND
                    MCC_TR_HOURMETERB.shift_code = 'D'), 0) - ISNULL((SELECT    hm_start
                    FROM    MCC_TR_HOURMETERB
                    WHERE   MCC_TR_HOURMETERB.equipment_code = mcc_ms_unit.unit_code AND
                    CAST(CONVERT(CHAR(8), MCC_TR_HOURMETERB.ProdDate, 112) AS NUMERIC) = '{$tgl}' AND
                    MCC_TR_HOURMETERB.shift_code = 'D'), 0) AS working_hours_day,
                (SELECT MIN(unit_time)
                    FROM    tr_doh
                    WHERE   tr_doh.unit_code = mcc_ms_unit.unit_code AND
                    tr_doh.shift_code = 'D' AND
                    tr_doh.status_do <> '4' AND
                    CAST(CONVERT(CHAR(8), tr_doh.tgl, 112) AS NUMERIC) = '{$tgl}') AS jam_isi_solar_day,
                    (SELECT SUM(tr_dod.qty_out)
                    FROM    tr_dod, tr_doh
                    WHERE   tr_dod.do_code = tr_doh.do_code AND
                    tr_doh.unit_code = mcc_ms_unit.unit_code AND
                    tr_doh.shift_code = 'D' AND
                    tr_doh.status_do <> '4' AND
                        CAST(CONVERT(CHAR(8), tr_doh.tgl, 112) AS NUMERIC) = '{$tgl}') AS qty_out_day,
                (SELECT SUM(QtyRit)
                    FROM    MCC_TR_HPRODUCTIONB
                    WHERE   MCC_TR_HPRODUCTIONB.unit_houler = mcc_ms_unit.unit_code AND
                    MCC_TR_HPRODUCTIONB.tShift = 'D' AND
                    MCC_TR_HPRODUCTIONB.kode = 'OB' AND
                    CAST(CONVERT(CHAR(8), MCC_TR_HPRODUCTIONB.ProdDate, 112) AS NUMERIC) = '{$tgl}') AS qtyrit_ob_day,
                (SELECT SUM(QtyRit * Capacity)
                    FROM    MCC_TR_HPRODUCTIONB
                    WHERE   MCC_TR_HPRODUCTIONB.unit_houler = mcc_ms_unit.unit_code AND
                    MCC_TR_HPRODUCTIONB.tShift = 'D' AND
                    MCC_TR_HPRODUCTIONB.kode = 'OB' AND
                    CAST(CONVERT(CHAR(8), MCC_TR_HPRODUCTIONB.ProdDate, 112) AS NUMERIC) = '{$tgl}') AS bcm_ob_day,
            */
            (SELECT SUM(QtyRit)
                FROM MCC_TR_HPRODUCTIONB
                WHERE MCC_TR_HPRODUCTIONB.unit_houler = mcc_ms_unit.unit_code AND
                MCC_TR_HPRODUCTIONB.tShift = 'D' AND
                MCC_TR_HPRODUCTIONB.kode = 'CL' AND
                CAST(CONVERT(CHAR(8), MCC_TR_HPRODUCTIONB.ProdDate, 112) AS NUMERIC) = '{$tgl}') AS qtyrit_co_day,
            (SELECT SUM(QtyRit * Capacity)
                FROM MCC_TR_HPRODUCTIONB
                WHERE MCC_TR_HPRODUCTIONB.unit_houler = mcc_ms_unit.unit_code AND
                MCC_TR_HPRODUCTIONB.tShift = 'D' AND
                MCC_TR_HPRODUCTIONB.kode = 'CL' AND
                CAST(CONVERT(CHAR(8), MCC_TR_HPRODUCTIONB.ProdDate, 112) AS NUMERIC) = '{$tgl}') AS ton_co_day
            /*
                (SELECT TOP 1 time_start
                    FROM    MCC_TR_WORKHOUR
                    WHERE   MCC_TR_WORKHOUR.equipment_code = mcc_ms_unit.unit_code AND
                    CAST(CONVERT(CHAR(8), MCC_TR_WORKHOUR.prodDate, 112) AS NUMERIC) = '{$tgl}' AND
                    MCC_TR_WORKHOUR.activity_code = '01' AND
                        MCC_TR_WORKHOUR.time_start = (SELECT    MIN(time_start)
                    FROM    MCC_TR_WORKHOUR a
                    WHERE   a.equipment_code = mcc_ms_unit.unit_code AND
                    a.time_start >= 17 AND
                    a.time_start <= 6.59 AND
                    a.activity_code = '01' AND
                    CAST(CONVERT(CHAR(8), a.prodDate, 112) AS NUMERIC) = '{$tgl}')) AS time_start_night,
                (SELECT TOP 1 time_finish
                    FROM    MCC_TR_WORKHOUR
                    WHERE   MCC_TR_WORKHOUR.equipment_code = mcc_ms_unit.unit_code AND
                    CAST(CONVERT(CHAR(8), MCC_TR_WORKHOUR.prodDate, 112) AS NUMERIC) = '{$tgl}' AND
                    MCC_TR_WORKHOUR.activity_code = '01' AND
                    MCC_TR_WORKHOUR.time_finish = (SELECT   MAX(time_finish)
                    FROM    MCC_TR_WORKHOUR a
                    WHERE   a.equipment_code = mcc_ms_unit.unit_code AND
                    a.time_finish >= 17 AND
                    a.time_finish <= 6.59 AND
                    a.activity_code = '01' AND
                    CAST(CONVERT(CHAR(8), a.prodDate, 112) AS NUMERIC) = '{$tgl}')) AS time_end_night,
                (SELECT SUM(time_use)
                    FROM    MCC_TR_WORKHOUR
                    WHERE   MCC_TR_WORKHOUR.equipment_code = mcc_ms_unit.unit_code AND
                    MCC_TR_WORKHOUR.activity_code = '01' AND
                    MCC_TR_WORKHOUR.time_start >= 17 AND
                    MCC_TR_WORKHOUR.time_finish <= 6.59 AND
                    CAST(CONVERT(CHAR(8), MCC_TR_WORKHOUR.prodDate, 112) AS NUMERIC) = '{$tgl}') AS time_use_night,
                    (SELECT hm_start
                    FROM    MCC_TR_HOURMETERB
                    WHERE   MCC_TR_HOURMETERB.equipment_code = mcc_ms_unit.unit_code AND
                    CAST(CONVERT(CHAR(8), MCC_TR_HOURMETERB.ProdDate, 112) AS NUMERIC) = '{$tgl}' AND
                    MCC_TR_HOURMETERB.shift_code = 'N') AS hm_start_night,
                (SELECT hm_end
                    FROM    MCC_TR_HOURMETERB
                    WHERE   MCC_TR_HOURMETERB.equipment_code = mcc_ms_unit.unit_code AND
                    CAST(CONVERT(CHAR(8), MCC_TR_HOURMETERB.ProdDate, 112) AS NUMERIC) = '{$tgl}' AND
                    MCC_TR_HOURMETERB.shift_code = 'N') AS hm_end_night,
                    ISNULL((SELECT  hm_end
                    FROM    MCC_TR_HOURMETERB
                    WHERE   MCC_TR_HOURMETERB.equipment_code = mcc_ms_unit.unit_code AND
                    CAST(CONVERT(CHAR(8), MCC_TR_HOURMETERB.ProdDate, 112) AS NUMERIC) = '{$tgl}' AND
                    MCC_TR_HOURMETERB.shift_code = 'N'), 0) - ISNULL((SELECT    hm_start
                    FROM    MCC_TR_HOURMETERB
                    WHERE   MCC_TR_HOURMETERB.equipment_code = mcc_ms_unit.unit_code AND
                    CAST(CONVERT(CHAR(8), MCC_TR_HOURMETERB.ProdDate, 112) AS NUMERIC) = '{$tgl}' AND
                    MCC_TR_HOURMETERB.shift_code = 'N'), 0) AS working_hours_night,
                (SELECT MIN(unit_time)
                    FROM    tr_doh
                    WHERE   tr_doh.unit_code = mcc_ms_unit.unit_code AND
                    tr_doh.shift_code = 'N' AND
                    tr_doh.status_do <> '4' AND
                    CAST(CONVERT(CHAR(8), tr_doh.tgl, 112) AS NUMERIC) = '{$tgl}') AS jam_isi_solar_night,
                (SELECT SUM(tr_dod.qty_out)
                    FROM    tr_dod, tr_doh
                    WHERE   tr_dod.do_code = tr_doh.do_code AND
                    tr_doh.unit_code = mcc_ms_unit.unit_code AND
                    tr_doh.shift_code = 'N' AND
                    tr_doh.status_do <> '4' AND
                    CAST(CONVERT(CHAR(8), tr_doh.tgl, 112) AS NUMERIC) = '{$tgl}') AS qty_out_night,
                (SELECT SUM(QtyRit)
                    FROM    MCC_TR_HPRODUCTIONB
                    WHERE   MCC_TR_HPRODUCTIONB.unit_houler = mcc_ms_unit.unit_code AND
                    MCC_TR_HPRODUCTIONB.tShift = 'N' AND
                    MCC_TR_HPRODUCTIONB.kode = 'OB' AND
                    CAST(CONVERT(CHAR(8), MCC_TR_HPRODUCTIONB.ProdDate, 112) AS NUMERIC) = '{$tgl}') AS qtyrit_ob_night,
                (SELECT SUM(QtyRit * Capacity)
                    FROM    MCC_TR_HPRODUCTIONB
                    WHERE   MCC_TR_HPRODUCTIONB.unit_houler = mcc_ms_unit.unit_code AND
                    MCC_TR_HPRODUCTIONB.tShift = 'N' AND
                    MCC_TR_HPRODUCTIONB.kode = 'OB' AND
                    CAST(CONVERT(CHAR(8), MCC_TR_HPRODUCTIONB.ProdDate, 112) AS NUMERIC) = '{$tgl}') AS bcm_ob_night,
                (SELECT SUM(QtyRit)
                    FROM    MCC_TR_HPRODUCTIONB
                    WHERE   MCC_TR_HPRODUCTIONB.unit_houler = mcc_ms_unit.unit_code AND
                    MCC_TR_HPRODUCTIONB.tShift = 'N' AND
                    MCC_TR_HPRODUCTIONB.kode = 'CL' AND
                    CAST(CONVERT(CHAR(8), MCC_TR_HPRODUCTIONB.ProdDate, 112) AS NUMERIC) = '{$tgl}') AS qtyrit_co_night,
                (SELECT SUM(QtyRit * Capacity)
                    FROM    MCC_TR_HPRODUCTIONB
                    WHERE   MCC_TR_HPRODUCTIONB.unit_houler = mcc_ms_unit.unit_code AND
                    MCC_TR_HPRODUCTIONB.tShift = 'N' AND
                    MCC_TR_HPRODUCTIONB.kode = 'CL' AND
                    CAST(CONVERT(CHAR(8), MCC_TR_HPRODUCTIONB.ProdDate, 112) AS NUMERIC) = '{$tgl}') AS ton_co_night
            */
        FROM mcc_ms_unit
        WHERE mcc_ms_unit.stEdit <> '4';

        -- UNION ALL

        -- SELECT  '2.OTHER UNIT' AS status_unit,
        --     '' AS model_no,
        --     tr_doh.unit_code,
        --     -- 0 AS time_start_day,
        --     -- 0 AS time_end_day,
        --     -- 0 AS time_use_day,
        --     -- 0 AS hm_start_day,
        --     -- 0 AS hm_end_day,
        --     -- 0 AS working_hours_day,
        --     -- 0 AS jam_isi_solar_day,
        --     -- (CASE tr_doh.shift_code
        --     -- WHEN 'D' THEN
        --     -- tr_dod.qty_out
        --     -- ELSE
        --     -- 0
        --     -- END) AS qty_out_day,
        --     -- 0 AS qtyrit_ob_day,
        --     -- 0 AS bcm_ob_day,
        --     0 AS qtyrit_co_day,
        --     0 AS ton_co_day,
        --     -- 0 AS time_start_night,
        --     -- 0 AS time_end_night,
        --     -- 0 AS time_use_night,
        --     -- 0 AS hm_start_night,
        --     -- 0 AS hm_end_night,
        --     -- 0 AS working_hours_night,
        --     -- 0 AS jam_isi_solar_night,
        --     -- (CASE tr_doh.shift_code
        --     -- WHEN 'N' THEN
        --     -- tr_dod.qty_out
        --     -- ELSE
        --     -- 0
        --     -- END) AS qty_out_night,
        --     -- 0 AS qtyrit_ob_night,
        --     -- 0 AS bcm_ob_night,
        --     -- 0 AS qtyrit_co_night,
        --     -- 0 AS ton_co_night
        -- FROM tr_dod, tr_doh 
        -- WHERE tr_dod.do_code = tr_doh.do_code AND
        --     tr_doh.status_do <> '4' AND
        --     tr_doh.type_do = '1' AND
            -- CAST(CONVERT(CHAR(8), tr_doh.tgl, 112) AS NUMERIC) = '{$tgl}'";

        $builder = $this->mcp->query($q);
        $builder->getResultArray();
        $result = $builder->resultArray;

        $ton_co_day_arr = [];

        foreach ($result as $key => $value) {
            $ton_co_day_arr[] = $value['ton_co_day'];
        }

        $total_ton_co_day = array_sum($ton_co_day_arr);

        $response = [
            "status" => true,
            "rows" => $result,
            "total_ton_co_day" => $total_ton_co_day
        ];

        return $this->respond($response, 200);
    }

    public function show_summary_coalore_daily()
    {
        $tgl = $this->request->getVar('tgl');
        $site = $this->request->getVar('site');
        $site_project = $this->show_region_code();

        if (!$site) {
            $site = $site_project;
        }
        $select = "SUM(QtyRit * Capacity) AS total_ton_day";
        $builder = $this->qBuilder->show_TR_PRODUCTIONB($select, $site, $tgl, 'CL');
        $result = $builder->get()->getRow();

        return $this->respond($result, 200);
    }

    public function hauling_daily()
    {
        $tgl = $this->request->getVar('tgl');
        $tgl2 = $this->request->getVar('tgl');
        $site = $this->request->getVar('site');
        $site_project = $this->show_region_code();

        $rows = [];
        $total = 0;
        $total_rit = 0;

        if ($site) {
            // code...
            $builder = $this->qBuilder->query_show_hauling_daily($tgl, $tgl2, $site);
            $result = $builder->resultArray;
            foreach ($result as $key => $value) {
                foreach ($value as $key2 => $value2) {
                    $value['region_code'] = $site;
                }

                $rows[] = $value;
            }
        }else{
            foreach ($site_project as $key => $value) {
                $builder = $this->qBuilder->query_show_hauling_daily($tgl, $tgl2, $value);
                $result = $builder->resultArray;

                foreach ($result as $key2 => $value2) {
                    foreach ($value2 as $key3 => $value3) {
                        $value2['region_code'] = $value;
                    }
                    $rows[] = $value2;
                }
            }
        }
        // $builder = $this->qBuilder->TEMP1($tgl, $tgl2, $site);
        // $builder = $this->qBuilder->sp_show_hauling_daily($tgl, $tgl2, $site);


        foreach ($rows as $key => $value) {
            $total += $value['day'] + $value['night'];
            $total_rit += $value['day_rit'] + $value['night_rit'];
        }

        $rows_actual_by_site = [];
        foreach ($site_project as $key => $value) {
            foreach ($rows as $key2 => $value2) {
                if ($value2['region_code'] == $value) {
                    $rows_actual_by_site[$value][] = $value2['day'] + $value2['night'];
                }
            }
        }

        foreach ($rows_actual_by_site as $key => $value) {
            $totalv = array_sum($value);
            $rows_actual_by_site[$key] = round($totalv,2);
        }

        $keys = [];
        foreach ($rows_actual_by_site as $key2 => $value2) {
            $keys[] = $key2;
        }

        $notKey = [];
        foreach ($site_project as $key => $value) {
            if (!in_array($value, $keys)) {
                $notKey[$value] = 0;
            }
        }

        $a = array_merge($rows_actual_by_site, $notKey);

        $rows_by_site = [];
        foreach ($a as $key => $value) {
            $a = [
                "region_code" => $key,
                "total_target" => 0,
                "total_actual" => $value,
                "persentase" => 0,
                "balance" => 0
            ];

            $rows_by_site[] = $a;
        }

        $response = [
            "status"             => true,
            "rows"               => $rows,
            "total_target"       => 0,
            "total_actual"       => round($total,2),
            "total_rit"          => round($total_rit,2),
            "rows_by_site"       => $rows_by_site,
        ];

        return $response;
    }

    public function show_hauling_daily()
    {
        $response = $this->hauling_daily();

        return $this->respond($response, 200);
    }

    public function show_V_MCC_TR_HPRODUCTIONB_CL()
    {
        $tgl = $this->request->getVar('tgl');
        $tgl2 = $this->request->getVar('tgl');
        $site = $this->request->getVar('site');

        $builder = $this->qBuilder->show_V_MCC_TR_HPRODUCTIONB_CL($tgl, $site);
        $result = $builder->resultArray;

        return $this->respond($result, 200);
    }

    public function summary_production()
    {
        $tgl = $this->request->getVar('tgl');
        $tgl2 = $this->request->getVar('tgl2');
        $sites = $this->request->getVar('site');
        $kode = $this->request->getVar('tgl');

        $builder = $this->qBuilder->total_production($tgl, $tgl2, $sites, $kode);

        return $this->respond($builder, 200);
    }

    public function total_production()
    {
        $tgl = $this->request->getVar('tgl');
        $tgl2 = $this->request->getVar('tgl2');
        $sites = explode(',', $this->request->getVar('site'));
        $kode = explode(',', $this->request->getVar('kode'));

        $builder = $this->qBuilder->total_production($tgl, $tgl2, $sites, $kode);

        return $this->respond($builder, 200);
    }
}
