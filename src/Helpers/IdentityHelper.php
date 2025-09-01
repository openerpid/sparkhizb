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
        if(isset($this->jwt->decode()->company_id)) {
            $company_id = $this->jwt->decode()->company_id;
        }else{
            $company_id = null;
        }

        return $company_id;
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
        if(isset($this->jwt->decode()->id)) {
            $id = $this->jwt->decode()->id;
        }else{
            $id = null;
        }
        
        return $id;
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
        // $params = [
        //     "payload" => [
        //         "username" => getenv('openapi2.username'),
        //         "password" => getenv('openapi2.password')
        //     ],
        //     "headers" => [
        //         "Content-Type:application/json"
        //     ]
        // ];

        // return $this->auth->login2($params);

        return getenv('openapi2.token');
    }

    public function login_token()
    {
        $token = getenv('openapi2.token');
        // $a = $this->login();

        // if ($a->status == true) {
        //     $token = $a->data->token;
        // }else{
        //     $token = '';
        // }

        return $token;
    }

    public function token_openapi2()
    {
        $token = getenv('openapi2.token');
        // $a = $this->login();

        // if ($a->status == true) {
        //     $token = $a->data->token;
        // }else{
        //     $token = '';
        // }

        return $token;
    }

    private function static_login()
    {
        // $params = [
        //     "payload" => [
        //         "username" => getenv('openapi2.username'),
        //         "password" => getenv('openapi2.password')
        //     ],
        //     "headers" => [
        //         "Content-Type:application/json"
        //     ]
        // ];

        // return $this->auth->login2($params);
        return getenv('openapi2.token');
    }

    public function token_static_login()
    {
        $token = getenv('openapi2.token');
        // $a = $this->static_login();

        // if ($a->status == true) {
        //     $token = $a->data->token;
        // }else{
        //     $token = '';
        // }

        return $token;
    }

    public function c04_project_area_kode()
    {
        return $this->jwt->decode()->project_area->region_code;
    }

    public function c04_token()
    {
        if(isset($this->jwt->decode()->c04) and $this->jwt->decode()->c04 == true) {
            $token = $this->login_token();
        }else{
            $token = $this->jwt->token();
        }

        return $token;
    }

    public function openapi2_autoken()
    {
        $token = $this->jwt->token();

        if(isset($this->jwt->decode()->vendor)) {
            if ($this->jwt->decode()->vendor == 'syshab') {
                /*maka, token-nya menggunakan hasil login ke openapi2 dengan username dan password yg sudah ditentukan di .env*/
                $token = $this->login_token();
            }
        }

        return $token;
    }

    public function user_access()
    {
        return $this->jwt->decode()->user_access;
    }

    public function vendor()
    {
        if(isset($this->jwt->decode()->vendor)) {
            $data = $this->jwt->decode()->vendor;
        }else{
            $data = $this->jwt->decode()->vendor;
        }

        return $data;
    }

    public function KdSite()
    {
        if(isset($this->jwt->decode()->employee->KdSite)) {
            $text = $this->jwt->decode()->employee->KdSite;
        }else{
            $text = null;
        }

        return $text;
    }

    public function enmod()
    {
        return $this->jwt->decode()->module_enabled;
    }

    public function modulePrivilege($module_kode)
    {
        $enmod = $this->jwt->decode()->module_enabled;
        $crud_name = [];

        foreach ($enmod as $key => $value) {
            if ($value->kode == $module_kode) {
                $crud_name = $value->crud_name;
            }
        }

        return $crud_name;
    }
}