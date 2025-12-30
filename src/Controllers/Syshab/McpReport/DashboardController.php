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
        // $this->sitepMod = new SiteProjectModel();
        // $this->qbSite = new SiteProjectHerpBuilder();
    }

    public function index()
    {
        $login_module = session()->get('login_module');
        $data = [
            'navlink' => 'mcp_dashboard',
            'breadcrumb' => [
                [
                    "name" => "Admin",
                    "page" => "#",
                    "active" => ""
                ],
                [
                    "name" => "Dashboard",
                    "page" => "#",
                    "active" => "active"
                ]
            ]
        ];

        $page = 'pages/mcp_report/dashboard/index';

        return view($page, $data);
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
}
