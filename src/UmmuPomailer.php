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

use Sparkhizb\Helpers\CurlHelper;
use Sparkhizb\Helpers\UmmuHelper;
use Sparkhizb\Helpers\GlobalHelper;

class UmmuPomailer
{
    public function __construct()
    {
        $this->kode = "po_mailer";
        $this->curli = new CurlHelper();
        $this->gHelp = new GlobalHelper();
        $this->path = "api/purchase/po/po_mailer/";
    }

    public function show($params)
    {
        $id = $params['id'];
        
        if ($id) {
            $show = "show/" . $id;
        }else{
            $show = "show";
        }

        $response = $this->curli->request4(
            [
                "path"           => $this->path . $show,
                "method"         => "GET",
                "payload"        => $params['payload'],
                "module_code"    => $this->kode,
                "token"          => $params['token']
            ]
        );

        return json_decode($response, false);
    }

    public function insert($params)
    {
        $response = $this->curli->request4([
            "path"           => $this->path. "create",
            "method"         => "POST",
            "payload"        => $params["payload"],
            "module_code"    => $this->kode,
            "token"          => $params["token"]
        ]);

        return json_decode($response, false);
    }

    // public function update($params)
    // {
    //     $id = $params['id'];
    //     $payload = $params['payload'];
    //     $token = $params['token'];
        
    //     $path = "api/ruangan/update/" . $id;

    //     $params = [
    //         "path"           => $path,
    //         "method"         => "PUT",
    //         "payload"        => $payload,
    //         "module_code"    => "ruangan",
    //         "token"          => $token
    //     ];

    //     $response = $this->curli->request3($params);

    //     return json_decode($response, false);
    // }

    // public function delete($params)
    // {
    //     $id = $params['id'];
    //     $payload = $params['payload'];
    //     $token = $params['token'];
        
    //     if ($id) {
    //         $path = "api/ruangan/delete/" . $id;
    //     }else{
    //         $path = "api/ruangan/delete";
    //     }

    //     $params = [
    //         "path"           => $path,
    //         "method"         => "DELETE",
    //         "payload"        => $payload,
    //         "module_code"    => "ruangan",
    //         "token"          => $token
    //     ];

    //     $response = $this->curli->request3($params);

    //     return json_decode($response, false);
    // }
}
