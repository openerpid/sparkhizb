<?php

namespace Sparkhizb\Helpers;

use Sparkhizb\Auth;
use Sparkhizb\Helpers\JwtHelper;
use Sparkhizb\Helpers\RequestHelper;
use Dorbitt\UmmuProfile;

class PrivilegeHelper 
{
    public function __construct()
    {
        $this->jwt = new JwtHelper();
        $this->request = \Config\Services::request();
        $this->auth = new Auth();
        $this->umProfile = new UmmuProfile();
        $this->reqH = new RequestHelper();
    }

    public function module_priv_oa2($module_kode)
    {
        $payload = [
            "module_kode" => $module_kode
        ];

        $params = [
            "id" => null,
            "payload" => $payload,
            "token" => $this->reqH->myToken()
        ];

        $builder = $this->umProfile->module_privileges($params);

        return $builder;
    }
}