<?php

namespace Sparkhizb\Builder\Syshab\MCP;

use Sparkhizb\Helpers\UmmuHelper;
use Sparkhizb\Helpers\DateTimeHelper;
use Sparkhizb\Helpers\RequestHelper;
use Sparkhizb\Models\DashboardSiteProjectListModel;
use Sparkhizb\Models\Syshab\MCP\TypeLoadModel;
use Sparkhizb\Models\Syshab\MCP\PlanPerPitModel;

class PlanPerPitBuilder
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->herp = \Config\Database::connect('herp');
        $this->mcp = \Config\Database::connect('mcp');
        $this->request = \Config\Services::request();
        $this->reqH = new RequestHelper();
        $this->umHelp = new UmmuHelper();
        $this->model = new PlanPerPitModel();
        $this->mSiteDash = new DashboardSiteProjectListModel();
        $this->mTypeLoad = new TypeLoadModel();
        $this->dtH = new DateTimeHelper();
    }

    /**
     * $select = "(SUM(raintime".(int)$month.") + SUM(slippery".(int)$month.")) as total";, 
     * $year = 2026, 
     * $site = ["SSA", "SSC"], 
     * $prod_code = ['CG','CL']
     */
    public function show($select, $year, $site, $prod_code)
    {
        $table = $this->model->table;

        $builder = $this->mcp->table($table)
        ->select($select)
        ->where('tahun', $year)
        ->whereIn('region_code', $site)
        ->whereIn('prod_code', $prod_code);

        return $builder;
    }
}