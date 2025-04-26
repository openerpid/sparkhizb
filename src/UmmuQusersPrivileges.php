<?php

namespace Sparkhizb;

/**
* =============================================
* Author: Ummu Khairiyah Yusna
* Website: https://ummukhairiyahyusna.com/
* App: Sparkhizb LIB
* Description: 
* =============================================
*/

use Sparkhizb\Curl\Curl;

class UmmuQusersPrivileges
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
            $path = "api/config/users_privileges/show/" . $id;
        }else{
            $path = "api/config/users_privileges/show";
        }

        $params = [
            "path"           => $path,
            "method"         => "GET",
            "payload"        => $payload,
            "module_code"    => "users_privileges",
            "token"          => $token
        ];

        $response = $this->curli->request3($params);

        return json_decode($response, false);
    }

    public function show_modules($params)
    {
        // $payload = $params['payload'];
        // $token = $params['token'];
        
        // $path = "api/config/users_privileges/show_gallery";

        // $params = [
        //     "path"           => $path,
        //     "method"         => "GET",
        //     "payload"        => $payload,
        //     "module_code"    => "users_privileges",
        //     "token"          => $token
        // ];

        // $response = $this->curli->request3($params);

        // return json_decode($response, false);
    }

    public function insert($params)
    {
        $payload = $params['payload'];
        $token = $params['token'];
        
        $path = "api/config/users_privileges/create";

        $params = [
            "path"           => $path,
            "method"         => "POST",
            "payload"        => $payload,
            "module_code"    => "users_privileges",
            "token"          => $token
        ];

        $response = $this->curli->request3($params);

        return json_decode($response, false);
    }

    public function update($params)
    {
        $id = $params['id'];
        $payload = $params['payload'];
        $token = $params['token'];
        
        $path = "api/config/users_privileges/update/" . $id;

        $params = [
            "path"           => $path,
            "method"         => "PUT",
            "payload"        => $payload,
            "module_code"    => "users_privileges",
            "token"          => $token
        ];

        $response = $this->curli->request3($params);

        return json_decode($response, false);
    }

    public function delete($params)
    {
        $id = $params['id'];
        $payload = $params['payload'];
        $token = $params['token'];
        
        if ($id) {
            $path = "api/config/users_privileges/delete/" . $id;
        }else{
            $path = "api/config/users_privileges/delete";
        }

        $params = [
            "path"           => $path,
            "method"         => "DELETE",
            "payload"        => $payload,
            "module_code"    => "users_privileges",
            "token"          => $token
        ];

        $response = $this->curli->request3($params);

        return json_decode($response, false);
    }
}
