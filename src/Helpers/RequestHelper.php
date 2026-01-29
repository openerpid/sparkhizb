<?php

namespace Sparkhizb\Helpers;

/**
 * =============================================
 * Author: Ummu
 * Website: https://ummukhairiyahyusna.com/
 * App: Sparkhizb LIB
 * Description: 
 * =============================================
 */

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Sparkhizb\Helpers\JwtHelper;

class RequestHelper
{
    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->jwt = new JwtHelper();
    }

    public function page_header($data_page, $page)
    {
        $page_header = "404 Error";

        // $data_page = [
        //     "contact" => "Contact",
        //     "gallery" => "Gallery",
        //     "certificate" => "Certificate"
        // ];

        if ($data_page) {
            foreach ($data_page as $key => $value) {
                if ($key == $page) {
                    $page_header = $value;
                }
            }
        }

        return $page_header;
    }

    public function is_jsonVar()
    {
        $getJsonVar = $this->request->getJsonVar();
        $getVar = $this->request->getVar();

        if ($getJsonVar == null) {
            return false;
        } else {
            return true;
        }
    }

    public function ssl_options()
    {
        $ssl_option = $this->request->header("Ssl-Option");
        if ($ssl_option) {
            $ssl_option = $ssl_option->getValue();
        } else {
            $ssl_option = null;
        }

        return $ssl_option;
    }

    public function myToken()
    {
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) {
            $token = null;
        } else {
            $token = explode(' ', $header)[1];
        }

        return $token;
    }

    public function is_ajax()
    {
        $a = $this->request->header("X-Requested-With");
        $a = $a->getValue();

        if ($a == 'XMLHttpRequest') {
            return true;
        } else {
            return false;
        }
    }

    public function isAjax_datatables()
    {
        if ($this->request->isAJAX()) {
            $a = $this->request->header("Ajax-Vendor");
            if ($a) {
                $a = $a->getValue();
            }

            if ($a == 'datatables') {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function payloadStd()
    {
        $ids = $this->request->getJsonVar("ids");

        $limit = $this->request->getJsonVar("limit");
        if (!$limit) {
            $limit = 10;
        }

        $offset = $this->request->getJsonVar("offset");
        if (!$offset) {
            $offset = 0;
        }

        $sort = $this->request->getJsonVar("sort");
        if (!$sort) {
            $sort = "id";
        }

        $order = $this->request->getJsonVar("order");
        if (!$order) {
            $order = "desc";
        }

        $release = $this->request->getJsonVar("release");
        $nomor_dokumen = $this->request->getJsonVar("nomor_dokumen");

        $search = $this->request->getJsonVar("search");
        $filter = $this->request->getJsonVar("filter");
        $filter_type = $this->request->getJsonVar("filter_type");
        $anywhere = $this->request->getJsonVar("anywhere");
        $isTesting_active = $this->request->getJsonVar("isTesting_active");
        $selects = $this->request->getJsonVar("selects");

        $payload = [
            "ids" => $ids,
            "limit" => $limit,
            "offset" => $offset,
            "sort" => $sort,
            "order" => $order,
            "search" => $search,
            "filter" => $filter,
            "filter_type" => $filter_type,
            "anywhere" => $anywhere,
            "isTesting_active" => $isTesting_active,
            "selects" => $selects
        ];

        return $payload;
    }

    public function companyToken()
    {
        $company_token = $this->request->header("Company-Token");

        if ($company_token) {
            $company_token = $company_token->getValue();

            return $company_token;
        }
    }

    public function companyTokenDecode()
    {
        $company_token = $this->request->header("Company-Token");

        if ($company_token) {
            $company_token = $company_token->getValue();

            $decode = $this->jwt->decode($company_token);

            return $decode;
        }
    }
}
