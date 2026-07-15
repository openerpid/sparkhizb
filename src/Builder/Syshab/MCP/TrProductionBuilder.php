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
use Sparkhizb\Models\Syshab\MCP\TrProductionModel;

class TrProductionBuilder
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
        $this->model = new TrProductionModel();
        // $this->mNum = new HazardReportNumberModel();
        $this->mSiteDash = new DashboardSiteProjectListModel();
        $this->mTypeLoad = new TypeLoadModel();
        $this->dtH = new DateTimeHelper();
    }

    /**
     * $select = "(SUM(targetDay) / SUM(targetFuel)) as total";, 
     * $fromDate = "2026-01-01", 
     * $toDate = "2026-01-31", 
     * $site = ["SSA", "SSC"], 
     * $prod_code = ['OB','CG','CL']
     */
    public function show_by_date($select, $fromDate, $toDate, $site, $prod_code)
    {
        $table = $this->model->table;

        $subquery = $this->mcp->table($table)
        ->select($select)
        ->whereIn('region_code', $site)
        ->where('ProdDate >=', $fromDate)
        ->where('ProdDate <=', $toDate)
        ->whereIn('kode', $prod_code);

        return $this->mcp->newQuery()->fromSubquery($subquery, 't');
    }
}