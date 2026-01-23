<?php

namespace Sparkhizb\Builder\Syshab\MCP;

use Sparkhizb\Helpers\UmmuHelper;
use Sparkhizb\Helpers\RequestHelper;
use Sparkhizb\Models\Syshab\MCP\JobsiteModel;
use Sparkhizb\Models\Syshab\MCP\SubLocModel;

class SubLocBuilder
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->mcp = \Config\Database::connect('mcp');
        $this->request = \Config\Services::request();
        $this->reqH = new RequestHelper();
        $this->umHelp = new UmmuHelper();
        $this->model = new SubLocModel();
    }

    public function show($id = null)
    {
        // 
    }

    public function getBy_locCode($loc_code, $select = null)
    {
        if ($select == null) {
            $select = "*";
        }

        $builder = $this->mcp->table('MCC_MS_SUBLOC')
        ->select($select)
        ->whereIn("loc_code", $loc_code);

        return $builder;
    }
}