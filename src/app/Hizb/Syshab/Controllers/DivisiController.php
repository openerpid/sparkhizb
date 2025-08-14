<?php

namespace App\Hizb\Syshab\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;
use Sparkhizb\Helpers\QueryHelper;

use App\Hizb\Syshab\Builder\DivisiBuilder;

class DivisiController extends ResourceController
{
    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->qBuilder = new DivisiBuilder();
        $this->qHelp = new QueryHelper();
    }

    public function index()
    {
        // 
    }

    public function show($id = null)
    {
        $builder = $this->qBuilder->show($id);
        $total = $this->qHelp->_total($builder);
        $rows = $this->qHelp->_rowsBui($builder);
        $count = count($rows);

        $response = $this->qHelp->respon($rows, $count, $total);

        return $this->respond($response, $response['scode']);
    }
}
