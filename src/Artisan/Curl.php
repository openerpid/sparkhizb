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

class Curl
{
    public static function request($params)
    {
        $path           = $params['path'];
        $method         = $params['method'];
        $payload        = $params['payload'];
        $module_code    = $params['module_code'];

        if (env("CI_DORBITT")=="testing") {
            $url = "http://localhost:8080/" . $path;
        }else{
            $url = "https://api.dorbitt.com/" . $path;
        }

        if (env("DORBITT_TOKEN")) {
            $token = env("DORBITT_TOKEN");
        }else{
            $token = $params['token'];
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Module-Code: '. $module_code,
                'Authorization: Bearer ' . $token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }

    public static function token()
    {
        return end('DORBITT_TOKEN');
    }
}
