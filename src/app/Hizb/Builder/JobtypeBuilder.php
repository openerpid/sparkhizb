<?php

namespace App\Hizb\Builder;

use Sparkhizb\Helpers\Curl;
use Sparkhizb\Helpers\CurlHelper;
use Sparkhizb\Helpers\RequestHelper;
use Sparkhizb\Helpers\IdentityHelper;
use SaintSystems\OData\ODataClient;
use Sparkhizb\UmmuPmJobtype;
use Sparkhizb\Helpers\UmmuHelper;

class JobtypeBuilder
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->request = \Config\Services::request();
        $this->curl = new Curl();
        $this->curlH = new CurlHelper();
        $this->reqH = new RequestHelper();
        $this->identity = new IdentityHelper();
        $this->ummu = new UmmuPmJobtype();
        $this->umHelp = new UmmuHelper();
    }

    public function show($id = null)
    {
        // $payload = [
        //     "limit" => 10,
        //     "offset" => 0,
        //     "sort" => "id",
        //     "order" => "desc",
        //     "search" => "",
        //     "selects" => "*"
        // ];

        // $params = [
        //     "id" => $id,
        //     "payload" => $payload,
        //     "token" => $this->reqH->myToken()
        // ];

        // $builder = $this->ummu->show($params);
        // return $builder;
        return $this->show_from_openapi2($id);
    }

    public function show_from_openapi2($id)
    {
        $payload = $this->umHelp->filter_payload();

        // $payload = array_merge($payload, [
        //     "date" => [
        //         "from" => "",
        //         "to" => ""
        //     ]
        // ]);

        $params = [
            "id" => $id,
            "payload" => $payload,
            "token" => $this->identity->c04_token()
        ];

        $builder = $this->ummu->show($params);
        return $builder;
    }
}