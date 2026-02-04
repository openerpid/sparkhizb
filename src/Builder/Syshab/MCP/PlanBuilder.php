<?php

namespace Sparkhizb\Builder\Syshab\MCP;

use Sparkhizb\Helpers\UmmuHelper;
use Sparkhizb\Helpers\DateTimeHelper;
use Sparkhizb\Helpers\RequestHelper;
use Sparkhizb\Models\DashboardSiteProjectListModel;
use Sparkhizb\Models\Syshab\MCP\TypeLoadModel;
use Sparkhizb\Models\Syshab\MCP\PlanModel;

class PlanBuilder
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->herp = \Config\Database::connect('herp');
        $this->mcp = \Config\Database::connect('mcp');
        $this->request = \Config\Services::request();
        $this->reqH = new RequestHelper();
        $this->umHelp = new UmmuHelper();
        $this->model = new PlanModel();
        $this->mSiteDash = new DashboardSiteProjectListModel();
        $this->mTypeLoad = new TypeLoadModel();
        $this->dtH = new DateTimeHelper();
    }

    private function subquery($select, $site, $prod_code)
    {
        $table = $this->model->table;

        $subquery = $this->mcp->table($table)
        // ->select($select)
        ->whereIn('region_code', $site)
        ->whereIn('material', $prod_code);

        return $this->mcp->newQuery()->fromSubquery($subquery, 't');
    }

    /**
     * $select = "(SUM(raintime".(int)$month.") + SUM(slippery".(int)$month.")) as total";, 
     * $tgl = "2026-01-05"
     * $site = ["SSA", "SSC"], 
     * $prod_code = ['CG','CL']
     */
    public function show_by_date($select, $tgl, $site, $prod_code)
    {
        $subquery = $this->subquery($select, $site, $prod_code);
        $builder = $subquery->select($select)
        ->where('tgl', $tgl);

        return $builder;
    }

    /**
     * $select = "(SUM(raintime".(int)$month.") + SUM(slippery".(int)$month.")) as total";, 
     * $tgl = "2026-01-01"
     * $tgl2 = "2026-01-015"
     * $site = ["SSA", "SSC"], 
     * $prod_code = ['CG','CL']
     */
    public function show_by_rangeDate($select, $tgl, $tgl2, $site, $prod_code)
    {
        $subquery = $this->subquery($select, $site, $prod_code);
        $builder =  $subquery->select($select)
        ->where('tgl >=', $tgl)
        ->where('tgl <=', $tgl2);

        return $builder;
    }

    /**
     * $select = "(SUM(raintime".(int)$month.") + SUM(slippery".(int)$month.")) as total";, 
     * $month = 2 // bulan februari
     * $site = ["SSA", "SSC"], 
     * $prod_code = ['CG','CL']
     */
    public function show_by_month($select, $month, $site, $prod_code)
    {
        $subquery = $this->subquery($select, $site, $prod_code);
        $builder = $subquery->select($select)
        ->where('bln', $month);

        return $builder;
    }

    /**
     * $select = "(SUM(raintime".(int)$month.") + SUM(slippery".(int)$month.")) as total";, 
     * $month = [1,11,9], // Bulan (januari, november, september)
     * $site = ["SSA", "SSC"], 
     * $prod_code = ['CG','CL']
     */
    public function show_by_inMonth($select, $month, $site, $prod_code)
    {
        $subquery = $this->subquery($select, $site, $prod_code);
        $builder = $subquery->select($select)
        ->whereIn('bln', $month);

        return $builder;
    }

    /**
     * $select = "(SUM(raintime".(int)$month.") + SUM(slippery".(int)$month.")) as total";, 
     * $year = 2026, 
     * $site = ["SSA", "SSC"], 
     * $prod_code = ['CG','CL']
     */
    public function show_by_year($select, $year, $site, $prod_code)
    {
        $subquery = $this->subquery($select, $site, $prod_code);
        $builder = $subquery->select($select)
        ->where('thn', $year);

        return $builder;
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