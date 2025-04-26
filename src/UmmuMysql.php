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

class UmmuMysql
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
            $path = "api/server/mysql/show/" . $id;
        }else{
            $path = "api/server/mysql/show";
        }

        $params = [
            "path"           => $path,
            "method"         => "GET",
            "payload"        => $payload,
            "module_code"    => "mysql",
            "token"          => $token
        ];

        $response = $this->curli->request3($params);

        return json_decode($response, false);
    }

    public function create($params)
    {
        $payload = $params['payload'];
        $token = $params['token'];
        
        $path = "api/server/mysql/create";

        $params = [
            "path"           => $path,
            "method"         => "POST",
            "payload"        => $payload,
            "module_code"    => "mysql",
            "token"          => $token
        ];

        $response = $this->curli->request3($params);

        return json_decode($response, false);
    }

    public function delete($params)
    {
        if (isset($params['id'])) {
            $id = $params['id'];
        }else{
            $id = null;
        }
        
        $payload = $params['payload'];
        $token = $params['token'];
        
        if ($id) {
            $path = "api/server/mysql/delete/" . $id;
        }else{
            $path = "api/server/mysql/delete";
        }
        
        $params = [
            "path"           => $path,
            "method"         => "DELETE",
            "payload"        => $payload,
            "module_code"    => "mysql",
            "token"          => $token
        ];

        $response = $this->curli->request3($params);

        return json_decode($response, false);
    }
}
