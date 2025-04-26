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

class UmmuVisitor
{
    public function __construct()
    {
        $this->curli = new Curl();
    }

    public function show($params)
    {
        $id = $params['id'];
                
        if ($id) {
            $id = "/" . $id;
        }else{
            $id = "";
        }

        $params = [
            "path"           => "api/event_management/visitor/show" . $id,
            "method"         => "GET",
            "payload"        => $params['payload'],
            "module_code"    => "visitor",
            "token"          => $params['token']
        ];

        $response = $this->curli->request4($params);

        return json_decode($response, false);
    }

    public function create($params)
    {
        $params = [
            "path"           => "api/event_management/visitor/create",
            "method"         => "POST",
            "payload"        => $params['payload'],
            "module_code"    => "visitor",
            "token"          => $params['token']
        ];

        $response = $this->curli->request4($params);

        return json_decode($response, false);
    }
}
