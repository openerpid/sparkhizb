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

use Sparkhizb\Helpers\Curl;

class Mailer
{
    public function __construct()
    {
        $this->curli = new Curl();
    }

    public function send($payload = null, $token = null)
    {
        $url = "api/lib/email/send";
        $method = "POST";
        $module_code = "email";

        $request = $this->curli->request($url,$method,$payload,$module_code,$token);

        return json_decode($request, false);
    }

    public function dorbitt_send($payload = null, $token = null)
    {
        $url = "api/lib/email/dorbitt_send";
        $method = "POST";
        $module_code = "email";

        $request = $this->curli->request($url,$method,$payload,$module_code,$token);

        return json_decode($request, false);
    }

    public function with_create_pdf_by_url($payload = null, $token = null)
    {
        $url = "api/lib/email/with_create_pdf_by_url";
        $method = "POST";
        $module_code = "email";

        $request = $this->curli->request($url,$method,$payload,$module_code,$token);
        return json_decode($request, false);
    }

    public function with_filepath_from_response($payload = null, $token = null)
    {
        $url = "api/lib/email/with_filepath_from_response";
        $method = "POST";
        $module_code = "email";

        $request = $this->curli->request($url,$method,$payload,$module_code,$token);
        return json_decode($request, false);
    }
}
