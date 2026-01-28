<?php

namespace Sparkhizb\Builder\Syshab\MCP;

use Sparkhizb\Helpers\UmmuHelper;
use Sparkhizb\Helpers\DateTimeHelper;
use Sparkhizb\Helpers\RequestHelper;
use Sparkhizb\UmmuHazardReport;
// use App\Hizb\Models\Safety\HazardReportQueueMailModel;
// use App\Hizb\Models\Safety\HazardReportNumberModel;
use Sparkhizb\Models\DashboardSiteProjectListModel;
use Sparkhizb\Models\Syshab\MCP\TypeLoadModel;
use Sparkhizb\Models\Syshab\MCP\PlanModel;

class PlanBuilder
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        // $this->iescm = \Config\Database::connect('iescm');
        $this->herp = \Config\Database::connect('herp');
        $this->mcp = \Config\Database::connect('mcp');
        $this->request = \Config\Services::request();
        $this->reqH = new RequestHelper();
        $this->umHelp = new UmmuHelper();
        // $this->ummu = new UmmuHazardReport();
        $this->model = new PlanModel();
        // $this->mNum = new HazardReportNumberModel();
        $this->mSiteDash = new DashboardSiteProjectListModel();
        $this->mTypeLoad = new TypeLoadModel();
        $this->dtH = new DateTimeHelper();
    }

    /**
     * $select = "(SUM(targetDay) / SUM(targetFuel)) as total";, 
     * $tgl = "2026-01-24", 
     * $site = ["SSA", "SSC"], 
     * $prod_code = ['CG','CL']
     */
    public function show_per_day($select, $tgl, $site, $prod_code)
    {
        $table = $this->model->table;

        $builder = $this->mcp->table($table)
        ->select($select)
        ->where('tgl', $tgl)
        ->whereIn('region_code', $site)
        ->whereIn('material', $prod_code);

        return $builder;
    }
}