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

        /*exec dbo.uSP_0405_SHB_0046B N'20251201',N'SSA' --FUEL
        exec dbo.uSP_0405_SHB_0046C N'20251201',N'20251201',N'SSA' --daily
        exec dbo.uSP_0405_SHB_0046D 2025,12,N'20251201',N'20251201',N'20250101',N'SSA' --monthly dan yearly
        exec dbo.uSP_0405_SHB_0046A N'20251201',N'SSA'*/

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
        }

        $response = [
            "rows" => $rows,
            // "targetDay_arr" => $targetDay_arr,
            // "actual_arr" => $actual,
            "total_target" => array_sum($targetDay_arr),
            "total_actual" => array_sum($actual_arr)
        ];

        return $this->respond($response, 200);
    }
}
