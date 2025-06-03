<?php

namespace Sparkhizb\Helpers;

use Sparkhizb\Helpers\JwtHelper;
use Sparkhizb\Auth;

class IdentityHelper 
{
    public function __construct()
    {
        $this->jwt = new JwtHelper();
        $this->request = \Config\Services::request();
        $this->auth = new Auth();
    }

    public function company_id()
    {
        return $this->jwt->decode()->company_id;
    }

    public function role()
    {
        if (isset($this->jwt->decode()->role_name)) {
            return $this->jwt->decode()->role_name;
        }

        if (isset($this->jwt->decode()->role)) {
            return $this->jwt->decode()->role;
        }
    }

    public function role_id()
    {
        return $this->jwt->decode()->role_id;
    }

    public function level_id()
    {
        return $this->jwt->decode()->level_id;
    }

    public function company_name()
    {
        return $this->jwt->decode()->company;
    }

    public function company_kode()
    {
        return $this->jwt->decode()->company_kode;
    }

    public function account_id()
    {
        return $this->jwt->decode()->id;
    }

    // public function account_id()
    // {
    //     $crud = explode(',', $this->crud());
    //     if ($crud AND $crud[2] == 1) {
    //         return $this->jwt->decode()->id;
    //     }else{
    //         return null;
    //     }
    // }

    public function user_id()
    {
        return $this->jwt->decode()->user_id;
    }

    public function username()
    {
        return $this->jwt->decode()->username;
    }

    public function name()
    {
        return $this->jwt->decode()->name;
    }

    public function identity_id()
    {
        return $this->jwt->decode()->identity_id;
    }

    public function insert($params)
    {
        $payload = [
            "company_id"    => $this->company_id(),
            "created_by"    => $this->account_id()
        ];

        $payload = array_merge($payload,$params);

        return $payload;
    }

    public function update($params)
    {
        $payload = [
            "updated_by" => $this->account_id()
        ];

        $payload = array_merge($payload,$params);

        return $payload;
    }

    public function payload($crud, $params)
    {
        if ($crud == 'create') {
            $payload = [
                "company_id"    => $this->company_id(),
                "created_by"    => $this->account_id()
            ];
        }elseif ($crud == 'update') {
            $payload = [
                "updated_by" => $this->account_id()
            ];
        }else{
            $payload = [
                "deleted_by" => $this->account_id()
            ];
        }

        $payload = array_merge($payload, $params);

        return $payload;
    }

    public function company_token()
    {
        $company_token = $this->request->header("Company-Token");
        if ($company_token) {
           return $company_token->getValue();
        }
    }

    public function company_token_decode()
    {
        $company_token = $this->request->header("Company-Token");
        if ($company_token) {
            $company_token = $company_token->getValue();

            $decode = $this->jwt->decode($company_token);
            return $decode;
        }
    }

    public function crud()
    {
        $moduleCode = $this->request->header("Module-Code");
        $moduleCode = $moduleCode->getValue();
        $enmod = $this->jwt->decode()->module_enabled;

        $crud = [];
        foreach ($enmod as $key => $value) {
            $kode = $value->kode;

            if ($kode === $moduleCode) {
                $crud = explode(',', $value->crud);
            }
        }

        return $crud;
    }

    private function login()
    {
        $params = [
            "payload" => [
                "username" => getenv('openerp.username'),
                "password" => getenv('openerp.password')
            ],
            "headers" => [
                "Content-Type:application/json"
            ]
        ];

        return $this->auth->login2($params);
    }

    public function login_token()
    {
        $a = $this->login();

        if ($a->status == true) {
            $token = $a->data->token;
        }else{
            $token = '';
        }

        return $token;
    }

    private function static_login()
    {
        $params = [
            "payload" => [
                "username" => getenv('openerp.username'),
                "password" => getenv('openerp.password')
            ],
            "headers" => [
                "Content-Type:application/json"
            ]
        ];

        return $this->auth->login2($params);
    }

    public function token_static_login()
    {
        $a = $this->static_login();

        if ($a->status == true) {
            $token = $a->data->token;
        }else{
            $token = '';
        }

        return $token;
    }

    public function c04_project_area_kode()
    {
        return $this->jwt->decode()->project_area->region_code;
    }
}