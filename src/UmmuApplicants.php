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

use Sparkhizb\Helpers\CurlHelper;
use Sparkhizb\Helpers\UmmuHelper;
use Sparkhizb\Helpers\GlobalHelper;

class UmmuApplicants
{
    public function __construct()
    {
        $this->kode = "hcm_applicants";
        $this->curli = new CurlHelper();
        $this->gHelp = new GlobalHelper();
        $this->path = 'api/hcm/applicants/';
    }

    public function show($params)
    {
        $response = $this->curli->request4(
            [
                "path"           => $this->path . "show",
                "method"         => "GET",
                "payload"        => $params['payload'],
                "module_code"    => $this->kode,
                "token"          => $params['token']
            ]
        );

        return json_decode($response, false);
    }

    public function update($params)
    {
        $id = $params['id'];

        $response = $this->curli->request4(
            [
                "path"           => $this->path. "update/". $id,
                "method"         => "PUT",
                "payload"        => $params['payload'],
                "module_code"    => $this->kode,
                "token"          => $params['token']
            ]
        );

        return json_decode($response, false);
    }

    public function update_status($params)
    {
        $response = $this->curli->request4(
            [
                "path"           => $this->path. "update_status",
                "method"         => "PUT",
                "payload"        => $params['payload'],
                "module_code"    => $this->kode,
                "token"          => $params['token']
            ]
        );

        return json_decode($response, false);
    }
}
