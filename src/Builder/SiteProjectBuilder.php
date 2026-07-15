<?php

namespace Sparkhizb\Builder;

use Dorbitt\Helpers\Curl;
use Dorbitt\Helpers\UmmuHelper;

use App\Helpers\CurlHelper;

class SiteProjectBuilder
{
    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->curl = new Curl();
        $this->cH = new CurlHelper();
        $this->umHelp = new UmmuHelper();
    }

    public function show_with_select($select)
    {
        $payload = $this->umHelp->dt_payload2();
        $payload = array_merge($payload, [
            "selects" => $select
        ]);

        $params = [
            "url" => $this->cH->url() . 'master/site_project/show',
            "method" => 'GET',
            "payload" => $payload,
            "headers" => $this->cH->headers2()
        ];
        $builder = $this->curl->ummu($params);

        return $builder;
    }

    public function show($id = null)
    {
        $payload = $this->umHelp->dt_payload2();
        $payload = array_merge($payload, [
            "date" => [
                "from" => "",
                "to" => ""
            ],
            // "release" => $release,
            // "where" => ["nikaryawan" => "10230070"]
            "selects" => "*"
        ]);

        $params = [
            "url" => $this->cH->url() . 'master/site_project/show',
            "method" => 'GET',
            "payload" => $payload,
            "headers" => $this->cH->headers2()
        ];
        $builder = $this->curl->ummu($params);

        return $builder;
    }

    public function showDync($selects)
    {
        $payload = $this->umHelp->dt_payload2();
        $payload = array_merge($payload, [
            "limit" => 0,
            "date" => [
                "from" => "",
                "to" => ""
            ],
            "selects" => $selects
        ]);

        $params = [
            "url" => $this->cH->url() . 'master/site_project/show',
            "method" => 'GET',
            "payload" => $payload,
            "headers" => $this->cH->headers()
        ];
        $builder = $this->curl->ummu($params);

        return $builder;
    }

    public function show_mail_cc($id = null)
    {
        $payload = $this->umHelp->dt_payload2();
        $payload = array_merge($payload, [
            "date" => [
                "from" => "",
                "to" => ""
            ],
            // "release" => $release,
            // "where" => ["nikaryawan" => "10230070"]
            "selects" => "region_code,region_name,cc_email"
        ]);

        $params = [
            "url" => $this->cH->url() . 'master/site_project/show',
            "method" => 'GET',
            "payload" => $payload,
            "headers" => $this->cH->headers2()
        ];
        $builder = $this->curl->ummu($params);

        return $builder;
    }

    public function show_from_openintegrasi_by_kdsite($kdsite)
    {
        $payload = [
            "limit" => 10,
            "offset" => 0,
            "sort" => "id",
            "order" => "desc",
            "search" => $kdsite,
        ];
        $params = [
            "url" => $this->cH->url() . 'master/site_project/show_from_openintegrasi',
            "method" => 'GET',
            "payload" => $payload,
            "headers" => $this->cH->headers2()
        ];
        $builder = $this->curl->ummu($params);

        return $builder;
    }

    public function show_from_openintegrasi_by_kdsite_for_login($kdsite)
    {
        $payload = [
            "limit" => 10,
            "offset" => 0,
            "sort" => "id",
            "order" => "desc",
            "search" => $kdsite,
        ];
        $params = [
            "url" => $this->cH->url() . 'master/site_project/show_from_openintegrasi',
            "method" => 'GET',
            "payload" => $payload,
            "headers" => $this->cH->headers_login()
        ];
        $builder = $this->curl->ummu($params);

        return $builder;
    }

    public function update($id, $payload)
    {
        $params = [
            "url" => $this->cH->url() . 'master/site_project/update/' . $id,
            "method" => 'PUT',
            "payload" => $payload,
            "headers" => $this->cH->headers2()
        ];

        return $this->curl->ummu($params);
    }
}