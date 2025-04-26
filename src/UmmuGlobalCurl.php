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

class UmmuGlobalCurl
{
    public function __construct()
    {
        // 
    }

    public function ailee($params)
    {
        $path           = $params['path'];
        $method         = $params['method'];
        $payload        = $params['payload'];
        $headers        = $params['headers'];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->url . $path,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => $headers,
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response, false);
    }
}
