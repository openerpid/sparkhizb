<?php

namespace Sparkhizb;

/**
* =============================================
* Author: Ummu
* Website: https://ummukhairiyahyusna.com/
* App: Sparkhizb LIB
* Description: 
* =============================================
*/

use Sparkhizb\Helpers\Curl;

class Employee
{
    public function __construct()
    {
        $this->curli = new Curl();
    }

    public function show($params)
    {
        // $id = $params['id'];
        // $payload = $params['payload'];
        // $token = $params['token'];
        
        // if ($id) {
        //     $path = "api/site_project/show/" . $id;
        // }else{
        //     $path = "api/site_project/show";
        // }

        // $params = [
        //     "url"            => $path,
        //     "path"           => $path,
        //     "method"         => "GET",
        //     "payload"        => $payload,
        //     "module_code"    => "site_project",
        //     "token"          => $token
        // ];

        // $response = $this->curli->request2($params);

        // return json_decode($response, false);
    }

    public function show_from_sap($params)
    {
        $payload = $params['payload'];
        $token = $params['token'];
        $path = "api/hcm/employee/show_from_sap";

        $params = [
            "path"           => $path,
            "method"         => "GET",
            "payload"        => $payload,
            "module_code"    => "employee",
            "token"          => $token
        ];

        $response = $this->curli->request3($params);

        return json_decode($response, false);
    }
}
