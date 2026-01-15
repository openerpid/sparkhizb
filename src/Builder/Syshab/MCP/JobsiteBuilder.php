<?php

namespace Sparkhizb\Builder\Syshab\MCP;

use Sparkhizb\Helpers\UmmuHelper;
use Sparkhizb\Helpers\RequestHelper;
use Sparkhizb\UmmuHazardReport;
use Sparkhizb\Models\Syshab\MCP\JobsiteModel;

class JobsiteBuilder
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->mcp = \Config\Database::connect('mcp');
        $this->request = \Config\Services::request();
        $this->reqH = new RequestHelper();
        $this->umHelp = new UmmuHelper();
        $this->ummu = new UmmuHazardReport();
        $this->model = new HazardReportQueueMailModel();
        $this->mNum = new HazardReportNumberModel();
    }

    public function show($id = null)
    {
        // 
    }

    public function query_select()
    {
        $query = "SELECT region_code FROM ms_jobsite  WHERE tActive = 1 ";

        $builder = $this->mcp->query($query);
        $builder->getResultArray();
        $builder = $builder->resultArray;
    }
}