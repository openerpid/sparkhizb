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

class UmmuSiteProject
{
    public function __construct()
    {
        $this->kode = "site_project";
        $this->curli = new CurlHelper();
        $this->gHelp = new GlobalHelper();
        $this->path = 'api/site_project/';
    }

    public function show($params)
    {
        $id = $params['id'];

        if ($id) {
            $show = "show/".$id;
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

    public function delete($params)
    {
        $response = $this->curli->request4(
            [
                "path"           => $this->path. "delete",
                "method"         => "DELETE",
                "payload"        => $params['payload'],
                "module_code"    => $this->kode,
                "token"          => $params['token']
            ]
        );

        return json_decode($response, false);
    }

    public function update($params)
    {
        $id = $params['id'];

        $response = $this->curli->request4(
            [
                "path"           => $this->path. "update/". $id,
                "method"         => "PUT",
                "payload"        => $params['payload'],
                "module_code"    => $this->kode,
                "token"          => $params['token']
            ]
        );

        return json_decode($response, false);
    }
}
