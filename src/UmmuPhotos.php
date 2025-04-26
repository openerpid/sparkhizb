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

class UmmuPhotos
{
    public function __construct()
    {
        $this->kode = "gallery_photos";
        $this->path = "api/mygallery/photos/";
        $this->curli = new Curl();
    }

    public function show($params)
    {
        $id = $params['id'];
        $payload = $params['payload'];
        $token = $params['token'];
        
        if ($id) {
            $path = $this->path . "show/" . $id;
        }else{
            $path = $this->path . "show";
        }

        $params = [
            "path"           => $path,
            "method"         => "GET",
            "payload"        => $payload,
            "module_code"    => $this->kode,
            "token"          => $token
        ];

        $response = $this->curli->request3($params);

        return json_decode($response, false);
    }

    public function create($params)
    {
        $payload = $params['payload'];
        $token = $params['token'];
        
        $path = $this->path . "create";

        $params = [
            "path"           => $path,
            "method"         => "POST",
            "payload"        => $payload,
            "module_code"    => $this->kode,
            "token"          => $token
        ];

        $response = $this->curli->request3($params);

        return json_decode($response, false);
    }

    public function insert($params)
    {
        return $this->create($params);
    }

    public function upload($params)
    {
        $payload = $params['payload'];
        $token = $params['token'];
        
        $path = $this->path . "upload";

        $params = [
            "path"           => $path,
            "method"         => "POST",
            "payload"        => $payload,
            "module_code"    => $this->kode,
            "token"          => $token
        ];

        $response = $this->curli->request3($params);

        return json_decode($response, false);
    }

    // public function update($params)
    // {
    //     $id = $params['id'];
    //     $payload = $params['payload'];
    //     $token = $params['token'];
        
    //     $path = "api/gallery/update/" . $id;

    //     $params = [
    //         "path"           => $path,
    //         "method"         => "PUT",
    //         "payload"        => $payload,
    //         "module_code"    => "gallery",
    //         "token"          => $token
    //     ];

    //     $response = $this->curli->request3($params);

    //     return json_decode($response, false);
    // }

    public function delete($params)
    {
        $id = $params['id'];
        $payload = $params['payload'];
        $token = $params['token'];
        
        if ($id) {
            $path = $this->path . "delete/" . $id;
        }else{
            $path = $this->path . "delete";
        }

        $params = [
            "path"           => $path,
            "method"         => "DELETE",
            "payload"        => $payload,
            "module_code"    => $this->kode,
            "token"          => $token
        ];

        $response = $this->curli->request3($params);

        return json_decode($response, false);
    }
}
