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

class Master
{
    public function __construct()
    {
        $this->curli = new Curl();
    }

    public function site_project($payload = null, $token = null)
    {

        $url = "api/master/site_project/show";
        $method = "GET";
        $module_code = "site_project";

        $create = $this->curli->request($url,$method,$payload,$module_code,$token);

        return json_decode($create, false);
    }
}
