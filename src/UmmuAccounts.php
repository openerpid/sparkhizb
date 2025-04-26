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

class UmmuAccounts
{
    public function __construct()
    {
        $this->curli = new Curl();
        $this->module_code = 'accounts';
    }

    public function show($params)
    {
        $id = $params['id'];
        $payload = $params['payload'];
        $token = $params['token'];
        
        if ($id) {
            $path = "api/accounts/show/" . $id;
        }else{
            $path = "api/accounts/show";
        }

        $params = [
            "path"           => $path,
            "method"         => "GET",
            "payload"        => $payload,
            "module_code"    => $this->module_code,
            "token"          => $token
        ];

        $response = $this->curli->request3($params);

        return json_decode($response, false);
    }

    public function show_roles($params)
    {
        $payload = $params['payload'];
        $token = $params['token'];
        
        $path = "api/accounts/show_roles";

        $params = [
            "path"           => $path,
            "method"         => "GET",
            "payload"        => $payload,
            "module_code"    => $this->module_code,
            "token"          => $token
        ];

        $response = $this->curli->request3($params);

        return json_decode($response, false);
    }

    // public function create($params)
    // {
    //     $payload = $params['payload'];
    //     $token = $params['token'];
    //     $path = "api/server/otp/create";

    //     $params = [
    //         "path"           => $path,
    //         "method"         => "POST",
    //         "payload"        => $payload,
    //         "module_code"    => "otp_kode",
    //         "token"          => $token
    //     ];

    //     $response = $this->curli->request3($params);

    //     return json_decode($response, false);
    // }

    // public function create($params)
    // {
    //     $payload = $params['payload'];
    //     $token = $params['token'];
    //     $path = "api/server/otp/confirm";

    //     $params = [
    //         "path"           => $path,
    //         "method"         => "PUT",
    //         "payload"        => $payload,
    //         "module_code"    => "otp_kode",
    //         "token"          => $token
    //     ];

    //     $response = $this->curli->request3($params);

    //     return json_decode($response, false);
    // }
}
