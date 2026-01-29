<?php

namespace Sparkhizb\Builder;

use Dorbitt\Helpers\Curl;
use Dorbitt\Helpers\IescmHelper;

class EmployeeBuilder
{
    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->curl = new Curl();
        $this->iH = new IescmHelper();
    }

    public function show($payload)
    {
        $params = [
            "url" => $this->iH->url() . 'master/employee/show',
            "method" => 'GET',
            "payload" => $payload,
            "headers" => $this->iH->headers()
        ];
        $builder = $this->curl->ummu($params);

        return $builder;
    }

    public function show_by_nik($nik)
    {
        $payload = [
            "limit" => 0,
            "offset" => 0,
            "sort" => "id",
            "order" => "desc",
            "search" => "",
            "nik" => $nik,
        ];

        $params = [
            "url" => $this->iH->url() . 'master/employee/show',
            "method" => 'GET',
            "payload" => $payload,
            "headers" => $this->iH->headers()
        ];
        $builder = $this->curl->ummu($params);

        return $builder;
    }

    public function show_by_nik_for_login($nik, $msdb_token = null)
    {
        $payload = [
            "limit" => 0,
            "offset" => 0,
            "sort" => "id",
            "order" => "desc",
            "search" => "",
            "nik" => $nik,
        ];

        $params = [
            "url" => $this->iH->url() . 'master/employee/show_for_login',
            "method" => 'GET',
            "payload" => $payload,
            "headers" => $this->iH->headers_login($msdb_token)
        ];
        $builder = $this->curl->ummu($params);

        return $builder;
    }

    public function show_by_nik_with_selects($nik, $selects)
    {
        $payload = [
            "limit" => 0,
            "offset" => 0,
            "sort" => "Nama",
            "order" => "asc",
            "search" => "",
            "nik" => $nik,
            "selects" => $selects
        ];

        $params = [
            "url" => $this->iH->url() . 'master/employee/show',
            "method" => 'GET',
            "payload" => $payload,
            "headers" => $this->iH->headers()
        ];
        $builder = $this->curl->ummu($params);

        return $builder;
    }

    // public function show_by_nik_with_selects_with_search($nik, $selects)
    // {
    //     $payload = [
    //         "limit" => 0,
    //         "offset" => 0,
    //         "sort" => "Nama",
    //         "order" => "asc",
    //         "search" => $this->request->getVar('search'),
    //         "nik" => $nik,
    //         "selects" => $selects
    //     ];

    //     $params = [
    //         "url" => $this->iH->url() . 'master/employee/show',
    //         "method" => 'GET',
    //         "payload" => $payload,
    //         "headers" => $this->iH->headers()
    //     ];
    //     $builder = $this->curl->ummu($params);

    //     return $builder;
    // }

    public function show_affiliation()
    {
        $payload = [
            "limit" => 0,
            "offset" => 0,
            "sort" => "id",
            "order" => "desc",
            "search" => "",
            "date" => [
                "from" => "",
                "to" => ""
            ],
            // "user"      => session()->get('username'),
            // "status"    => [
            //     "outstanding"
            // ],
            // "type_doc"  => "UR"
        ];

        $params = [
            "url" => $this->iH->url() . 'supplier/show_affiliation',
            "method" => 'GET',
            "payload" => $payload,
            "headers" => $this->iH->headers()
        ];

        $builder = $this->curl->ummu($params);

        return $builder;
    }
}