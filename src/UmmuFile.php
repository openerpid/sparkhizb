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

class UmmuFile
{
    public function __construct()
    {
        $this->curli = new Curl();
    }

    public function show($params)
    {
        // 
    }

    public function excel_to_array($params)
    {
        $response = $this->curli->form(
            [
                "path"           => "api/lib/file/excel_to_array",
                "method"         => "POST",
                "payload"        => $params['payload'],
                "module_code"    => "lib__excel_to_array",
                "token"          => $params['token']
            ]
        );

        return json_decode($response, false);
    }
}
