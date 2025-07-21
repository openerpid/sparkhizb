<?php

namespace Sparkhizb;

/**
* =============================================
* Author: Ummu
* Website: https://ummukhairiyahyusna.com/
* App: DORBITT LIB
* Description: 
* =============================================
*/

use Sparkhizb\Helpers\CurlHelper;
use Sparkhizb\Helpers\UmmuHelper;
use Sparkhizb\Helpers\GlobalHelper;

class UmmuInvestigation
{
    public function __construct()
    {
        $this->curli = new CurlHelper();
        $this->gHelp = new GlobalHelper();

        $this->kode = "she_investigation";
        $this->path = 'api/she/investigation/';
    }

    public function show_created_by_name($params)
    {
        $params = [
            "path"           => $this->path . "show_created_by_name/". $params["id"],
            "method"         => "GET",
            "payload"        => $params['payload'],
            "module_code"    => $this->kode,
            "token"          => $params['token']
        ];
            
        $response = $this->curli->request4($params);

        return json_decode($response, false);
    }

    public function approval_queue($params)
    {
        $response = $this->curli->request4(
            [
                "path"           => $this->path. "approval_queue",
                "method"         => "GET",
                "payload"        => $params['payload'],
                "module_code"    => $this->kode,
                "token"          => $params['token']
            ]
        );

        return json_decode($response, false);
    }

    public function show_approval($params)
    {
        $response = $this->curli->request4(
            [
                "path"           => $this->path. "show_approval",
                "method"         => "GET",
                "payload"        => $params['payload'],
                "module_code"    => $this->kode,
                "token"          => $params['token']
            ]
        );

        return json_decode($response, false);
    }


    public function approval_show_doc_queue($params)
    {
        $response = $this->curli->request4(
            [
                "path"           => $this->path. "approval_show_doc_queue",
                "method"         => "GET",
                "payload"        => $params['payload'],
                "module_code"    => $this->kode,
                "token"          => $params['token']
            ]
        );

        return json_decode($response, false);
    }

    public function approval_approve_doc_queue($params)
    {
        $response = $this->curli->request4(
            [
                "path"           => $this->path. "approval_approve_doc_queue",
                "method"         => "POST",
                "payload"        => $params['payload'],
                "module_code"    => $this->kode,
                "token"          => $params['token']
            ]
        );

        return json_decode($response, false);
    }

}
