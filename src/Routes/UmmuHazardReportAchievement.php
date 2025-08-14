<?php

namespace Sparkhizb\Routes;

/**
* =============================================
* Author: Ummu
* Website: https://ummukhairiyahyusna.com/
* App: Sparkhizb LIB
* Description: 
* =============================================
*/

use Sparkhizb\Helpers\Curl;
use Sparkhizb\Helpers\GlobalHelper;

class UmmuHazardReportAchievement
{
    public function __construct()
    {
        $this->curli = new Curl();
        $this->gHelp = new GlobalHelper();
        $this->urli = 'api/she/hazard_report_achievement/';
    }

    public function show($params)
    {
        $response = $this->curli->request4(
            [
                "path"           => $this->urli . "show",
                "method"         => "GET",
                "payload"        => $params['payload'],
                "module_code"    => "she_hazard_report_achievement",
                "token"          => $params['token']
            ]
        );

        return json_decode($response, false);
    }
}
