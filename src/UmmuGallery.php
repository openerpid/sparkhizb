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

class UmmuGallery
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
            $path = "api/gallery/show/" . $id;
        }else{
            $path = "api/gallery/show";
        }

        $params = [
            "path"           => $path,
            "method"         => "GET",
            "payload"        => $payload,
            "module_code"    => "gallery",
            "token"          => $token
        ];

        $response = $this->curli->request3($params);

        return json_decode($response, false);
    }

    public function insert($params)
    {
        $payload = $params['payload'];
        $token = $params['token'];
        
        $path = "api/gallery/create";

        $params = [
            "path"           => $path,
            "method"         => "POST",
            "payload"        => $payload,
            "module_code"    => "gallery",
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
        
        $path = "api/gallery/update/" . $id;

        $params = [
            "path"           => $path,
            "method"         => "PUT",
            "payload"        => $payload,
            "module_code"    => "gallery",
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
            $path = "api/gallery/delete/" . $id;
        }else{
            $path = "api/gallery/delete";
        }

        $params = [
            "path"           => $path,
            "method"         => "DELETE",
            "payload"        => $payload,
            "module_code"    => "gallery",
            "token"          => $token
        ];

        $response = $this->curli->request3($params);

        return json_decode($response, false);
    }
}
