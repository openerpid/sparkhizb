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

class SiteProject
{
    public static function show($params)
    {
        $id = $params['id'];
        $payload = $params['payload'];
        $token = $params['token'];
        
        if ($id) {
            $path = "api/site_project/show/" . $id;
        }else{
            $path = "api/site_project/show";
        }

        $params = [
            "path"           => $path,
            "method"         => "GET",
            "payload"        => $payload,
            "module_code"    => "site_project",
            "token"          => $token
        ];

        $response = Curl::request($params);

        return json_decode($response, false);
    }

    public static function create($payload, $token = null)
    {
        $params = [
            "path"           => "api/site_project/create",
            "method"         => "POST",
            "payload"        => $payload,
            "module_code"    => "site_project",
            "token"          => $token
        ];

        $response = Curl::request($params);

        return json_decode($response, false);
    }
}
