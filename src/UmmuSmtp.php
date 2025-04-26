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

class UmmuSmtp
{
    public function __construct()
    {
        $this->curli = new Curl();
    }

    public function show($params)
    {
        $id = $params['id'];
        $payload = $params['payload'];
        $token = $params['token'];
        
        if ($id) {
            $path = "api/smtp/show/" . $id;
        }else{
            $path = "api/smtp/show";
        }

        $params = [
            "path"           => $path,
            "method"         => "GET",
            "payload"        => $payload,
            "module_code"    => "smtp",
            "token"          => $token
        ];

        $response = $this->curli->request3($params);

        return json_decode($response, false);
    }

    public function show_upload($params)
    {
        $payload = $params['payload'];
        $token = $params['token'];
        $path = "api/smtp/show_upload";

        $params = [
            "path"           => $path,
            "method"         => "GET",
            "payload"        => $payload,
            "module_code"    => "smtp",
            "token"          => $token
        ];

        $response = $this->curli->request3($params);

        return json_decode($response, false);
    }
}
