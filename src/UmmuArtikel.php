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

class UmmuArtikel
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
            $path = "api/website/artikel/show/" . $id;
        }else{
            $path = "api/website/artikel/show";
        }

        $params = [
            "path"           => $path,
            "method"         => "GET",
            "payload"        => $payload,
            "module_code"    => "artikel",
            "token"          => $token
        ];

        $response = $this->curli->request3($params);

        return json_decode($response, false);
    }

    public function show_gedung($params)
    {
        $payload = $params['payload'];
        $token = $params['token'];
        
        $path = "api/ruangan/show_gedung";

        $params = [
            "path"           => $path,
            "method"         => "GET",
            "payload"        => $payload,
            "module_code"    => "ruangan",
            "token"          => $token
        ];

        $response = $this->curli->request3($params);

        return json_decode($response, false);
    }

    public function show_roomcateg($params)
    {
        $payload = $params['payload'];
        $token = $params['token'];
        
        $path = "api/ruangan/show_roomcateg";

        $params = [
            "path"           => $path,
            "method"         => "GET",
            "payload"        => $payload,
            "module_code"    => "ruangan",
            "token"          => $token
        ];

        $response = $this->curli->request3($params);

        return json_decode($response, false);
    }

    public function show_gallery($params)
    {
        $payload = $params['payload'];
        $token = $params['token'];
        
        $path = "api/ruangan/show_gallery";

        $params = [
            "path"           => $path,
            "method"         => "GET",
            "payload"        => $payload,
            "module_code"    => "ruangan",
            "token"          => $token
        ];

        $response = $this->curli->request3($params);

        return json_decode($response, false);
    }

    public function insert($params)
    {
        $payload = $params['payload'];
        $token = $params['token'];
        
        $path = "api/ruangan/create";

        $params = [
            "path"           => $path,
            "method"         => "POST",
            "payload"        => $payload,
            "module_code"    => "ruangan",
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
        
        $path = "api/ruangan/update/" . $id;

        $params = [
            "path"           => $path,
            "method"         => "PUT",
            "payload"        => $payload,
            "module_code"    => "ruangan",
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
            $path = "api/ruangan/delete/" . $id;
        }else{
            $path = "api/ruangan/delete";
        }

        $params = [
            "path"           => $path,
            "method"         => "DELETE",
            "payload"        => $payload,
            "module_code"    => "ruangan",
            "token"          => $token
        ];

        $response = $this->curli->request3($params);

        return json_decode($response, false);
    }
}
