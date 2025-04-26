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

class UmmuRef
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
            $path = "api/referensi/getAll/" . $id;
        }else{
            $path = "api/referensi/getAll";
        }

        $params = [
            "path"           => $path,
            "method"         => "GET",
            "payload"        => $payload,
            "module_code"    => "referensi",
            "token"          => $token
        ];

        $response = $this->curli->request3($params);

        return json_decode($response, false);
    }

    public function provinces($params)
    {
        $response = $this->curli->request4(
            [
                "path"           => "api/referensi/wilayah_indonesia/provinces",
                "method"         => "POST",
                "payload"        => $params['payload'],
                "module_code"    => "ref_wilayah_indonesia",
                "token"          => $params['token']
            ]
        );

        return json_decode($response, false);
    }

    public function regencies($params)
    {
        $response = $this->curli->request4(
            [
                "path"           => "api/referensi/wilayah_indonesia/regencies",
                "method"         => "POST",
                "payload"        => $params['payload'],
                "module_code"    => "ref_wilayah_indonesia",
                "token"          => $params['token']
            ]
        );

        return json_decode($response, false);
    }
}
