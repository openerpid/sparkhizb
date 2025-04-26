<?php

namespace Sparkhizb\Artisan;

/**
* =============================================
* Author: Ummu
* Website: https://ummukhairiyahyusna.com/
* App: DORBITT LIB
* Description: 
* =============================================
*/

use Sparkhizb\Artisan\Curl;

class Inquiries
{
    public static function show($id = null, $payload = null, $token = null)
    {
        if ($id) {
            $path = "api/crm/inquiries/show/" . $id;
        }else{
            $path = "api/crm/inquiries/show";
        }

        $params = [
            "path"           => $path,
            "method"         => "GET",
            "payload"        => $payload,
            "module_code"    => "crm_inquiries",
            "token"          => $token
        ];

        $response = Curl::request($params);

        return json_decode($response, false);
    }

    public static function create($payload, $token = null)
    {
        $params = [
            "path"           => "api/crm/inquiries/create",
            "method"         => "POST",
            "payload"        => $payload,
            "module_code"    => "crm_inquiries",
            "token"          => $token
        ];

        $response = Curl::request($params);

        return json_decode($response, false);
    }
}
