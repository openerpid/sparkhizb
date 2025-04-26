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

class UmmuEventManagement
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
            $path = "api/event_registration/show/" . $id;
        }else{
            $path = "api/event_registration/show";
        }

        $params = [
            "path"           => $path,
            "method"         => "GET",
            "payload"        => $payload,
            "module_code"    => "event_registration",
            "token"          => $token
        ];

        $response = $this->curli->request3($params);

        return json_decode($response, false);
    }

    public function insert_web($params)
    {
        $params = [
            "path"           => "event_registration/create",
            "method"         => "POST",
            "payload"        => $params['payload'],
            "headers"        => array(
                'Content-Type: application/json',
                'Module-Code: event_registration',
                'Company-Token: ' . $params['company_token'],
                'Authorization: Bearer ' . $params['token']
            )
        ];

        $response = $this->curli->ummu2($params);

        return $response;
    }
}
